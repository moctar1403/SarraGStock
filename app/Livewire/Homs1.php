<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vente;
use App\Models\Methode;
use App\Models\Payement;
use App\Models\Remboursement;
use Illuminate\Support\Carbon;
use Livewire\WithPagination;


class Homs1 extends Component
{
    public $appl=0;
    public $credit_id;
    public $espece_id;
    public $paiement=0;
    public $remboursement=0;
    public $ventes_sum;
    //public $ventes_liste;
    public $ventes_msg;
    public $date1;
    public $date2;
    public $date11;
    public $date22;
    public $profit=0;
    public $p_achat_t=0;
    public $liste_apps;
    public $liste_app_count=0;
    public $liste_pay=[];
 
    public function total_ventes(){
        $this->ventes_msg('Toutes les ventes');
        $ventes_liste = Vente::leftJoin('clients','ventes.ve_client','=','clients.id')
        ->leftJoin('articles','ventes.article_id','=','articles.id')
        ->leftJoin('methodes','ventes.type_p','=','methodes.id')
        ->whereDate('ventes.updated_at','>=', $this->date1)
        ->whereDate('ventes.updated_at','<=', $this->date2)
        ->select('ventes.ve_quantite','ventes.ve_prix_vente','ventes.ve_prix_tot','ventes.type_p','ventes.updated_at','clients.cli_nom','articles.ar_lib','methodes.meth_nom')
        ->orderByDesc('ventes.updated_at')
        ->paginate(8);
    }
    public function ventes_methode($key){
        $selected_meth=Methode::where('id','=',$key)->first();
        //dd($key);
        $this->ventes_msg('Ventes en '.$selected_meth->meth_nom);
        $ventes_liste = Vente::leftJoin('clients','ventes.ve_client','=','clients.id')
                                    ->leftJoin('articles','ventes.article_id','=','articles.id')
                                    ->leftJoin('methodes','ventes.type_p','=','methodes.id')
                                    ->whereDate('ventes.updated_at','>=', $this->date1)
                                    ->whereDate('ventes.updated_at','<=', $this->date2)
                                    ->where('methodes.id','=', $key)
                                    ->select('ventes.ve_quantite','ventes.ve_prix_vente','ventes.ve_prix_tot','ventes.type_p','ventes.updated_at','clients.cli_nom','articles.ar_lib','methodes.meth_nom')
                                    ->orderByDesc('ventes.updated_at')
                                    ->paginate(8);
    }
    public function ventes_appl(){
        $this->ventes_msg('Ventes par applications ');
        $ventes_liste = Vente::leftJoin('clients','ventes.ve_client','=','clients.id')
                                    ->leftJoin('articles','ventes.article_id','=','articles.id')
                                    ->leftJoin('methodes','ventes.type_p','=','methodes.id')
                                    ->whereDate('ventes.updated_at','>=', $this->date1)
                                    ->whereDate('ventes.updated_at','<=', $this->date2)
                                    ->where('methodes.id','!=', $this->espece_id)
                                    ->where('methodes.id','!=', $this->credit_id)
                                    ->select('ventes.ve_quantite','ventes.ve_prix_vente','ventes.ve_prix_tot','ventes.type_p','ventes.updated_at','clients.cli_nom','articles.ar_lib','methodes.meth_nom')
                                    ->orderByDesc('ventes.updated_at')
                                    ->paginate(8);
    }
    
