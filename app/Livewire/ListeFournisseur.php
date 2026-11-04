<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Entrstock;
use App\Models\Fournisseur;
use Livewire\WithPagination;
use App\Livewire\Traits\WithDelete;
use App\Models\Payfournisseur; 

class ListeFournisseur extends Component
{
    use WithPagination;
    
    public $search = '';
    
    use WithDelete {
        delete as protected traitDelete;
    }
    
    public function delete()
    {
        $fournisseur = Fournisseur::where('id', '=', $this->deleteId)->first();
        
        if (!$fournisseur) {
            return redirect()->route('fournisseurs.index')->with('danger', __("Fournisseur introuvable."));
        }

        // 1. Vérification s'il y a une entrée en stock pour le fournisseur 
        $entree = Entrstock::where('ent_fournisseur', $fournisseur->id)->first();
        if ($entree) {
            return redirect()->route('fournisseurs.index')->with('danger', __("Fournisseur n'est pas supprimé, car il a une entrée en stock"));
        }

        // 2. Vérification s'il y a un paiement ou un encaissement (même table)
        $paiement = Payfournisseur::where('fournisseur_id', $fournisseur->id)->first();
        if ($paiement) {
            return redirect()->route('fournisseurs.index')->with('danger', __("Fournisseur n'est pas supprimé, car il a un historique de paiement ou d'encaissement"));
        }

        // Si tout est bon, on supprime
        $fournisseur->delete();
        
        // Tracing
        $data = "Suppression du fournisseur id " . $fournisseur->id . " nom " . $fournisseur->four_nom;
        $model = "App\Models\Fournisseur";
        trace($data, $model);
        
        return redirect()->route('fournisseurs.index')->with('success', __('Fournisseur supprimé'));
    }

    public function render()
    {
        if (!empty($this->search)) {
            $fournisseurs = Fournisseur::where('four_nom', 'like', '%' . $this->search . '%')
                            ->orWhere('four_societe', 'like', '%' . $this->search . '%')
                            ->orWhere('four_civilite', 'like', '%' . $this->search . '%')
                            ->orWhere('four_tel', 'like', '%' . $this->search . '%')
                            ->orWhere('four_adresse', 'like', '%' . $this->search . '%')
                            ->orWhere('four_email', 'like', '%' . $this->search . '%')
                            ->orWhere('four_saisi_par', 'like', '%' . $this->search . '%')
                            ->orderByDesc('four_situation')
                            ->paginate(10);
        } else {
            $fournisseurs = Fournisseur::where('id', '>', 0)
                            ->orderByDesc('four_situation')
                            ->paginate(10);
        } 

        return view('livewire.liste-fournisseur', compact('fournisseurs'));
    }
}