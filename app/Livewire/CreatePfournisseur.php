<?php

namespace App\Livewire;

use App\Models\Fournisseur;
use App\Models\Operat;
use App\Models\Article;
use App\Models\Methode;
use Livewire\Component;
use App\Models\Payfournisseur;
use Illuminate\Support\Facades\Auth;

class CreatePfournisseur extends Component
{
    public $fournisseur_id;
    public $current_fournisseur;
    public $current_methode;
    public $credit_methode;
    public $montant_actuel=0;
    public $fpay_type_p;
    public $fpay_montant;
    public $montant_total=0;
    public $fpay_frais=0;
    public $fpay_date;
    public $recherche_fournisseur;
    
    public function rules()
    {
        $rules = [];
        $rules["fournisseur_id"] = 'required|min:1';
        $rules["fpay_montant"] = "required|numeric|min:1|lte:$this->montant_actuel";
        $rules["fpay_frais"] = "required|numeric|lte:$this->fpay_montant";
        $rules["fpay_type_p"] = 'required';
        $rules["fpay_date"] = 'required|date';
        return $rules;
    }
    public function messages(): array
    {
        return[
             'fournisseur_id.required' => __("Séléctionner un fournisseur"),
             'fpay_montant.lte' => __("doit être inf ou égal au montant de la situation du fournisseur"),
        ];
    }
    public function select_fournisseur(){
        $this->recherche_fournisseur='';
    }
    public function rechercher_fournisseur(){
    }
    public function store(Payfournisseur $paiement)
    {
        $this->validate();
        try {
            //ajout du paiement
            $paiement->fournisseur_id=$this->current_fournisseur->id;
            $paiement->fpay_montant=$this->fpay_montant;
            $paiement->fpay_frais=$this->fpay_frais;
            $paiement->fpay_type_p=$this->fpay_type_p;
            $paiement->fpay_date=$this->fpay_date;
            $paiement->save();
             //trace
             $data="enregistrement du paiement id ".$paiement->id. " ";
             $model="App\Models\Payfournisseur";
             trace($data,$model);
            //actualisation de la situation de fournisseur
            $this->current_fournisseur->four_situation-=(float)$this->fpay_montant;
            $this->current_fournisseur->save();
            $this->montant_total=(float)$this->fpay_montant+(float)$this->fpay_frais;
            //actualisation du solde réel de la méthode
            $this->current_methode->meth_solder-=$this->montant_total;
            $this->current_methode->save();
            //actualisation du solde réel de la méthode credit
            // $this->credit_methode->meth_solder-=(float)$this->fpay_montant;
            // $this->credit_methode->save();
            //actualisation de la table operats
            //la méthode de paiement
            $operat1=Operat::create([
                'operat_meth_id'=>$this->current_methode->id,
                'operat_vent_id'=>'0',
                'operat_tr_id'=>'0',
                'operat_pa_cli_id'=>'0',
                'operat_pa_four_id'=>$paiement->id,
                'operat_montant'=>($this->montant_total)*-1,
            ]);
            $operat1->save();
            //actualisation de la table operats
            //la méthode credit
            // $operat2=Operat::create([
            //     'operat_meth_id'=>$this->credit_methode->id,
            //     'operat_vent_id'=>'0',
            //     'operat_tr_id'=>'0',
            //     'operat_pa_id'=>$paiement->id,
            //     'operat_montant'=>($paiement->fpay_montant)*-1,
            // ]);
            // $operat2->save();

        return redirect()->route('fournisseurs.pindex')->with('success', __('Le paiement est enregistré'));
    } catch (Exception $e) {
        //Sera pris en compte si on a un problème
        return redirect()->route('fournisseurs.pindex')->with('danger', 'Un problème est rencontré');
        }
    }
    public function render()
    {
        if ($this->fpay_frais==null) {
            $this->fpay_frais=0;
        }
        //recherche rapide du fournisseur 02
        if (!empty($this->recherche_fournisseur)){
            $this->fournisseur_id=$this->recherche_fournisseur;
        }
        ///////////
        $this->current_fournisseur=Fournisseur::where('id',$this->fournisseur_id)
                                        ->orWhere('four_tel',$this->fournisseur_id)
                                        ->orWhere('four_email',$this->fournisseur_id)
                                        ->first();           
        if($this->current_fournisseur){
            $this->fournisseur_id=$this->current_fournisseur->id;
            $this->montant_actuel=$this->current_fournisseur->four_situation;
        }
        //selectionner la méthode courante de paiement
        $this->current_methode=Methode::where('id',$this->fpay_type_p)->first();
        //selectionner la méthode credit
        $this->credit_methode=Methode::where('meth_nom','like','credit')->first();
        $fournisseursList=Fournisseur::where('id','!=','0')
                            ->where('four_situation','>','0')
                            ->orderBy('id')
                            ->get();
        $methodesList=Methode::where('meth_active','>','0')
                                ->where('meth_nom','not like','credit')
                                ->get();                   
        return view('livewire.create-pfournisseur',compact('fournisseursList','methodesList'));
    }
}
