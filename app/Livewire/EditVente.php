<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;
use App\Models\Vente;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EditVente extends Component
{
    public $vente;
    public $article_id;
    public $client_id;
    public $ve_quantite;
    public $qte_dispo;
    public $ve_prix;
    public $ve_prix_tot;

    public function mount()
    {
        $this->article_id = $this->vente->article_id;
        $this->qte_dispo =Article::find($this->article_id)->ar_qte;
        $this->client_id = Client::find($this->vente->ve_client)->id;
        $this->ve_quantite = $this->vente->ve_quantite;
        $this->ve_prix = $this->vente->ve_prix;
        $this->ve_prix_tot = $this->vente->ve_prix_tot;
    }

    public function store()
    {
        $vente2=Vente::find($this->vente->id);
        $article=Article::find($this->article_id);
        $this->validate([
            'article_id' => 'required',
            'client_id' => 'required',
            've_quantite' => 'integer|required|lte:qte_dispo|min:1',
            'qte_dispo' => 'integer|required',
            've_prix' => 'numeric|required',
            've_prix_tot' => 'numeric|required',
        ]);
        if($this->ve_quantite==$vente2->ve_quantite) 
            {
                return redirect()->route('ventes.index')->with('success', 'Vente est mise à jour');
            }
        try {
                $article->update([
                    'ar_qte' => $article->ar_qte+$vente2->ve_quantite-$this->ve_quantite,
                ]);
                $vente2->update([
                    'article_id' => $this->article_id,
                    've_client' => $this->client_id,
                    've_quantite' => $this->ve_quantite,
                    've_prix' => $this->ve_prix,
                    've_prix_tot' => $this->ve_prix_tot,
                ]);
            return redirect()->route('ventes.index')->with('success', 'Vente est mise à jour');
        } catch (Exception $e) {
            //Sera pris en compte si on a un problème
        }
    }

    public function render()
    {
        $this->ve_prix_tot = (float)$this->vente->ve_prix*(float)$this->ve_quantite;
        $articlesList=Article::all();
        $clientsList=Client::all();
        return view('livewire.edit-vente',compact('articlesList','clientsList'));
    }
}
