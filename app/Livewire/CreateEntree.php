<?php

namespace App\Livewire;

use App\Models\Unite;
use App\Models\Article;
use Livewire\Component;
use App\Models\Entrstock;
use App\Models\Methodevs;
use App\Models\Fournisseur;
use Illuminate\Support\Facades\Auth;

class CreateEntree extends Component
{
    public $article_id='0';
    public $recherche_article;
    public $recherche_fournisseur;
    public $fournisseur_id='0';
    public $ent_qte;
    public $ent_prix_achat=0;
    public $ent_prix_vente=0;
    public $ent_date;
    public $ent_observations;
    public $qute_actuelle=0;
    public $prix_achat_actuel=0;
    public $prix_vente_actuel=0;
    public $ar_lib="";
    public $current_unite;
    public $unite="";
    public $ar_unite=1;
    public $current_article=null;
    public $current_fournisseur=null;
    public $ar_prix_achat_total;

    public function mount(){
        $this->ar_prix_achat_total=0;
    }
    public function clickArticle(){
        $this->recherche_article="";
    }
    public function rechercher_article(){

    }
    public function clickFournisseur(){
        $this->recherche_fournisseur='';
    }
    public function rechercher_fournisseur(){
    }

    public function rules()
    {
        $rules = [];
        $rules["article_id"] = "required";
        $rules["ent_prix_achat"] = "numeric|required";
        $rules["ent_prix_vente"] = "numeric|required|gt:0";
        $rules["ent_date"] = "date|required";
        $rules["ent_observations"] = "";
        $rules["ar_prix_achat_total"] = "numeric|required|gt:0";
        if ($this->ar_unite==1) {
            //
            $rules["ent_qte"] = "integer|required|gt:0";
        }
        else {
            $rules["ent_qte"] = "numeric|required|gt:0";
        }
        return $rules;
    }
    public function store(Entrstock $entree)
    {
        $this->validate();
        try {
                    $entree->article_id = $this->article_id;
                    $entree->ent_fournisseur = $this->fournisseur_id;
                    $entree->ent_qte = $this->ent_qte;
                    $entree->ent_prix_achat = $this->ent_prix_achat;
                    $entree->ent_prix_vente = $this->ent_prix_vente;
                    $entree->ent_date = $this->ent_date;
                    $entree->ent_observations = $this->ent_observations ? $this->ent_observations : "achat";
                    $entree->ent_saisi_par = Auth::user()->id;
                    //mise à jour de la quantité du produit
                    // $article=Article::findOrFail($this->article_id);
                    // $nouv_qte=$this->ent_qte;
                    // $encien_qte=$article->ar_qte;
                    // $nouv_PA=$this->ent_prix_achat;
                    // $ancien_PA=$article->ar_prix_achat;
                    // $article->ar_qte=$encien_qte+$nouv_qte;
                    // $article->ar_prix_vente=$this->ent_prix_vente;
                    //enregistrement entree
                    $entree->save();
                    //enregistrement de modifications article
                    // $article->save();
                    //enregistrement de modifications article et valorisation de stock
                    Actualiser_PAA2($entree->article_id,$entree->ent_qte,$entree->ent_prix_achat,$entree->ent_prix_vente);
                    //trace
                    $data="enregistrement de l'entree en stock id ".$entree->id. " ";
                    $model="App\Models\Entrstock";
                    trace($data,$model);
                    //
                    //mise à jour la situation du fournisseur si le fournisseur n pas annonyme 
                    if ($this->current_fournisseur) {
                        $this->current_fournisseur->four_situation+=$this->ar_prix_achat_total;
                        $this->current_fournisseur->save();
                    }
                    return redirect()->route('entrees.index')->with('success', __("L'entrée est enregistrée"));
        } catch (Exception $e) {
            //Sera pris en compte si on a un problème
            return redirect()->route('entrees.index')->with('danger', 'Un problème est rencontré');
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
                                        ->first();
        if ($this->current_article){
            $this->article_id=$this->current_article->id;
        }                                
        //fin 01
        //recherche rapide du fournisseur 02
        if (!empty($this->recherche_fournisseur)){
            $this->fournisseur_id=$this->recherche_fournisseur;
        }
        $this->current_fournisseur=Fournisseur::where('id',$this->fournisseur_id)
                                        ->orWhere('four_tel',$this->fournisseur_id)
                                        ->orWhere('four_email',$this->fournisseur_id)
                                        ->first();
        if ($this->current_fournisseur){
        $this->fournisseur_id=$this->current_fournisseur->id;
        }                                     
        //fin 02
        if ($this->article_id=='0') {
            $this->current_article=null;
        }
        if ($this->fournisseur_id=='0') {
            $this->current_fournisseur=null;
        }
        if(($this->ent_qte)>0){
            $this->ent_prix_achat=(float)$this->ar_prix_achat_total/(float)$this->ent_qte;
        }
        //calcul de l'ancienne valeur de la quantité de l'article
        if($this->current_article){
            $this->ar_lib=$this->current_article->ar_lib;
            $this->qute_actuelle=$this->current_article->ar_qte;
            $this->prix_achat_actuel=$this->current_article->ar_prix_achat;
            $this->prix_vente_actuel=$this->current_article->ar_prix_vente;
        }
        //l'unite de l'article
        if ($this->current_article) {
            // $this->current_article=Article::findOrFail($this->article_id);
            $this->current_unite=Unite::where('id',$this->current_article->ar_unite)->first();
            $this->ar_unite=$this->current_unite->id;
            $this->unite=$this->current_unite->unit_lib;
        }
        $articlesList=Article::orderBy('id')->get();
        $fournisseursList=Fournisseur::orderBy('id')->get();
        $mvs = Methodevs::where('mvs_active','1')->first();
        return view('livewire.create-entree',compact('articlesList','fournisseursList','mvs'));
    }
}