    public function ventes_msg($msg){

            if($this->date1==$this->date2){
                $this->ventes_msg=$msg.' le '.$this->date11;
            }
            else if(($this->date1)<($this->date2)){
                $this->ventes_msg=$msg.' entre le ' .$this->date11.' et le '.$this->date22;
            }
            else{
                $this->ventes_msg='Les dates ne sont pas correctes!! ';
            }
       }
       public function recherche_date(){
        $this->ventes_msg('Toutes les ventes');
        $ventes_liste = Vente::leftJoin('clients','ventes.ve_client','=','clients.id')
                            ->leftJoin('articles','ventes.article_id','=','articles.id')
                            ->leftJoin('methodes','ventes.type_p','=','methodes.id')
                            ->whereDate('ventes.updated_at','>=', $this->date1)
                            ->whereDate('ventes.updated_at','<=', $this->date2)
                            ->select('ventes.ve_quantite','ventes.ve_prix_vente','ventes.ve_prix_tot','ventes.type_p','ventes.updated_at','clients.cli_nom','articles.ar_lib','methodes.meth_nom')
                            ->orderByDesc('ventes.updated_at')
                            ->paginate(8);
    }
    public function annuler_recherche_date(){
        //dd($this->date2);
    }
    public function clickDate1(){
        //$this->total_ventes();
    }
    public function clickDate2(){
        //$this->total_ventes();
    }
    public function mount(){
        $this->date1=now()->format('Y-m-d');
        $this->date2=now()->format('Y-m-d');
        //formattage des dates de recherche en fr
        $this->date11=Carbon::parse($this->date1)->format('d-m-Y');
        $this->date22=Carbon::parse($this->date2)->format('d-m-Y');
        $this->ventes_msg='Toutes les ventes le ' .$this->date11;
                //liste des dernières ventes
        // $ventes_liste = Vente::leftJoin('clients','ventes.ve_client','=','clients.id')
        //                             ->leftJoin('articles','ventes.article_id','=','articles.id')
        //                             ->leftJoin('methodes','ventes.type_p','=','methodes.id')
        //                             ->whereDate('ventes.updated_at','>=', $this->date1)
        //                             ->whereDate('ventes.updated_at','<=', $this->date2)
        //                             ->select('ventes.ve_quantite','ventes.ve_prix_vente','ventes.ve_prix_tot','ventes.type_p','ventes.updated_at','clients.cli_nom','articles.ar_lib','methodes.meth_nom')
        //                             ->orderByDesc('ventes.updated_at')
        //                             ->paginate(8);
                        }
    public function render()
    {
        $ventes_liste = Vente::leftJoin('clients','ventes.ve_client','=','clients.id')
                                    ->leftJoin('articles','ventes.article_id','=','articles.id')
                                    ->leftJoin('methodes','ventes.type_p','=','methodes.id')
                                    ->whereDate('ventes.updated_at','>=', $this->date1)
                                    ->whereDate('ventes.updated_at','<=', $this->date2)
                                    ->select('ventes.ve_quantite','ventes.ve_prix_vente','ventes.ve_prix_tot','ventes.type_p','ventes.updated_at','clients.cli_nom','articles.ar_lib','methodes.meth_nom')
                                    ->orderByDesc('ventes.updated_at')
                                    ->paginate(8);
        $row_credit=Methode::where('meth_nom','like','%Crédit%')
                            ->orWhere('meth_nom','like','%crédit%')
                            ->orWhere('meth_nom','like','%Credit%')
                            ->orWhere('meth_nom','like','%credit%')
                            ->first();
        $this->credit_id=$row_credit->id;
        $row_espece=Methode::where('meth_nom','like','%Espèce%')
                            ->orWhere('meth_nom','like','%Espece%')
                            ->orWhere('meth_nom','like','%espèce%')
                            ->orWhere('meth_nom','like','%espece%')
                            ->first();
        $this->espece_id=$row_espece->id;                                                                                    
        $this->appl=Vente::where('type_p','!=',$this->espece_id)
                                ->where('type_p','!=',$this->credit_id)
                                ->whereDate('updated_at','>=', $this->date1)
                                ->whereDate('updated_at','<=', $this->date2)
                                ->sum('ve_prix_tot');                                             
                   
               
         $this->paiement=Payement::whereDate('pay_date','>=', $this->date1)
                                ->whereDate('pay_date','<=', $this->date2)
                                ->sum('pay_montant');                
         $this->remboursement=Remboursement::whereDate('rem_date','>=', $this->date1)
                                ->whereDate('rem_date','<=', $this->date2)
                                ->sum('rem_montant');                                        
                    
        //formattage des dates de recherche en fr
        $this->date11=Carbon::parse($this->date1)->format('d-m-Y');
        $this->date22=Carbon::parse($this->date2)->format('d-m-Y');
        //la date du jour courrant 
        $now = now()->format('Y-m-d');  
        //liste des dernières ventes aujourd'hui
        $ventes_liste_d = Vente::leftJoin('clients','ventes.ve_client','=','clients.id')
                            ->leftJoin('articles','ventes.article_id','=','articles.id')
                            ->leftJoin('methodes','ventes.type_p','=','methodes.id')
                            ->where('ventes.updated_at', 'like',$now.'%')
                            ->select('ventes.ve_quantite','ventes.ve_prix_vente','ventes.ve_prix_tot','ventes.updated_at','clients.cli_nom','articles.ar_lib','methodes.meth_nom')
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
        $profit_d=0;
        if($p_achat_d->count()>0){
            foreach ($p_achat_d as $item) {
                $item->ve_quantite;
                $this->p_achat_t=$this->p_achat_t + ( (float) $item->ve_quantite * (float) $item->ve_prix_achat );
            }
         }
         $profit_d= $ventes_sum_day-$this->p_achat_t;                       
        //somme des ventes 
        $this->ventes_sum = Vente::whereDate('updated_at','>=', $this->date1)
                                    ->whereDate('updated_at','<=', $this->date2)
                                    ->sum('ve_prix_tot')
                                    ;
         if($this->ventes_sum==0){
            $this->ventes_sum=0;
            }                    
        $p_achat = Vente::select('ventes.ve_quantite','ventes.ve_prix_achat')
                            ->whereDate('updated_at','>=', $this->date1)
                            ->whereDate('updated_at','<=', $this->date2)
                            ->get();
        $this->p_achat_t=0;
        if($p_achat->count()>0){
            foreach ($p_achat as $item) {
                $item->ve_quantite;
                $this->p_achat_t=$this->p_achat_t + ( (float) $item->ve_quantite * (float) $item->ve_prix_achat );
            }
         }
         $this->profit= ($this->ventes_sum+$this->paiement+$this->remboursement)-$this->p_achat_t;
         //la liste des methodes de paiements
         $this->liste_apps=Methode::where('meth_active','=','1')->get();
         foreach ($this->liste_apps as $key => $liste_app) {
            $this->liste_pay[$key]=Vente::where('type_p','=',$liste_app->id)
                                    ->whereDate('updated_at','>=', $this->date1)
                                    ->whereDate('updated_at','<=', $this->date2)
                                    ->sum('ve_prix_tot');                       
        }  
         return view('livewire.homs1',compact('ventes_liste'));
        //,
        // [
        //     'ventes_liste' => $this->total_ventes(),
        // ]
   // );
    }
}
