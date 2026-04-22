<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

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
        $this->ar_unite= $this->article->ar_unite;
    }
    public function rules()
    {
        $rules = [];
        $rules["ar_reference"] = "string|required|unique:articles,ar_reference,".$this->article->id;
        $rules["ar_lib"] = "string|required|unique:articles,ar_lib,".$this->article->id;
        $rules["ar_description"] ="string|required|unique:articles,ar_description,".$this->article->id;
        $rules["ar_qte_mini"] = "integer|required|gt:0";
        $rules["ar_prix_vente"] = "numeric|required|gt:0";
        $rules["ar_prix_achat"] = "numeric|required|gt:0";
        //ar_reference rules
        if ($this->ar_reference=='') {
            $rules["ar_reference"] = "";
        }
        else {
            $rules["ar_reference"] = "string|required|unique:articles,ar_reference,".$this->article->id;
        }
        //CB ar_codebarre rules
        if ($this->ar_codebarre=='') {
            $rules["ar_codebarre"] = "";
        }
        else {
            $rules["ar_codebarre"] = "integer|unique:articles,ar_codebarre,".$this->article->id;
        }
        //Qte rules
        if ($this->ar_unite==1) {
            $rules["ar_qte"] = "integer|required";
        }
        else {
            $rules["ar_qte"] = "numeric|required";
        }
        return $rules;
    }
    public function store(Article $article)
    {
        $article=Article::find($this->article->id);
        $this->validate();
        try {
                $article->update([
                    'ar_reference' => $this->ar_reference,
                    'ar_codebarre' => $this->ar_codebarre,
                    'ar_lib' => $this->ar_lib,
                    'ar_description' => $this->ar_description,
                    'ar_qte' => $this->ar_qte,
                    'ar_qte_mini' => $this->ar_qte_mini,
                    'ar_prix_achat' => $this->ar_prix_achat,
                    'ar_prix_vente' => $this->ar_prix_vente,
                ]);
            return redirect()->route('articles.index')->with('success', __('Article mis à jour'));
        } catch (Exception $e) {
            //Sera pris en compte si on a un problème
            return redirect()->route('articles.index')->with('danger', 'Un problème est rencontré');
        }
    }

    public function render()
    {
        if ($this->ar_unite==1) {
            $this->ar_qte= (int)$this->ar_qte;
        }
        return view('livewire.edit-article');
    }
}
