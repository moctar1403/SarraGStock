<?php

namespace App\Livewire;

use App\Models\Unite;
use App\Models\Sunite;
use App\Models\Article;
use App\Models\Categorie; // <-- NOUVEAU
use Livewire\Component;
use App\Models\Entrstock;
use Illuminate\Support\Facades\Auth;

class CreateArticle extends Component
{
    public $ar_reference="";
    public $ar_lib;
    public $ar_description;
    public $ar_codebarre="";
    public $ar_qte;
    public $ar_qte_mini;
    public $ar_prix_vente;
    public $ar_prix_achat;
    public $ar_prix_achat_total;
    public $ar_unite;
    public $ar_unite2;
    public $ar_s_unite;
    public $ar_s_unite2;
    
    // NOUVEAU
    public $categorie_id = "";
    public $gerer_stock = false;

    public function mount(){
        $this->ar_unite=1;
        $this->ar_s_unite=1;
        $this->ar_prix_achat_total=0;
        $this->ar_prix_achat=0;
    }
    public function updatedGererStock($value)
    {
        if (!$value) {
            // Si on ne gère pas le stock (Resto), on force l'unité à 1 (Unité)
            $this->ar_unite = 1;
        }
    }

    public function rules()
    {
        $rules = [];
        $rules["ar_lib"] = "string|required|unique:articles,ar_lib";
        $rules["ar_description"] = "string|required";
        $rules["ar_prix_vente"] = "numeric|required|gt:0";
        
        // Si on gère le stock, les champs de quantité et prix sont obligatoires
        if ($this->gerer_stock) {
            $rules["ar_qte_mini"] = "integer|required|gt:0";
            $rules["ar_prix_achat"] = "numeric|required|gt:0";
            $rules["ar_prix_achat_total"] = "numeric|required|gt:0";
            
            if ($this->ar_unite==1) {
                $rules["ar_qte"] = "integer|required|gt:0";
            } else {
                $rules["ar_qte"] = "numeric|required|gt:0";
            }
        } else {
            // Si on ne gère pas le stock (Resto), la catégorie est OBLIGATOIRE
            $rules["categorie_id"] = "required|exists:categories,id";
            $rules["ar_qte"] = "";
            $rules["ar_qte_mini"] = "";
            $rules["ar_prix_achat"] = "";
            $rules["ar_prix_achat_total"] = "";
        }

        // Référence et code barre
        if ($this->ar_reference != '') {
            $rules["ar_reference"] = "string|unique:articles,ar_reference";
        }
        if ($this->ar_codebarre != '') {
            $rules["ar_codebarre"] = "integer|unique:articles,ar_codebarre";
        }
        
        return $rules;
    }

    public function store(Article $article, Entrstock $entree)
    {    
        $this->validate();
        
        try {
            $article->ar_reference = $this->ar_reference;
            $article->ar_lib = $this->ar_lib;
            $article->ar_description = $this->ar_description;
            $article->ar_codebarre = $this->ar_codebarre;
            
            $article->categorie_id = $this->categorie_id !== '' ? $this->categorie_id : null; 
            $article->gerer_stock = $this->gerer_stock;

            if ($this->gerer_stock) {
                $article->ar_qte = $this->ar_qte;
                $article->ar_qte_mini = $this->ar_qte_mini;
                $article->ar_prix_achat = $this->ar_prix_achat;
            } else {
                // Si on ne gère pas le stock, on met 9999 par défaut
                $article->ar_qte = 0;
                $article->ar_qte_mini = 0;
                $article->ar_prix_achat = 0;
            }

            $article->ar_unite = $this->ar_unite;
            $article->ar_prix_vente = $this->ar_prix_vente;
            $article->ar_saisi_par = Auth::user()->id;
            $article->save();

            // Tracing
            $data = "enregistrement de l'article id " . $article->id . " nom " . $article->ar_lib;
            $model = "App\Models\Article";
            trace($data, $model);

            // Création de l'entrée en stock UNIQUEMENT si on gère le stock
            if ($this->gerer_stock) {
                $entree->article_id = $article->id;
                $entree->ent_fournisseur = 0;
                $entree->ent_qte = $article->ar_qte;
                $entree->ent_prix_achat = $article->ar_prix_achat;
                $entree->ent_prix_vente = $article->ar_prix_vente;
                $entree->ent_date = $article->created_at;
                $entree->ent_observations = "achat initial";
                $entree->ent_saisi_par = Auth::user()->id;
                $entree->save();
            }

            return redirect()->route('articles.index')->with('success', __('Article ajouté avec succès'));
        } catch (Exception $e) {
            return redirect()->route('articles.index')->with('danger', 'Il y a un problème');
        }
    }

    public function render()
    {
        if ($this->gerer_stock && $this->ar_qte > 0) {
            $this->ar_prix_achat = (float)$this->ar_prix_achat_total / (float)$this->ar_qte;
        }

        $this->ar_unite2 = Unite::where('id', $this->ar_unite)->first();
        $this->ar_s_unite2 = Sunite::where('id', $this->ar_s_unite)->first();
        
        $unitesListe = Unite::all();
        $sunitesListe = Sunite::where('sunit_unite_id', $this->ar_unite)->get();
        $categoriesListe = Categorie::all(); // <-- NOUVEAU

        return view('livewire.create-article', compact('unitesListe', 'sunitesListe', 'categoriesListe'));
    }
}