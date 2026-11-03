<?php

namespace App\Livewire;

use App\Models\Caisse;
use App\Models\Vente;
use App\Models\Methode;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class DetailsCaisse extends Component
{
    public $caisse;
    public $ventes;
    public $total_ventes = 0;
    public $totaux_par_methode = [];

    public function mount($id)
    {
        // On récupère la caisse spécifique
        $this->caisse = Caisse::with('user')->findOrFail($id);

        // On récupère toutes les ventes effectuées par ce caissier pendant cette session
         $this->ventes = Vente::with(['article', 'facture']) 
            ->where('ve_saisi_par', $this->caisse->user_id)
            ->where('created_at', '>=', $this->caisse->date_ouverture)
            ->when($this->caisse->date_cloture, function($query) {
                return $query->where('created_at', '<=', $this->caisse->date_cloture);
            })
            ->get();

        // Calcul du total global
        $this->total_ventes = $this->ventes->sum('ve_prix_tot');

        // Calcul du total par méthode de paiement
        // On récupère toutes les méthodes pour avoir les noms
        $methodes = Methode::all();
        
        foreach ($methodes as $methode) {
            $total = $this->ventes->where('type_p', $methode->id)->sum('ve_prix_tot');
            if ($total > 0) {
                $this->totaux_par_methode[] = [
                    'nom' => $methode->meth_nom,
                    'total' => $total
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.details-caisse');
    }
}