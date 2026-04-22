<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Article;
use App\Models\Methode;
use Livewire\Component;
use App\Models\Payement;
use App\Models\Remboursement;
use Illuminate\Support\Facades\Auth;

class CreateRemboursement extends Component
{
    public $client_id;
    public $current_client;
    public $current_methode;
    public $montant_actuel=0;
    public $montant_remboursement=0;
    public $rem_type_p;
    public $rem_montant;
    public $rem_date;
    
    public function rules()
    {
        $rules = [];
        $rules["client_id"] = 'required|min:1';
        $rules["rem_montant"] = "required|numeric|min:1|lte:$this->montant_remboursement";
        $rules["rem_type_p"] = 'required';
        $rules["rem_date"] = 'required|date';
        return $rules;
    }
    public function messages(): array
    {
        return[
             'client_id.required' => 'Séléctionner un client',
             'rem_montant.lte' => 'doit être inf ou égal à le montant de la situation du client',
             
        ];
    }
    public function store(Remboursement $remboursement)
    {
        $this->validate();
        try {
            //ajout du remboursement
            $remboursement->client_id=$this->client_id;
            $remboursement->rem_montant=$this->rem_montant*-1;
            $remboursement->rem_type_p=$this->rem_type_p;
            $remboursement->rem_date=$this->rem_date;
            $remboursement->save();
            //actualisation de la situation de client
            $this->current_client->cli_situation+=(float)$this->rem_montant;
            $this->current_client->save();
            //actualisation du solde réel de la méthode
            $this->current_methode->meth_solde-=(float)$this->rem_montant;
            $this->current_methode->save();

        return redirect()->route('remboursements.index')->with('success', 'Le remboursement est enregistré');
        } catch (Exception $e) {
            //Sera pris en compte si on a un problème
        }
    }
    public function render()
    {
        if($this->client_id!=0){
            $this->current_client=Client::where('id',$this->client_id)->first();
            $this->montant_actuel=$this->current_client->cli_situation;
            if($this->montant_actuel<0){
                $this->montant_remboursement=$this->montant_actuel*-1;
            }
        }
        $this->current_methode=Methode::where('id',$this->rem_type_p)->first();
        $clientsList=Client::where('id','!=','0')
                            ->where('cli_situation','<','0')
                            ->orderBy('id')
                            ->get();
        $methodesList=Methode::where('meth_active','>','0')
                            ->where('meth_nom','not like','credit')
                            ->get();  
        return view('livewire.create-remboursement',compact('clientsList','methodesList'));
    }
}
