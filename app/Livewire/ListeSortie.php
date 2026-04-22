<?php

namespace App\Livewire;

use App\Models\Vente;
use App\Models\Article;
use Livewire\Component;
use App\Models\Sortstock;
use Livewire\WithPagination;
use App\Livewire\Traits\WithDelete;

class ListeSortie extends Component
{
    use WithPagination;
    public $search = '';
    // écoute l'événement JS 'confirmDelete'
    use WithDelete {
        delete as protected traitDelete;
    }
    public function delete()
    {
        $sortie=Sortstock::where('id','=',$this->deleteId)->first();
        //annuler une sortie
        $article=Article::where('id',$sortie->article_id)->first();
        $quantite=$sortie->sor_qte;
        $article->ar_qte+=$quantite;
        $article->save();
        $sortie->delete();
         //tracing
         $data="Suppresion de la sortie id ".$sortie->id." ";
         $model="App\Models\Sortstock";
         trace($data,$model);
        return redirect()->route('sorties.index')->with('success', __('Sortie supprimée'));
    }
    public function render()
    {
        if (!empty($this->search)) {
            $sorties = Sortstock::leftJoin('articles','sortstocks.article_id','=','articles.id')
                                 ->select('sortstocks.*','articles.ar_lib')
                                ->where('articles.ar_lib', 'like', '%' . $this->search . '%')
                                ->orWhere('sortstocks.sor_qte', 'like', '%' . $this->search . '%')
                                ->orWhere('sortstocks.sor_prix_achat', 'like', '%' . $this->search . '%')
                                ->orWhere('sortstocks.sor_prix_vente', 'like', '%' . $this->search . '%')
                                ->orWhere('sortstocks.sor_date', 'like', '%' . $this->search . '%')
                                ->orWhere('sortstocks.sor_motif', 'like', '%' . $this->search . '%')
                                ->orWhere('sortstocks.sor_observations', 'like', '%' . $this->search . '%')
                                ->paginate(10);
        }else{
            $sorties = Sortstock::leftJoin('articles','sortstocks.article_id','=','articles.id')
                                 ->select('sortstocks.*','articles.ar_lib')
                                 ->orderByDesc('sortstocks.updated_at')
                                 ->paginate(10);
        }
        return view('livewire.liste-sortie',compact('sorties'));
    }
}
