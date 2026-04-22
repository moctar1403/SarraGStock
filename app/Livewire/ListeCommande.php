<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vente;
use App\Models\Article;
use App\Models\Commande;
use Livewire\WithPagination;

class ListeCommande extends Component
{
    use WithPagination;
    public $search = '';
    public function delete(Commande $commande)
    {
        $commande->delete();
         //tracing
         $data="Suppresion de la commande ".$commande->id;
         $model="App\Models\Commande";
         trace($data,$model);
        return redirect()->route('commandes.index')->with('success', 'commande supprimée');
    }
    public function print(Commande $commande)
    {
        // $commande->delete();
        // return redirect()->route('commandes.index')->with('success', 'commande supprimée');
    }
    public function render()
    {
        if (!empty($this->search)) {
            $commandes = Commande::leftJoin('articles','commandes.article_id','=','articles.id')
                                ->leftJoin('clients','commandes.client_id','=','clients.id')
                                ->where('articles.nom_article', 'like', '%' . $this->search . '%')
                                ->orWhere('clients.nom', 'like', '%' . $this->search . '%')
                                ->orWhere('commandes.client_id', 'like', '%' . $this->search . '%')
                                ->orWhere('commandes.ve_quantite', 'like', '%' . $this->search . '%')
                                ->orWhere('commandes.ve_prix', 'like', '%' . $this->search . '%')
                                ->orWhere('commandes.updated_at', 'like', '%' . $this->search . '%')
                                ->paginate(10);
        }else{
            $commandes = commande::paginate(10);
            //dd($commandes);
        }
        return view('livewire.liste-commande',compact('commandes'));
    }
}
