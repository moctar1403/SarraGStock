<?php
namespace App\Livewire;

use App\Models\Vente;
use App\Models\Remise;
use App\Models\Facture;
use App\Models\Methode;
use Livewire\Component;
use App\Models\Payement;
use App\Models\Sortstock;
use Livewire\WithPagination;
use App\Models\Remboursement;
use App\Models\Payfournisseur;
use Illuminate\Support\Carbon;

class Homs3 extends Component
{
    public $appl=0;
    public $credit_id;
    public $espece_id;
    public $paiement_cli=0;
    public $paiement_four=0;
    public $pertes=0;
    public $remises=0;
    public $ventes_sum=0;
    public $ventes_msg;
    public $date1;
    public $date2;
    public $profit=0;
    public $p_achat_t=0;
    public $liste_apps;
    public $liste_app_count=0;
    public $liste_pay=[];
 
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
        $row_credit=Methode::where('meth_nom','like','%Crédit%')
                            ->orWhere('meth_nom','like','%crédit%')
                            ->orWhere('meth_nom','like','%Credit%')
                            ->orWhere('meth_nom','like','%credit%')
                            ->first();
        if ($row_credit) {
            $this->credit_id=$row_credit->id;
                            }       
        $row_espece=Methode::where('meth_nom','like','%Espèce%')
                            ->orWhere('meth_nom','like','%Espece%')
                            ->orWhere('meth_nom','like','%espèce%')
                            ->orWhere('meth_nom','like','%espece%')
                            ->first();
        if ($row_espece) {
            $this->espece_id=$row_espece->id;
        }                                                                                  
        $this->appl=Vente::where('type_p','!=',$this->espece_id)
                                ->where('type_p','!=',$this->credit_id)
                                ->whereDate('updated_at','>=', $this->date1)
                                ->whereDate('updated_at','<=', $this->date2)
                                ->sum('ve_prix_tot');                                             
                   
               
         $this->paiement_cli=Payement::whereDate('pay_date','>=', $this->date1)
                                ->whereDate('pay_date','<=', $this->date2)
                                ->sum('pay_montant');   
         $this->paiement_four=Payfournisseur::whereDate('fpay_date','>=', $this->date1)
                                ->whereDate('fpay_date','<=', $this->date2)
                                ->sum('fpay_montant');   

        $this->ventes_sum = Facture::whereDate('updated_at','>=', $this->date1)
                                    ->whereDate('updated_at','<=', $this->date2)
                                    ->sum('fa_tot_apres_remise')
                                    // ->sum('fa_tot')
                                    ;
        $this->p_achat_t= Sortstock::where('sor_motif','=','vente')
                                    ->whereDate('updated_at','>=', $this->date1)
                                    ->whereDate('updated_at','<=', $this->date2)
                                    ->sum('sor_montant_t_achat');                                   
        // $p_achat = Vente::select('ventes.ve_quantite','ventes.ve_prix_achat')
        //                     ->whereDate('updated_at','>=', $this->date1)
        //                     ->whereDate('updated_at','<=', $this->date2)
        //                     ->get();
        // if($p_achat->count()>0){
        //     foreach ($p_achat as $item) {
        //         $item->ve_quantite;
        //         $this->p_achat_t=$this->p_achat_t + ( (float) $item->ve_quantite * (float) $item->ve_prix_achat );
        //     }
        //  }
        $this->liste_apps=Methode::where('meth_active','=','1')->get();
         foreach ($this->liste_apps as $key => $liste_app) {
            $this->liste_pay[$key]=Facture::where('fa_type_p','=',$liste_app->id)
                                    ->whereDate('updated_at','>=', $this->date1)
                                    ->whereDate('updated_at','<=', $this->date2)
                                    ->sum('fa_tot_apres_remise');                       
                                    // ->sum('fa_tot');                       
            // $this->liste_pay[$key]=Vente::where('type_p','=',$liste_app->id)
            //                         ->whereDate('updated_at','>=', $this->date1)
            //                         ->whereDate('updated_at','<=', $this->date2)
            //                         ->sum('ve_prix_tot');                       
        }
        $count_pertes=Sortstock::where('sor_motif','!=','vente')
                                    ->whereDate('updated_at','>=', $this->date1)
                                    ->whereDate('updated_at','<=', $this->date2)
                                    ->get();
        if ($count_pertes) {
                $this->pertes=Sortstock::where('sor_motif','=','perte')
                                    ->whereDate('updated_at','>=', $this->date1)
                                    ->whereDate('updated_at','<=', $this->date2)
                                    ->sum('sor_montant_t_achat');
        }                            
        
        $this->remises=Remise::whereDate('updated_at','>=', $this->date1)
                                    ->whereDate('updated_at','<=', $this->date2)
                                    ->sum('re_montant_remise');
        $this->profit= $this->ventes_sum-$this->p_achat_t-$this->pertes;  
         return view('livewire.homs3');
    }
}
