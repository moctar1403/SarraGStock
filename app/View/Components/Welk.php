<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Vente;

class Welk extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        //liste des dernières ventes
        $ventes_liste = Vente::leftJoin('clients','ventes.ve_client','=','clients.id')
                            ->leftJoin('articles','ventes.article_id','=','articles.id')
                            ->select('ventes.ve_quantite','ventes.ve_prix_vente','ventes.ve_prix_tot','ventes.updated_at','clients.cli_nom','articles.ar_lib')
                            ->orderByDesc('ventes.updated_at')
                            ->limit(6)
                            ->get();
        //liste des articles les plus vendus
        $plus_vendu = Vente::leftJoin('articles','ventes.article_id','=','articles.id')
                            ->selectRaw('SUM(ventes.ve_quantite) as sum_qte,articles.ar_lib,AVG(ventes.ve_prix_vente) as avg_prix')
                            ->groupBy('article_id')
                            ->orderByDesc('sum_qte')
                            ->limit(6)
                            ->get();
        //somme des ventes 
        $ventes_sum = Vente::where('ve_saisi_par','=',1)
                            ->sum('ve_prix_tot');
         if($ventes_sum==0){
            $ventes_sum=0;
            }                    
        $p_achat = Vente::where('ve_saisi_par','=',1)
                            ->select('ventes.ve_quantite','ventes.ve_prix_achat')
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
        return view('components.welk',compact('ventes_sum','profit','ventes_liste','plus_vendu'));
    }
}
