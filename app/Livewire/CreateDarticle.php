<?php

namespace App\Livewire;

use App\Models\Unite;
use App\Models\Article;
use Livewire\Component;
use App\Models\Darticle;
use App\Models\Entrstock;
use App\Models\Sortstock;
use App\Models\Fournisseur;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CreateDarticle extends Component
{
    public $dar_principal='0';
    public $dar_detail='0';
    public $dar_qte;
    public $recherche_article;
    public $recherche_article2;
    public $current_article1=null;
    public $current_article2=null;
    public function clickArticle(){
        $this->recherche_article="";
    }
    public function clickArticle2(){
        $this->recherche_article2="";
    }
    public function rechercher_article(){
        // $this->dar_principal='';
    }
    public function rechercher_article2(){
        // $this->dar_principal='';
    }
    public function rules()
    {
        $rules = [];
        $rules["dar_principal"] = "required|gt:0|".Rule::unique('darticles')->where('dar_detail', $this->dar_detail);
        $rules["dar_detail"] = "required|gt:0";
        $rules["dar_qte"] = "required";
        return $rules;
    }
     public function messages(): array
    {
        return[
             'dar_principal.gt' => __("Article principal est requis"),
             'dar_detail.gt' => __("Article détail est requis"),
        ];

    }
    public function store(Darticle $darticle)
    {
        $this->validate();
        try {  
                $darticle->dar_principal = $this->dar_principal;
                $darticle->dar_detail = $this->dar_detail;
                $darticle->dar_qte = $this->dar_qte;
                $darticle->save();
                //trace
                $data="operation de configuration de detail article ";
                $model="App\Models\Darticle";
                trace($data,$model);
                //fin trace
                //retour     
                return redirect()->route('darticles.index')->with('success', __('La configuration détail article est enregistrée'));     
        } catch (Exception $e) {
            //Sera pris en compte si on a un problème
                    return redirect()->route('darticles.index')->with('danger', 'un problème est rencontré, La sortie est annulée');
        }
    }
    public function render()
    {
        //recherche rapide du article 01
        if (!empty($this->recherche_article)){
            $this->dar_principal=$this->recherche_article;
        }
        //recherche rapide du article 02
        if (!empty($this->recherche_article2)){
            $this->dar_detail=$this->recherche_article2;
        }
        $this->current_article1=Article::where('id',$this->dar_principal)
                                        ->orWhere('ar_reference',$this->dar_principal)
                                        ->orWhere('ar_codebarre',$this->dar_principal)
                                        ->first();
        $this->current_article2=Article::where('id',$this->dar_detail)
                                        ->first();
        if ($this->current_article1){
            $this->dar_principal=$this->current_article1->id;
        }                                
        if ($this->current_article2){
            $this->dar_detail=$this->current_article2->id;
        }                                
        //fin 01 .. // fin 02
        if ($this->dar_principal=='0') {
            $this->current_article1=null;
        }
        if ($this->dar_detail=='0') {
            $this->current_article2=null;
        }
        if($this->current_article1){
            // $this->sor_qte_dispo=$this->current_article1->ar_qte;
        }else{
            // $this->sor_qte_dispo=0;
        }
        if ($this->current_article2) {
            // $this->current_unite2=Unite::where('id',$this->current_article2->ar_unite)->first();
            // $this->ar_unite2=$this->current_unite2->id;
        }
        $articlesList=Article::orderBy('id')->get();
        $articlesList2=Article::where('id','!=',$this->dar_principal)->orderBy('id')->get();
        return view('livewire.create-darticle',compact('articlesList','articlesList2'));
    }
}
