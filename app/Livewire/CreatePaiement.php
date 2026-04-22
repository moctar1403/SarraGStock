<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Operat;
use App\Models\Article;
use App\Models\Methode;
use Livewire\Component;
use App\Models\Payement;
use Illuminate\Support\Facades\Auth;

class CreatePaiement extends Component
{
    public $client_id;
    public $current_client;
    public $current_methode;
    public $credit_methode;
    public $montant_actuel=0;
    public $pay_type_p;
    public $pay_montant;
    public $pay_date;
    public $recherche_client;
    

    public function rules()
    {
        $rules = [];
        $rules["client_id"] = 'required|min:1';
        $rules["pay_montant"] = "required|numeric|min:1|lte:$this->montant_actuel";
        $rules["pay_type_p"] = 'required';
        $rules["pay_date"] = 'required|date';
        return $rules;
    }
    public function messages(): array
    {
        return[
             'client_id.required' => __("Séléctionner un client"),
             'pay_montant.lte' => __("doit être inf ou égal au montant de la situation du client"),
             
        ];
    }
    public function store(Payement $paiement)
    {
        $this->validate();
        try {
            //ajout du paiement
            $paiement->client_id=$this->current_client->id;
            $paiement->pay_montant=$this->pay_montant;
            $paiement->pay_type_p=$this->pay_type_p;
            $paiement->pay_date=$this->pay_date;
            $paiement->save();
             //trace
             $data="enregistrement du paiement id ".$paiement->id. " ";
             $model="App\Models\Payement";
             trace($data,$model);
            //actualisation de la situation de client
            $this->current_client->cli_situation-=(float)$this->pay_montant;
            $this->current_client->save();
            //actualisation du solde réel de la méthode
            $this->current_methode->meth_solder+=(float)$this->pay_montant;
            $this->current_methode->save();
            //actualisation du solde réel de la méthode credit
            $this->credit_methode->meth_solder-=(float)$this->pay_montant;
            $this->credit_methode->save();
            //actualisation de la table operats
            //la méthode de paiement
            $operat1=Operat::create([
                'operat_meth_id'=>$this->current_methode->id,
                'operat_vent_id'=>'0',
                'operat_tr_id'=>'0',
                'operat_pa_cli_id'=>$paiement->id,
                'operat_pa_four_id'=>'0',
                'operat_montant'=>$paiement->pay_montant,
            ]);
            $operat1->save();
            //actualisation de la table operats
            //la méthode credit
            $operat2=Operat::create([
                'operat_meth_id'=>$this->credit_methode->id,
                'operat_vent_id'=>'0',
                'operat_tr_id'=>'0',
                'operat_pa_cli_id'=>$paiement->id,
                'operat_pa_four_id'=>'0',
                'operat_montant'=>($paiement->pay_montant)*-1,
            ]);
            $operat2->save();

        return redirect()->route('paiements.index')->with('success', __('Le paiement est enregistré'));
    } catch (Exception $e) {
        //Sera pris en compte si on a un problème
        return redirect()->route('paiements.index')->with('danger', 'Un problème est rencontré');
        }
    }
    public function select_client(){
        $this->recherche_client='';
    }
    public function rechercher_client(){
    }
    public function render()
    {
        //recherche rapide du client
        if (!empty($this->recherche_client)){
            $this->client_id=$this->recherche_client;
        }
         ///////////
         $this->current_client=Client::where('cli_situation','>','0')
                                        ->where('id',$this->client_id)
                                        ->orWhere('cli_tel',$this->client_id)
                                        ->orWhere('cli_email',$this->client_id)
                                        ->first();
        if($this->current_client){
            $this->client_id=$this->current_client->id;
            $this->montant_actuel=$this->current_client->cli_situation;
        }
        //selectionner la méthode courante de paiement
        $this->current_methode=Methode::where('id',$this->pay_type_p)->first();
        //selectionner la méthode credit
        $this->credit_methode=Methode::where('meth_nom','like','credit')->first();
        $clientsList=Client::where('id','!=','0')
                            ->where('cli_situation','>','0')
                            ->orderBy('id')
                            ->get();
        $methodesList=Methode::where('meth_active','>','0')
                                ->where('meth_nom','not like','credit')
                                ->get();                   
        return view('livewire.create-paiement',compact('clientsList','methodesList'));
    }
}
