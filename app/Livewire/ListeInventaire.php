<?php

namespace App\Livewire;

use App\Models\Unite;
use App\Models\Article;
use Livewire\Component;
use App\Models\Entrstock;
use App\Models\Sortstock;
use Livewire\WithPagination;

class ListeInventaire extends Component
{
    use WithPagination;
    public $search = '';

    public function delete(Article $article)
    {
        // dd($article);
        // $article=Article::where('id',$article);
        //verification s'il y a une entree pour cet article 
        $entree=Entrstock::where('article_id',$article->id)->first();
        if($entree){
            return redirect()->route('articles.index')->with('danger', "Article n'est pas supprimé,il a une entrée en stock");
        }
        else {
            //verification s'il y a une sortie pour cet article 
            $sortie=Sortstock::where('article_id',$article->id)->first();
            if($sortie){
                return redirect()->route('articles.index')->with('danger', "Article n'est pas supprimé,il a une sortie en stock");
            }
            //Le cas contraire on supprime
            else{
                //deleting
                $article->delete();
                //tracing
                $data="Suppresion de l'article id ".$article->id." libelle ".$article->ar_lib. " ";
                $model="App\Models\Article";
                trace($data,$model);
                return redirect()->route('articles.index')->with('success', 'Article supprimé');
            }
        }
        
    }
    public function render()
    { 
         $articles2 = Article::all();
         if ($articles2) {
            foreach ($articles2 as $key => $value) {
            $first_entree=Entrstock::where('article_id',$value->id)->first();
            if ($first_entree) {
                $initials[$value->id]=$first_entree->ent_qte;
            }
            else {
                $initials[$value->id]=0;
            }
            $final_stock[$value->id]=$value->ar_qte;
            $sorties_stock[$value->id]=0;
            $sum_entrees[$value->id]=0;
            $sorties_pertes[$value->id]=0;
            $sorties_dons[$value->id]=0;
            $sorties_detail[$value->id]=0;
            }
            //final_stock and sum sorties
            foreach ($articles2 as $key => $value) {
               $sum_entree=Entrstock::where('article_id',$value->id)->sum('ent_qte');
               $sum_sorties=Sortstock::where('article_id',$value->id)
                                        ->where('sor_motif','!=','perte')
                                        ->sum('sor_qte');
               $sum_pertes=Sortstock::where('article_id',$value->id)
                                        ->where('sor_motif','=','Perte')
                                        ->sum('sor_qte');
               $sum_dons=Sortstock::where('article_id',$value->id)
                                        ->where('sor_motif','=','Dons')
                                        ->sum('sor_qte');
               $sum_detail=Sortstock::where('article_id',$value->id)
                                        ->where('sor_motif','=','Detail')
                                        ->sum('sor_qte');
               if ($sum_entree) {
                    $sum_entrees[$value->id]=$sum_entree;
                }
               if ($sum_sorties) {
                    $sorties_stock[$value->id]=$sum_sorties;
                }
               if ($sum_pertes) {
                    $sorties_pertes[$value->id]=$sum_pertes;
                }
               if ($sum_dons) {
                    $sorties_dons[$value->id]=$sum_dons;
                }
               if ($sum_detail) {
                    $sorties_detail[$value->id]=$sum_detail;
                }
            }
         }
         
        if (!empty($this->search)) {
            $articles = Article::leftJoin('unites','articles.ar_unite','=','unites.id')
                                ->where('ar_lib', 'like', '%' . $this->search . '%')
                                ->orWhere('articles.id', 'like', '%' . $this->search . '%')
                                ->orWhere('ar_reference', 'like', '%' . $this->search . '%')
                                ->orWhere('ar_description', 'like', '%' . $this->search . '%')
                                ->orWhere('ar_codebarre', 'like', '%' . $this->search . '%')
                                ->orWhere('ar_qte', 'like', '%' . $this->search . '%')
                                ->orWhere('ar_qte_mini', 'like', '%' . $this->search . '%')
                                ->orWhere('ar_prix_vente', 'like', '%' . $this->search . '%')
                                ->select('articles.*','unites.unit_lib')
                                ->orderByDesc('ar_qte')
                                ->paginate(10);
        }else{
            $articles = Article::leftJoin('unites','articles.ar_unite','=','unites.id')
                                ->select('articles.*','unites.unit_lib')
                                ->orderByDesc('ar_qte')
                                ->paginate(10);
                                //dd($articles);
                
        }

        return view('livewire.liste-inventaire',compact('articles','initials','final_stock','sorties_stock','sorties_pertes','sorties_dons','sorties_detail','sum_entrees'));
    }
}
