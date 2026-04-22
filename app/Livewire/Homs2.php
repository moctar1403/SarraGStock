<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vente;
use Livewire\WithPagination;


class Homs2 extends Component
{
    public $espece=0;
    public $credit=0;
    public $sans_credit=0;
    public $bankily=0;
    public $masrivi=0;
    public $ventes_sum;
    public $ventes_liste;
    public $ventes_msg;
    public function total_ventes(){
        $this->ventes_msg="Total des ventes";
        $this->ventes_liste = Vente::leftJoin('clients','ventes.ve_client','=','clients.id')
                            ->leftJoin('articles','ventes.article_id','=','articles.id')
                            ->select('ventes.ve_quantite','ventes.ve_prix_vente','ventes.ve_prix_tot','ventes.type_p','ventes.updated_at','clients.cli_nom','articles.ar_lib')
                            ->orderByDesc('ventes.updated_at')
                            ->get();
    }
    public function ventes_credit(){
        $this->ventes_msg="Ventes par crédit";
        $this->ventes_liste = Vente::leftJoin('clients','ventes.ve_client','=','clients.id')
                            ->leftJoin('articles','ventes.article_id','=','articles.id')
                            ->where('ventes.type_p','=','1')
                            ->select('ventes.ve_quantite','ventes.ve_prix_vente','ventes.ve_prix_tot','ventes.type_p','ventes.updated_at','clients.cli_nom','articles.ar_lib')
                            ->orderByDesc('ventes.updated_at')
                            ->get();
    }
    public function vsans_credit(){
        $this->ventes_msg="Total des Ventes sans crédit";
        $this->ventes_liste = Vente::leftJoin('clients','ventes.ve_client','=','clients.id')
                            ->leftJoin('articles','ventes.article_id','=','articles.id')
                            ->where('ventes.type_p','!=','1')
                            ->select('ventes.ve_quantite','ventes.ve_prix_vente','ventes.ve_prix_tot','ventes.type_p','ventes.updated_at','clients.cli_nom','articles.ar_lib')
                            ->orderByDesc('ventes.updated_at')
                            ->get();
    }
    public function ventes_app(){
        $this->ventes_msg="Ventes par Bankily";
        $this->ventes_liste = Vente::leftJoin('clients','ventes.ve_client','=','clients.id')
                            ->leftJoin('articles','ventes.article_id','=','articles.id')
                            ->where('ventes.type_p','=','2')
                            ->orWhere('ventes.type_p','=','3')
                            ->select('ventes.ve_quantite','ventes.ve_prix_vente','ventes.ve_prix_tot','ventes.type_p','ventes.updated_at','clients.cli_nom','articles.ar_lib')
                            ->orderByDesc('ventes.updated_at')
                            ->get();
    }
    public function ventes_bankily(){
        $this->ventes_msg="Ventes par Bankily";
        $this->ventes_liste = Vente::leftJoin('clients','ventes.ve_client','=','clients.id')
                            ->leftJoin('articles','ventes.article_id','=','articles.id')
                            ->where('ventes.type_p','=','2')
                            ->select('ventes.ve_quantite','ventes.ve_prix_vente','ventes.ve_prix_tot','ventes.type_p','ventes.updated_at','clients.cli_nom','articles.ar_lib')
                            ->orderByDesc('ventes.updated_at')
                            ->get();
    }
    public function ventes_masrivi(){
        $this->ventes_msg="Ventes par Masrivi";
        $this->ventes_liste = Vente::leftJoin('clients','ventes.ve_client','=','clients.id')
                            ->leftJoin('articles','ventes.article_id','=','articles.id')
                            ->where('ventes.type_p','=','3')
                            ->select('ventes.ve_quantite','ventes.ve_prix_vente','ventes.ve_prix_tot','ventes.type_p','ventes.updated_at','clients.cli_nom','articles.ar_lib')
                            ->orderByDesc('ventes.updated_at')
                            ->get();
                            // dd($this->ventes_liste);
    }
    public function ventes_espece(){
        $this->ventes_msg="Ventes en espèce";
        $this->ventes_liste = Vente::leftJoin('clients','ventes.ve_client','=','clients.id')
                            ->leftJoin('articles','ventes.article_id','=','articles.id')
                            ->where('ventes.type_p','=','0')
                            ->select('ventes.ve_quantite','ventes.ve_prix_vente','ventes.ve_prix_tot','ventes.type_p','ventes.updated_at','clients.cli_nom','articles.ar_lib')
                            ->orderByDesc('ventes.updated_at')
                            ->get();
    }
    public function mount(){
        $this->ventes_msg="";
                //liste des dernières ventes
                $this->ventes_liste = Vente::leftJoin('clients','ventes.ve_client','=','clients.id')
                            ->leftJoin('articles','ventes.article_id','=','articles.id')
                            ->where('ventes.type_p','=','5')
                            ->select('ventes.ve_quantite','ventes.ve_prix_vente','ventes.ve_prix_tot','ventes.type_p','ventes.updated_at','clients.cli_nom','articles.ar_lib')
                            ->orderByDesc('ventes.updated_at')
                            ->get();
    }
    public function render()
    {
        //la date du jour courrant 
        $now = now()->format('Y-m-d');  
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
        $this->ventes_sum = Vente::sum('ve_prix_tot');
         if($this->ventes_sum==0){
            $this->ventes_sum=0;
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
         $profit= $this->ventes_sum-$p_achat_t;
         $this->espece=Vente::where('type_p','=','0')->sum('ve_prix_tot');                
         $this->bankily=Vente::where('type_p','=','2')->sum('ve_prix_tot');                
         $this->masrivi=Vente::where('type_p','=','3')->sum('ve_prix_tot');                
         $this->credit=Vente::where('type_p','=','1')->sum('ve_prix_tot');                
         $this->sans_credit=Vente::where('type_p','!=','1')->sum('ve_prix_tot');                
        return view('livewire.homs2',compact('ventes_sum_day','profit','profit_d','ventes_liste_d','plus_vendu'));
    }
}
