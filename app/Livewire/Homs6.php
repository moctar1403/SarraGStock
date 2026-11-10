<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Entrstock;
use App\Models\Facture;
use App\Models\Remise;
use App\Models\Sortstock;
use Livewire\Component;
use Livewire\WithPagination;

class Homs6 extends Component
{
    use WithPagination;
    public $date1;
    public $date2;

    public function mount(){
        $this->date1 = now()->startOfMonth()->format('Y-m-d');
        $this->date2 = now()->format('Y-m-d');
    }

    public function render()
    {
        // 1. Ventes Classiques
        $ventes_esp = Facture::where('fa_type_p', '!=', '2')
                        ->where('fa_origine', 'classique')
                        ->whereDate('updated_at', '>=', $this->date1)
                        ->whereDate('updated_at', '<=', $this->date2)
                        ->sum('fa_tot_apres_remise');

        $ventes_cre = Facture::where('fa_type_p', '=', '2')
                        ->where('fa_origine', 'classique')
                        ->whereDate('updated_at', '>=', $this->date1)
                        ->whereDate('updated_at', '<=', $this->date2)
                        ->sum('fa_tot_apres_remise');

        // 2. Ventes Restaurant
        $ventes_resto_esp = Facture::where('fa_type_p', '!=', '2')
                        ->where('fa_origine', 'resto')
                        ->whereDate('updated_at', '>=', $this->date1)
                        ->whereDate('updated_at', '<=', $this->date2)
                        ->sum('fa_tot_apres_remise');

        $ventes_resto_cre = Facture::where('fa_type_p', '=', '2')
                        ->where('fa_origine', 'resto')
                        ->whereDate('updated_at', '>=', $this->date1)
                        ->whereDate('updated_at', '<=', $this->date2)
                        ->sum('fa_tot_apres_remise');

        // 3. Ventes Mixtes
        $ventes_mixte_esp = Facture::where('fa_type_p', '!=', '2')
                        ->where('fa_origine', 'mixte')
                        ->whereDate('updated_at', '>=', $this->date1)
                        ->whereDate('updated_at', '<=', $this->date2)
                        ->sum('fa_tot_apres_remise');

        $ventes_mixte_cre = Facture::where('fa_type_p', '=', '2')
                        ->where('fa_origine', 'mixte')
                        ->whereDate('updated_at', '>=', $this->date1)
                        ->whereDate('updated_at', '<=', $this->date2)
                        ->sum('fa_tot_apres_remise');

        // 4. Pertes
        $pertes = Sortstock::where('sor_motif', 'not like', '%vente%')
                         ->where('sor_motif', 'not like', '%detail%')
                         ->whereDate('updated_at', '>=', $this->date1)
                         ->whereDate('updated_at', '<=', $this->date2)
                         ->sum('sor_montant_t_achat');

        // 5. Remises
        $remises = Remise::whereDate('updated_at', '>=', $this->date1)
                         ->whereDate('updated_at', '<=', $this->date2)
                         ->sum('re_montant_remise');
        
        // 6. Valeur du stock
        $val_stck = 0;
        $art_list = Article::where('gerer_stock', true)->get();
        foreach ($art_list as $value) {
            $val_stck += $value->ar_qte * $value->ar_prix_achat;
        }

        // 7. Achats
        $val_achat_autres = 0;
        $ent_list_autres = Entrstock::where('ent_fournisseur', '=', '0')
                                    ->where('ent_motif', '=', 'achat')
                                    ->whereDate('updated_at', '>=', $this->date1)
                                    ->whereDate('updated_at', '<=', $this->date2)
                                    ->select('ent_qte', 'ent_prix_achat')
                                    ->get();
        foreach ($ent_list_autres as $value) {
            $val_achat_autres += ($value->ent_qte * $value->ent_prix_achat);
        }

        $val_achat_four = 0;
        $ent_list_four = Entrstock::where('ent_fournisseur', '>', '0')
                                    ->where('ent_motif', '=', 'achat')
                                    ->whereDate('updated_at', '>=', $this->date1)
                                    ->whereDate('updated_at', '<=', $this->date2)
                                    ->select('ent_qte', 'ent_prix_achat')
                                    ->get();
        foreach ($ent_list_four as $value) {
            $val_achat_four += ($value->ent_qte * $value->ent_prix_achat);
        }                    

        // 8. Coût de revient des ventes (ON LE CALCULE AVANT LE RESULTAT NET)
        $p_achat_t = Sortstock::where('sor_motif', '=', 'vente')
                         ->whereDate('updated_at', '>=', $this->date1)
                         ->whereDate('updated_at', '<=', $this->date2)
                         ->sum('sor_montant_t_achat');

        // 9. Calculs finaux
        $total1 = $val_achat_four + $val_achat_autres;
        
        // Total Actif (Ventes + Stock)
        $total2 = $ventes_esp + $ventes_cre + $ventes_resto_esp + $ventes_resto_cre + $ventes_mixte_esp + $ventes_mixte_cre + $val_stck;                          
        
        // Chiffre d'Affaires Total (Somme des ventes)
        $chiffre_affaires_total = $ventes_esp + $ventes_cre + $ventes_resto_esp + $ventes_resto_cre + $ventes_mixte_esp + $ventes_mixte_cre;
        
                // ... après le calcul des pertes
        $charges = \App\Models\Charge::whereDate('ch_date','>=', $this->date1)
                                    ->whereDate('ch_date','<=', $this->date2)
                                    ->sum('ch_montant');

        // Résultat Net = CA - Coût de revient - Pertes - Charges
        $resultat_net = $chiffre_affaires_total - $p_achat_t - $pertes - $charges;
        // Résultat Net (Bénéfice = CA - Coût de revient - Pertes)
        // $resultat_net = $chiffre_affaires_total - $p_achat_t - $pertes;

        return view('livewire.homs6', compact(
            'ventes_esp', 'ventes_cre', 'ventes_resto_esp', 'ventes_resto_cre',
            'ventes_mixte_esp', 'ventes_mixte_cre',
            'val_stck', 'val_achat_four', 'val_achat_autres', 
            'total1', 'total2', 'pertes', 'remises', 'resultat_net', 'charges',
        ));
    }
}