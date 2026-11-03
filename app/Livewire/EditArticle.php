<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;
use App\Models\Categorie;
use Illuminate\Support\Facades\Auth;
use Exception;

class EditArticle extends Component
{
    public $article;
    public $ar_reference;
    public $ar_lib;
    public $ar_description;
    public $ar_codebarre;
    public $ar_qte;
    public $ar_qte_mini;
    public $ar_prix_achat;
    public $ar_prix_vente;
    public $ar_unite;
    
    public $categorie_id;
    public $gerer_stock;

    public function mount()
    {
        $this->ar_reference = $this->article->ar_reference;
        $this->ar_lib = $this->article->ar_lib;
        $this->ar_description = $this->article->ar_description;
        $this->ar_codebarre = $this->article->ar_codebarre;
        $this->ar_qte = $this->article->ar_qte;
        $this->ar_qte_mini = $this->article->ar_qte_mini;
        $this->ar_prix_achat = $this->article->ar_prix_achat;
        $this->ar_prix_vente = $this->article->ar_prix_vente;
        $this->ar_unite = $this->article->ar_unite;
        
        $this->categorie_id = $this->article->categorie_id;
        // On fige la valeur d'origine
        $this->gerer_stock = $this->article->gerer_stock; 
    }

    public function rules()
    {
        $rules = [];
        $rules["ar_lib"] = "string|required|unique:articles,ar_lib,".$this->article->id;
        $rules["ar_description"] = "string|required"; 
        $rules["ar_prix_vente"] = "numeric|required|gt:0";
        
        // On utilise $this->article->gerer_stock (la valeur d'origine) pour valider
        if ($this->article->gerer_stock) {
            $rules["ar_qte_mini"] = "integer|required|gt:0";
            $rules["ar_prix_achat"] = "numeric|required|gt:0";
            
            if ($this->ar_unite == 1) {
                $rules["ar_qte"] = "integer|required|gt:0"; 
            } else {
                $rules["ar_qte"] = "numeric|required|gt:0";
            }
        } else {
            // Si c'est un plat (pas de gestion de stock), la catégorie est obligatoire
            $rules["categorie_id"] = "required|exists:categories,id";
        }
    
        // Référence et Code barre optionnels
        if ($this->ar_reference != '') {
            $rules["ar_reference"] = "string|unique:articles,ar_reference,".$this->article->id;
        }
        if ($this->ar_codebarre != '') {
            $rules["ar_codebarre"] = "integer|unique:articles,ar_codebarre,".$this->article->id;
        }
    
        return $rules;
    }

    public function store(Article $article)
    {
        $article = Article::find($this->article->id);
        $this->validate();
        
        try {
            $dataToUpdate = [
                'ar_reference' => $this->ar_reference,
                'ar_codebarre' => $this->ar_codebarre,
                'ar_lib' => $this->ar_lib,
                'ar_description' => $this->ar_description,
                'ar_prix_vente' => $this->ar_prix_vente,
                'categorie_id' => $this->categorie_id !== '' ? $this->categorie_id : null,
            ];

            // On met à jour les champs de stock uniquement si c'est un article de stock
            if ($this->article->gerer_stock) {
                $dataToUpdate['ar_qte'] = $this->ar_qte;
                $dataToUpdate['ar_qte_mini'] = $this->ar_qte_mini;
                $dataToUpdate['ar_prix_achat'] = $this->ar_prix_achat;
            }

            $article->update($dataToUpdate);
            return redirect()->route('articles.index')->with('success', __('Article mis à jour'));
        } catch (Exception $e) {
            return redirect()->route('articles.index')->with('danger', 'Un problème est rencontré');
        }
    }

    public function render()
    {
        if ($this->ar_unite == 1) {
            $this->ar_qte = (int)$this->ar_qte;
        }
        
        $categoriesListe = Categorie::all();
        
        return view('livewire.edit-article', compact('categoriesListe'));
    }
}