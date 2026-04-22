<?php

namespace App\Livewire;

use App\Models\Unite;
use App\Models\Article;
use Livewire\Component;
use App\Models\Darticle;
use App\Models\Entrstock;
use App\Models\Sortstock;
use App\Models\Fournisseur;
use App\Models\Listedetail;
use App\Livewire\Traits\WithConfirmAction;
use Illuminate\Support\Facades\Auth;

class CreateSortied extends Component
{
    use WithConfirmAction;
    
    public $article_id1='0';
    public $article_id2='0';
    public $article_id3='0';
    public $recherche_article;
    public $sor_qte=0;
    public $ent_qte2;
    public $ent_qte2_par_1;
    public $sor_qte_dispo;
    public $sor_prix_achat;
    public $sor_prix_vente;
    public $sor_date;
    public $sor_observations;
    public $ent_observations;
    public $nprix_achat;
    public $nprix_vente;
    public $current_unite1;
    public $current_unite2;
    public $ar_unite1=1;
    public $ar_unite2=1;
    public $current_article1=null;
    public $current_article2=null;
    public $current_darticle=null;
    
    // Surchargez le message de confirmation
    protected function confirmActionMessage(): string
    {
        return __("Attention, cette opération est irréversible !!");
    }
    
    // Surchargez la méthode confirmStore
    public function confirmStore()
    {
        $this->actionConfirmed = true;
        $this->store(new Sortstock());
    }
    
    public function clickArticle(){
        $this->recherche_article="";
    }
    
    public function confirmer(){
        $this->render();
    }
    
    public function rechercher_article(){
        // $this->article_id1='';
    }
    
    public function rules()
    {
        $rules = [];
        $rules["sor_qte"] = "integer|required|min:1|lte:sor_qte_dispo";
        $rules["article_id1"] = "required|gt:0";
        $rules["sor_date"] = "date|required";
        $rules["sor_observations"] = "";
        return $rules;
    }
    
    public function store(Sortstock $sortie)
    {
        //d'abord la validation 
        $this->validate();
        // Si l'action n'a pas été confirmée via le modal, on demande confirmation
        if (!$this->actionConfirmed) {
            $this->askConfirmAction();
            return;
        }
        $this->sor_observations='detail';
        $this->ent_observations='detail';
        
        try {
            //enregistrement liste detail
                    $listedetail= new Listedetail;
                    $listedetail_id=$listedetail->id;
                    $listedetail->lds_principal=$this->current_article1->id;
                    $listedetail->lds_detail=$this->current_article2->id;
                    $listedetail->lds_qte_pr=$this->sor_qte;
                    $listedetail->lds_qte_pr_par_ds=$this->ent_qte2_par_1;
                    $listedetail->lds_qte_ds=$this->ent_qte2;
                    $listedetail->save();
                //Enregistrement sortie Article 1
                    $sortie->article_id = $this->current_article1->id;
                    $sortie->sor_qte = $this->sor_qte;
                    $sortie->sor_prix_achat = $this->current_article1->ar_prix_achat;
                    $sortie->sor_prix_vente = 0;
                    $sortie->sor_montant_t_achat = ($this->sor_qte)*($this->current_article1->ar_prix_achat);
                    $sortie->sor_montant_t_vente = 0;
                    $sortie->sor_date = $this->sor_date;
                    $sortie->sor_motif ='detail';
                    $sortie->iddetail =$listedetail->id;
                    $sortie->sor_observations = $this->sor_observations;
                    $sortie->sor_saisi_par = Auth::user()->id;
                //mise à jour de la quantité de l'article 1
                    $this->current_article1->ar_qte-=$this->sor_qte;
                //enregistrement de modifications
                    $this->current_article1->save();
                    $sortie->save();
                //mise à jour sortie stock .......???????????
                //fin Enregistrement sortie Article 1
                //Enregistrement entree Article 2
                    $entree= new Entrstock;
                    $entree->article_id = $this->current_article2->id;
                    $entree->ent_fournisseur = 0;
                    $entree->ent_qte = $this->ent_qte2;
                    $entree->ent_prix_achat = $this->nprix_achat;
                    $entree->ent_prix_vente = $this->nprix_vente;
                    $entree->ent_date = $this->sor_date;
                    $entree->ent_observations = $this->ent_observations;
                    $entree->ent_motif ='detail';
                    $entree->iddetail =$listedetail->id;
                    $entree->ent_saisi_par = Auth::user()->id;
                    
                //enregistrement de L'entree
                    $entree->save();
                
                //fin enregistrement liste detail    
                //mise à jour de de l'article 2
                    Actualiser_PAA2($entree->article_id,$entree->ent_qte,$entree->ent_prix_achat,$entree->ent_prix_vente);
                //fin Enregistrement entree Article 2
                //trace
                    $data="operation de detail article ".$this->current_article1->ar_lib." en article ".$this->current_article2->ar_lib." avec enregistrement de la sortie en stock id ".$sortie->id. " et entree ".$entree->id." ";
                    $model="App\Models\Sortstock";
                    trace($data,$model);
                //fin trace
            $this->actionConfirmed = false;
            return redirect()->route('listedetails.operation')->with('success', __("L'opération est enregistrée"));     
        } catch (Exception $e) {
            $this->actionConfirmed = false;
            return redirect()->route('listedetails.index')->with('danger', 'un problème est rencontré, La sortie est annulée');
        }
    }
    
    // ... reste de votre component ...
    public function render()
    {
        //recherche rapide du client 01
        //a voir apres
        if (!empty($this->recherche_article)){
            $this->article_id1=$this->recherche_article;
        }
        $this->current_darticle=Darticle::where('id',$this->article_id1)->first();
        if ($this->current_darticle) {
            $this->current_article1=Article::where('id',$this->current_darticle->dar_principal)
                                        ->orWhere('ar_reference',$this->current_darticle->dar_principal)
                                        ->orWhere('ar_codebarre',$this->current_darticle->dar_principal)
                                        ->first();

            $this->current_article2=Article::where('id',$this->article_id2)->first();  
            // dd($this->current_article1)                            
        }                            
        if (($this->article_id1)!='0') {
            $this->current_darticle=Darticle::where('id',$this->article_id1)->first();
            $this->article_id2=$this->current_darticle->dar_detail;
            $this->sor_qte_dispo=$this->current_article1->ar_qte;
            // $this->current_article11=Article::where('id',$this->current_darticle->dar_principal)->first();
            $this->current_article2=Article::where('id',$this->article_id2)->first();
            $this->article_id3=$this->current_article2->ar_lib;
            $this->ent_qte2_par_1=$this->current_darticle->dar_qte;
            $this->ent_qte2=$this->ent_qte2_par_1*(int)$this->sor_qte;
            $this->nprix_achat=($this->current_article1->ar_prix_achat)/$this->ent_qte2_par_1;
            $this->nprix_vente=$this->current_article2->ar_prix_vente;
        }
        if ($this->article_id1=='0') {
            $this->current_article1=null;
            $this->article_id2='0';
            $this->article_id3='0';
        }
        if ($this->article_id2=='0') {
            $this->current_article2=null;
        }
        //finnnnnnnnnnnnnnnnn caaaaaaaaaaaaaaa
        $articlesList=Darticle::orderBy('id')->get();
        return view('livewire.create-sortied',compact('articlesList'));
    }
}
