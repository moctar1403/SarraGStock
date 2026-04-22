<?php

namespace App\Livewire;

use App\Models\Vente;
use App\Models\Article;
use Livewire\Component;
use App\Models\Entrstock;
use App\Models\Fournisseur;
use Livewire\WithPagination;
use App\Livewire\Traits\WithDelete;

class ListeEntrees extends Component
{
    use WithPagination;
    public $search = '';
    use WithDelete {
        delete as protected traitDelete;
    }
    public function delete()
    {
        $entree=Entrstock::where('id','=',$this->deleteId)->first();
        //annuler une entree
        $article=Article::where('id',$entree->article_id)->first();
        $art_id=$article->id;
        $ent_qte=$entree->ent_qte;
        $ent_prix_achat=$entree->ent_prix_achat;
        $ar_qte=$article->ar_qte;
        //verification si la quantité qu'on veut annuler est dispo en stock avant la suppression
        if($ar_qte>=$ent_qte){
            // annuler_entree($art_id,$ent_qte,$ent_prix_achat);
            // $article->ar_qte-=$ent_qte;
            // $article->save();
            //actualisation situation fournisseur
            $fournisseur=Fournisseur::where('id',$entree->ent_fournisseur)->first();
            if ($fournisseur) {
                $total=$entree->ent_qte*$entree->ent_prix_achat;
                $fournisseur->four_situation-=$total;
                $fournisseur->save();
            }
            $entree->delete();
            annuler_entree($art_id,$ent_qte,$ent_prix_achat);
             //tracing
             $data="Annulation de l'entrée en stock id ".$entree->id." ";
             $model="App\Models\Entrstock";
             trace($data,$model);
            return redirect()->route('entrees.index')->with('success', __('entrée supprimée'));
        }
        else{
            return redirect()->route('entrees.index')->with('danger', "entrée n'est pas annulée car le stock réel est inférieur");
        }
        
    }
    public function render()
    {
        if (!empty($this->search)) {
            $entrees = Entrstock::leftJoin('fournisseurs','entrstocks.ent_fournisseur','=','fournisseurs.id')
                                 ->leftJoin('articles','entrstocks.article_id','=','articles.id')
                                 ->select('entrstocks.*', 'fournisseurs.four_nom','articles.ar_lib','articles.ar_unite')
                                ->where('articles.ar_lib', 'like', '%' . $this->search . '%')
                                ->orWhere('fournisseurs.four_nom', 'like', '%' . $this->search . '%')
                                ->orWhere('entrstocks.ent_qte', 'like', '%' . $this->search . '%')
                                ->orWhere('entrstocks.ent_prix_achat', 'like', '%' . $this->search . '%')
                                ->orWhere('entrstocks.ent_prix_vente', 'like', '%' . $this->search . '%')
                                ->orWhere('entrstocks.ent_date', 'like', '%' . $this->search . '%')
                                ->paginate(10);
        }else{
            $entrees = Entrstock::leftJoin('fournisseurs','entrstocks.ent_fournisseur','=','fournisseurs.id')
                                 ->leftJoin('articles','entrstocks.article_id','=','articles.id')
                                 ->select('entrstocks.*', 'fournisseurs.four_nom','articles.ar_lib','articles.ar_unite')
                                 ->orderByDesc('entrstocks.updated_at')
                                 ->paginate(10);
                                 //dd($entrees);
        }
        return view('livewire.liste-entrees',compact('entrees'));
    }
}
