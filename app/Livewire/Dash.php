<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vente;
use Livewire\WithPagination;


class Dash extends Component
{
    public function render()
    {
        //la date du jour courrant 
        $now = now()->format('Y-m-d');
        //liste des dernières ventes
        $ventes_liste = Vente::leftJoin('clients','ventes.ve_client','=','clients.id')
                            ->leftJoin('articles','ventes.article_id','=','articles.id')
                            ->select('ventes.ve_quantite','ventes.ve_prix_vente','ventes.ve_prix_tot','ventes.updated_at','clients.cli_nom','articles.ar_lib')
                            ->orderByDesc('ventes.updated_at')
                            ->paginate(10);  
        //liste des dernières ventes aujourd'hui
        $ventes_liste_d = Vente::leftJoin('clients','ventes.ve_client','=','clients.id')
                            ->leftJoin('articles','ventes.article_id','=','articles.id')
                            ->where('ventes.updated_at', 'like',$now.'%')
                            ->select('ventes.ve_quantite','ventes.ve_prix_vente','ventes.ve_prix_tot','ventes.updated_at','clients.cli_nom','articles.ar_lib')
                            ->orderByDesc('ventes.updated_at')
                            ->paginate(10);                   
        //liste des articles les plus vendus
        $plus_vendu = Vente::leftJoin('articles','ventes.article_id','=','articles.id')
                            ->selectRaw('SUM(ventes.ve_quantite) as sum_qte,articles.ar_lib,AVG(ventes.ve_prix_vente) as avg_prix')
                            ->groupBy('article_id')
                            ->orderByDesc('sum_qte')
                            ->paginate(10);  
        //somme des ventes par jour
        $ventes_sum_day = Vente::where('updated_at', 'like',$now.'%')
                            ->sum('ve_prix_tot');
        if($ventes_sum_day==0){
            $ventes_sum_day=0;
            }
            $p_achat_d = Vente::where('updated_at', 'like',$now.'%')
                            ->select('ventes.ve_quantite','ventes.ve_prix_achat')
                            ->get();
        $p_achat_t=0;
        $profit_d=0;
        if($p_achat_d->count()>0){
            foreach ($p_achat_d as $item) {
                $item->ve_quantite;
                $p_achat_t=$p_achat_t + ( (float) $item->ve_quantite * (float) $item->ve_prix_achat );
            }
         }
         $profit_d= $ventes_sum_day-$p_achat_t;                       
        //somme des ventes 
        $ventes_sum = Vente::sum('ve_prix_tot');
         if($ventes_sum==0){
            $ventes_sum=0;
            }                    
        $p_achat = Vente::select('ventes.ve_quantite','ventes.ve_prix_achat')
                            ->get();
        $p_achat_t=0;
        $profit=0;
        if($p_achat->count()>0){
            foreach ($p_achat as $item) {
                $item->ve_quantite;
                $p_achat_t=$p_achat_t + ( (float) $item->ve_quantite * (float) $item->ve_prix_achat );
            }
         }
         $profit= $ventes_sum-$p_achat_t;                 
        return view('livewire.dash',compact('ventes_sum','ventes_sum_day','profit','profit_d','ventes_liste','ventes_liste_d','plus_vendu'));
    }
}
