<?php

namespace App\Livewire;

use App\Models\Vente;
use App\Models\Article;
use App\Models\Methode;
use Livewire\Component;
use App\Models\Payement;
use Livewire\WithPagination;
use App\Models\Remboursement;
use Illuminate\Support\Carbon;


class Homs5 extends Component
{
    use WithPagination;
    public $date1;
    public $date2;

    public function mount(){
        $first_vente=Vente::orderBy('created_at','asc')->first();
        if ($first_vente) {
            // $this->date1=$first_vente->created_at->format('Y-m-d');
            $this->date1=now()->format('Y-m-d');
        } else {
            $this->date1=now()->format('Y-m-d');
        }
        $this->date2=now()->format('Y-m-d');
    }
    public function render()
    {                                                                                         
        $ventes=Vente::where('id','>','0')
                        ->whereDate('updated_at','>=',$this->date1)
                        ->whereDate('updated_at','<=',$this->date2)
                        ->selectRaw('count(article_id) as number_of_article,article_id,sum(ve_quantite) as sum_qte')
                        ->groupBy('article_id')
                        ->orderByDesc('sum_qte')
                        ->take(10)
                        ->get();  
        //  dd($ventes);                          
        $articles_d_a=Article::where('id','>','0')->get();
         return view('livewire.homs5',compact('articles_d_a','ventes'));
    }
}
