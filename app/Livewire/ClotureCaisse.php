<?php

namespace App\Livewire;

use App\Models\Caisse;
use App\Models\Vente;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ClotureCaisse extends Component
{
    public $caisse;
    public $total_ventes = 0;
    public $montant_theorique = 0;
    public $montant_final_reel = 0;
    public $ecart = 0;

    public function mount()
    {
        $this->caisse = Caisse::where('user_id', Auth::id())
                                ->where('statut', 'ouvert')
                                ->first();

        if (!$this->caisse) {
            return redirect()->route('caisse.ouvrir');
        }

        // Calculer le total des ventes depuis l'ouverture
        // On suppose que 'type_p' = 1 correspond à Espèces
        $this->total_ventes = Vente::where('ve_saisi_par', Auth::id())
                                    ->where('created_at', '>=', $this->caisse->date_ouverture)
                                    ->sum('ve_prix_tot');

        // Le montant théorique = Fond de caisse + Ventes
        $this->montant_theorique = $this->caisse->montant_initial + $this->total_ventes;
        
        // Par défaut, on pré-remplit le réel avec le théorique
        $this->montant_final_reel = $this->montant_theorique;
    }

    public function updatedMontantFinalReel()
    {
        // Calculer l'écart à chaque fois que le caissier tape un montant
        $this->ecart = $this->montant_final_reel - $this->montant_theorique;
    }

    public function cloturer()
    {
        $this->validate([
            'montant_final_reel' => 'required|numeric|min:0',
        ]);

        // Mettre à jour la caisse
        $this->caisse->update([
            'date_cloture' => now(),
            'montant_final_reel' => $this->montant_final_reel,
            'montant_theorique' => $this->montant_theorique,
            'ecart' => $this->montant_final_reel - $this->montant_theorique,
            'statut' => 'ferme',
        ]);

        // session()->flash('success',  __('Caisse clôturée avec succès. Écart : ')  . format_number($this->ecart));
        // session()->flash('success', __('Caisse clôturée avec succès. Écart : :ecart', ['ecart' => format_number($this->ecart)]));
        session()->flash('success', __('Caisse clôturée avec succès. Écart : :ecart', ['ecart' => number_format($this->ecart, 2)]));
        return redirect()->route('caisse.liste');
        // return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.cloture-caisse');
    }
}