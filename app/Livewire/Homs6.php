<?php

namespace App\Livewire;

use App\Models\Vente;
use App\Models\Remise;
use App\Models\Article;
use App\Models\Facture;
use App\Models\Methode;
use Livewire\Component;
use App\Models\Entrstock;
use App\Models\Sortstock;
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
        $ventes_esp = 0;
        $ventes_cre = 0;
        $ventes_resto_esp = 0;
        $ventes_resto_cre = 0;
        $pertes = 0;
        $remises = 0;
        $total1 = 0;
        $total2 = 0;
        $resultat_net = 0;
        $p_achat_t = 0;

        // 1. Ventes Classiques (Espèces / Applications)
        $ventes_esp = Facture::where('fa_type_p', '!=', '2')
                        ->where('fa_origine', 'classique')
                        ->whereDate('updated_at', '>=', $this->date1)
                        ->whereDate('updated_at', '<=', $this->date2)
                        ->sum('fa_tot_apres_remise');

        // 2. Ventes Classiques (Crédit)
        $ventes_cre = Facture::where('fa_type_p', '=', '2')
                        ->where('fa_origine', 'classique')
                        ->whereDate('updated_at', '>=', $this->date1)
                        ->whereDate('updated_at', '<=', $this->date2)
                        ->sum('fa_tot_apres_remise');

        // 3. Ventes Restaurant (Espèces / Applications)
        $ventes_resto_esp = Facture::where('fa_type_p', '!=', '2')
                        ->where('fa_origine', 'resto')
                        ->whereDate('updated_at', '>=', $this->date1)
                        ->whereDate('updated_at', '<=', $this->date2)
                        ->sum('fa_tot_apres_remise');

        // 4. Ventes Restaurant (Crédit)
        $ventes_resto_cre = Facture::where('fa_type_p', '=', '2')
                        ->where('fa_origine', 'resto')
                        ->whereDate('updated_at', '>=', $this->date1)
                        ->whereDate('updated_at', '<=', $this->date2)
                        ->sum('fa_tot_apres_remise');

        // 5. Pertes
        $pertes = Sortstock::where('sor_motif', 'not like', '%vente%')
                         ->where('sor_motif', 'not like', '%detail%')
                         ->whereDate('updated_at', '>=', $this->date1)
                         ->whereDate('updated_at', '<=', $this->date2)
                         ->sum('sor_montant_t_achat');

        // 6. Remises (Pour l'affichage des charges)
        $remises = Remise::whereDate('updated_at', '>=', $this->date1)
                         ->whereDate('updated_at', '<=', $this->date2)
                         ->sum('re_montant_remise');

        // 7. Coût de revient des ventes (LA CLÉ DU CALCUL)
        $p_achat_t = Sortstock::where('sor_motif', '=', 'vente')
                         ->whereDate('updated_at', '>=', $this->date1)
                         ->whereDate('updated_at', '<=', $this->date2)
                         ->sum('sor_montant_t_achat');

        // 8. Valeur du stock (Uniquement pour le Total Actif)
        $val_stck = 0;
        $art_list = Article::where('gerer_stock', true)->get();
        foreach ($art_list as $value) {
            $val_stck += $value->ar_qte * $value->ar_prix_achat;
        }

        // 9. Achats autres (pour le Total Charges)
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

        // 10. Achats fournisseurs (pour le Total Charges)
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

        // 11. Calculs finaux
        // Total Charges (Affichage : Achats + Pertes + Remises)
        $total1 = $val_achat_four + $val_achat_autres;
        
        // Total Actif (Affichage : Ventes + Stock)
        $total2 = $ventes_esp + $ventes_cre + $ventes_resto_esp + $ventes_resto_cre + $val_stck;                          
        
        // Résultat Net (Bénéfice réel = Chiffre d'Affaires - Coût de revient - Pertes)
        $chiffre_affaires_total = $ventes_esp + $ventes_cre + $ventes_resto_esp + $ventes_resto_cre;
        $resultat_net = $chiffre_affaires_total - $p_achat_t - $pertes;

        return view('livewire.homs6', compact(
            'ventes_esp', 'ventes_cre', 'ventes_resto_esp', 'ventes_resto_cre',
            'val_stck', 'val_achat_four', 'val_achat_autres', 
            'total1', 'total2', 'pertes', 'remises', 'resultat_net'
        ));
    }
}