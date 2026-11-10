<?php
namespace App\Livewire;

use App\Models\Charge;
use App\Models\Facture;
use App\Models\Methode;
use App\Models\Payement;
use App\Models\Payfournisseur;
use App\Models\Remise;
use App\Models\Sortstock;
use App\Models\Vente;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

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
    public $ventes_classiques=0; // NOUVEAU
    public $ventes_resto=0;      // NOUVEAU
    public $date1;
    public $date2;
    public $profit=0;
    public $p_achat_t=0;
    public $liste_apps;
    public $liste_pay=[];
    public $ventes_mixtes = 0; // NOUVEAU
    public $charges_totales = 0;
 
    public function mount(){
        $this->date1=now()->format('Y-m-d');
        $this->date2=now()->format('Y-m-d');
        $this->ch_date = now()->format('Y-m-d'); // <-- C'est parfait
    }
    // NOUVEAU : Sécurité pour s'assurer que date1 <= date2
    public function updatedDate1($value)
    {
        if ($value > $this->date2) {
            $this->date2 = $value;
        }
    }

    // NOUVEAU : Sécurité pour s'assurer que date2 >= date1
    public function updatedDate2($value)
    {
        if ($value < $this->date1) {
            $this->date1 = $value;
        }
    }

    public function render()
    {
        // 1. Identification des méthodes Crédit et Espèce
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
        
        // 2. Calcul du CA Global
        $this->ventes_sum = Facture::whereDate('updated_at','>=', $this->date1)
                                    ->whereDate('updated_at','<=', $this->date2)
                                    ->sum('fa_tot_apres_remise');

        // 3. Distinction Resto / Classique (NOUVEAU)
        $this->ventes_classiques = Facture::where('fa_origine', 'classique')
                                    ->whereDate('updated_at','>=', $this->date1)
                                    ->whereDate('updated_at','<=', $this->date2)
                                    ->sum('fa_tot_apres_remise');

        $this->ventes_resto = Facture::where('fa_origine', 'resto')
                                    ->whereDate('updated_at','>=', $this->date1)
                                    ->whereDate('updated_at','<=', $this->date2)
                                    ->sum('fa_tot_apres_remise');

        // 4. Paiements et Dettes
        $this->paiement_cli=Payement::whereDate('pay_date','>=', $this->date1)
                                ->whereDate('pay_date','<=', $this->date2)
                                ->sum('pay_montant');   

        $this->paiement_four=Payfournisseur::whereDate('fpay_date','>=', $this->date1)
                                ->whereDate('fpay_date','<=', $this->date2)
                                ->sum('fpay_montant');   

        // 5. Coût de revient et Pertes
        $this->p_achat_t= Sortstock::where('sor_motif','=','vente')
                                    ->whereDate('updated_at','>=', $this->date1)
                                    ->whereDate('updated_at','<=', $this->date2)
                                    ->sum('sor_montant_t_achat');                                   

        $this->pertes=Sortstock::where('sor_motif','=','perte')
                                    ->whereDate('updated_at','>=', $this->date1)
                                    ->whereDate('updated_at','<=', $this->date2)
                                    ->sum('sor_montant_t_achat');
                                    
        $this->remises=Remise::whereDate('updated_at','>=', $this->date1)
                                    ->whereDate('updated_at','<=', $this->date2)
                                    ->sum('re_montant_remise');

        // $this->profit= $this->ventes_sum - $this->p_achat_t - $this->pertes;  

        // 6. Répartition par méthode de paiement
        $this->liste_apps=Methode::where('meth_active','=','1')->get();
        foreach ($this->liste_apps as $key => $liste_app) {
            $this->liste_pay[$key]=Facture::where('fa_type_p','=',$liste_app->id)
                                    ->whereDate('updated_at','>=', $this->date1)
                                    ->whereDate('updated_at','<=', $this->date2)
                                    ->sum('fa_tot_apres_remise');                       
        }
        $this->ventes_mixtes = Facture::where('fa_origine', 'mixte')
                                ->whereDate('updated_at','>=', $this->date1)
                                ->whereDate('updated_at','<=', $this->date2)
                                ->sum('fa_tot_apres_remise');
                // 6. Charges
        $this->charges_totales = Charge::whereDate('ch_date','>=', $this->date1)
                                    ->whereDate('ch_date','<=', $this->date2)
                                    ->sum('ch_montant');

        // 7. Profit (On déduit les charges)
        $this->profit = $this->ventes_sum - $this->p_achat_t - $this->pertes - $this->charges_totales;
         return view('livewire.homs3');
    }
}