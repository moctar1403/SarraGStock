<?php

namespace App\Livewire;

use App\Models\Vente;
use App\Models\Remise;
use App\Models\Article;
use App\Models\Facture;
use App\Models\Methode;
use Livewire\Component;
use App\Models\Payement;
use App\Models\Entrstock;
use App\Models\Sortstock;
use Livewire\WithPagination;
use App\Models\Remboursement;
use Illuminate\Support\Carbon;


class Homs6 extends Component
{
    use WithPagination;
    public $date1;
    public $date2;

    public function mount(){
        
    }
    public function render()
    {
        $ventes_esp=0;
        $ventes_cre=0;
        $pertes=0;
        $remises=0;
        $total1=0;
        $total2=0;
        //                                                                                         
        $ventes_esp=Facture::where('fa_type_p','!=','2')
                        ->sum('fa_tot_apres_remise');
        $ventes_cre=Facture::where('fa_type_p','=','2')
                        // ->groupBy('type_p')
                        ->sum('fa_tot_apres_remise');
        //
        $pertes=Sortstock::where('sor_motif','not like','%vente%')
                         ->where('sor_motif','not like','%detail%')
                         ->sum('sor_montant_t_achat');
        //
        $remises=Remise::sum('re_montant_remise');
        
        //
        $val_stck=0;
        $art_list=Article::all();
        if ($art_list) {
            foreach ($art_list as $key => $value) {
                $val_stck+=$value->ar_qte*$value->ar_prix_achat;
            }
        }
        //
        $val_achat_autres=0;
        $ent_list_autres=Entrstock::where('ent_fournisseur','=','0')
                                    ->where('ent_motif','=','achat')
                                    ->select('ent_qte','ent_prix_achat')
                                    ->get();
        if ($ent_list_autres) {
            foreach ($ent_list_autres as $key => $value) {
                $val_achat_autres+=($value->ent_qte*$value->ent_prix_achat);
            }
        }       
        //                                     
        //
        $val_achat_four=0;
        $ent_list_four=Entrstock::where('ent_fournisseur','>','0')
                                    ->where('ent_motif','=','achat')
                                    ->select('ent_qte','ent_prix_achat')
                                    ->get();
        // $ent_list_four=Entrstock::selectRaw('count(article_id) as number_of_article,article_id,sum(ent_qte) as sum_qte,avg(ent_prix_achat) as avg_prix_achat')
        //                     ->groupBy('article_id')
        //                     ->where('ent_fournisseur','>','0')
        //                     ->get();
        if ($ent_list_four) {
            foreach ($ent_list_four as $key => $value) {
                $val_achat_four+=($value->ent_qte*$value->ent_prix_achat);
            }
        }                    
        //                                     
        // dd($ent_list_four);
        $total1=$val_achat_four+$val_achat_autres;
        $total2=$ventes_esp+$ventes_cre+$val_stck;                          
         return view('livewire.homs6',compact('ventes_esp','ventes_cre','val_stck','val_achat_four','val_achat_autres','total1','total2','pertes','remises'));
    }
}
