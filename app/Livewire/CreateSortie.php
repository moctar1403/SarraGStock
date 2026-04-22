<?php

namespace App\Livewire;

use App\Models\Unite;
use App\Models\Article;
use Livewire\Component;
use App\Models\Sortstock;
use App\Models\Fournisseur;
use Illuminate\Support\Facades\Auth;

class CreateSortie extends Component
{
    public $article_id='0';
    public $recherche_article;
    public $sor_qte;
    public $sor_qte_dispo;
    public $sor_prix_achat;
    public $sor_prix_vente;
    public $sor_date;
    public $sor_observations;
    public $sor_motif="perte";
    // public $art;
    public $current_unite;
    public $ar_unite=1;
    public $current_article=null;
    public function clickArticle(){
        $this->recherche_article="";
    }
    public function rechercher_article(){

    }
    public function rules()
    {
        $rules = [];
        // $rules["sor_qte"] = "integer|required|min:1|lte:sor_qte_dispo";
        $rules["article_id"] = "required";
        $rules["sor_date"] = "date|required";
        $rules["sor_observations"] = "";
        $rules["sor_motif"] = "required";
        
        if ($this->ar_unite==1) {
            //
            $rules["sor_qte"] = "integer|required|gt:0|lte:sor_qte_dispo";
        }
        else {
            $rules["sor_qte"] = "numeric|required|gt:0|lte:sor_qte_dispo";
        }
        return $rules;
    }
    public function store(Sortstock $sortie)
    {
        $this->validate();
        if ($this->sor_observations=='') {
            $this->sor_observations=$this->sor_motif;
        }
        try {
                    $sortie->article_id = $this->article_id;
                    $sortie->sor_qte = $this->sor_qte;
                    $sortie->sor_prix_achat = $this->current_article->ar_prix_achat;
                    $sortie->sor_prix_vente = 0;
                    $sortie->sor_montant_t_achat = ($this->sor_qte)*($this->current_article->ar_prix_achat);
                    $sortie->sor_montant_t_vente = 0;
                    $sortie->sor_date = $this->sor_date;
                    $sortie->sor_motif = $this->sor_motif;
                    $sortie->sor_observations = $this->sor_observations;
                    $sortie->sor_saisi_par = Auth::user()->id;
                    //mise à jour de la quantité de l'article
                    $this->current_article->ar_qte-=$this->sor_qte;
                    //enregistrement de modifications
                    $this->current_article->save();
                    $sortie->save();
                    //trace
                    $data="enregistrement de la sortie en stock id ".$sortie->id. " ";
                    $model="App\Models\Sortstock";
                    trace($data,$model);
                    //mise à jour sortie stock

                    return redirect()->route('sorties.index')->with('success', __('La sortie est enregistrée'));
        } catch (Exception $e) {
            //Sera pris en compte si on a un problème
                    return redirect()->route('sorties.index')->with('danger', 'un problème est rencontré, La sortie est annulée');
        }
    }
    public function render()
    {
        //recherche rapide du client 01
        if (!empty($this->recherche_article)){
            $this->article_id=$this->recherche_article;
        }
        $this->current_article=Article::where('id',$this->article_id)
                                        ->orWhere('ar_reference',$this->article_id)
                                        ->orWhere('ar_codebarre',$this->article_id)
                                        ->where('ar_qte','>','0')
                                        ->first();
        if ($this->current_article){
            $this->article_id=$this->current_article->id;
        }                                
        //fin 01
        if ($this->article_id=='0') {
            $this->current_article=null;
        }
        if($this->current_article){
            $this->sor_qte_dispo=$this->current_article->ar_qte;
        }else{
            $this->sor_qte_dispo=0;
        }
        //l'unite de l'article
        if ($this->current_article) {
            $this->current_unite=Unite::where('id',$this->current_article->ar_unite)->first();;
            $this->ar_unite=$this->current_unite->id;
        }
        $articlesList=Article::orderBy('id')->where('ar_qte','>','0')->get();
        return view('livewire.create-sortie',compact('articlesList'));
    }
}
