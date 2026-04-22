<?php

namespace App\Livewire;

// use App\Models\Unite;
use App\Models\Article;
use Livewire\Component;
use App\Models\Entrstock;
use App\Models\Sortstock;
use App\Models\Listedetail;
use Livewire\WithPagination;
use App\Livewire\Traits\WithDelete;

class OperationsDetails extends Component
{
    use WithPagination;
    public $search = '';
   use WithDelete {
        delete as protected traitDelete;
    }
    public function delete()
    {
        $listedetail=Listedetail::where('id','=',$this->deleteId)->first();
         //deleting
         $ar_principal=Article::where('id',$listedetail->lds_principal)->first();
         $ar_secondaire=Article::where('id',$listedetail->lds_detail)->first();
         $entree=Entrstock::where('iddetail',$listedetail->id)->first();
         $sortie=Sortstock::where('iddetail',$listedetail->id)->first();
         if ($ar_principal and $ar_secondaire) {
                //verification si la quantité de détail existe 
            if ($ar_secondaire->ar_qte<$listedetail->lds_qte_ds) {
                return redirect()->route('listedetails.operation')->with('danger', __('cette opération ne peut pas être executée car la quantité de détail est supérieur à la quantité réel'));
            } else {
                //suppression de la qte de détail sur l"article secondaire
                $ar_secondaire->ar_qte-=$listedetail->lds_qte_ds;
                $ar_secondaire->save();
                //ajout de la qte de détail sur l"article primaire
                $ar_principal->ar_qte+=$listedetail->lds_qte_pr;
                $ar_principal->save();
                
                //suppression l'enregistrement dans la table entree
                if ($entree) {
                    # code...
                    $entree->delete();
                }
                //suppression l'enregistrement dans la table sortie
                if ($sortie) {
                    $sortie->delete();
                }
                //suppression de la liste de detail
                if ($listedetail) {
                    # code...
                    $listedetail->delete();
                }
                //tracing
                $data="Suppresion de l'article id ".$listedetail->id." ";
                $model="App\Models\Listedetail";
                trace($data,$model);
                return redirect()->route('listedetails.operation')->with('success', __("L'opération de détail article est supprimée"));
            }
         } else {
            return redirect()->route('listedetails.operation')->with('danger', 'il y a une erreur');
         }
         
                
    }
    public function render()
    { 
        if (!empty($this->search)) {
            $listedetails1 = Listedetail::leftJoin('articles','listedetails.lds_principal','=','articles.id')
                                        ->select('listedetails.*', 'articles.ar_lib')
                                        ->where('articles.ar_lib', 'like', '%' . $this->search . '%')
                                        ->orderByDesc('listedetails.created_at')
                                        ->paginate(10);                             
            $listedetails2 = Listedetail::leftJoin('articles','listedetails.lds_detail','=','articles.id')
                                        ->select('listedetails.*', 'articles.ar_lib')
                                        ->where('articles.ar_lib', 'like', '%' . $this->search . '%')
                                        ->orderByDesc('listedetails.created_at')
                                        ->paginate(10);
            if ($listedetails1->count()>0) {
                $listedetails = $listedetails1; 
            }
            else {
                $listedetails =$listedetails2; 
            }                                                                                 
        }else{
            $listedetails = Listedetail::orderByDesc('listedetails.created_at')->paginate(10); 
        }
        return view('livewire.operations-details',compact('listedetails'));
    }
}
