<?php

namespace App\Livewire;

use App\Models\Payfournisseur;
use App\Models\Fournisseur;
use App\Models\Methode;
use App\Models\Operat;
use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Traits\WithDelete;

class ListePfournisseur extends Component
{
    use WithPagination;
    public $search = '';
    
    use WithDelete {
        delete as protected traitDelete;
    }

    public function delete()
    {
        $paiement = Payfournisseur::where('id', '=', $this->deleteId)->first();
        
        if (!$paiement) {
            return redirect()->route('fournisseurs.pindex')->with('danger', __('Paiement introuvable.'));
        }

        $montant_total = $paiement->fpay_montant + $paiement->fpay_frais;
        
        $current_fournisseur = Fournisseur::where('id', '=', $paiement->fournisseur_id)->first();
        if ($current_fournisseur) {
            $current_fournisseur->four_situation += $paiement->fpay_montant;
            $current_fournisseur->save();
        }

        $current_methode = Methode::where('id', $paiement->fpay_type_p)->first();
        if ($current_methode) {
            $current_methode->meth_solder += $montant_total;
            $current_methode->save();
        }

        $paiement->delete();

        $operats = Operat::where('operat_pa_four_id', '=', $paiement->id)->get();
        foreach ($operats as $value) {
            $value->delete();
        }
        
        return redirect()->route('fournisseurs.pindex')->with('success', __('Paiement supprimé'));
    }

    public function render()
    {
        // FILTRE : On n'affiche que les paiements
        $query = Payfournisseur::leftJoin('fournisseurs', 'payfournisseurs.fournisseur_id', '=', 'fournisseurs.id')
                            ->leftJoin('methodes', 'payfournisseurs.fpay_type_p', '=', 'methodes.id')
                            ->select('fournisseurs.four_nom', 'payfournisseurs.*', 'methodes.meth_nom')
                            ->where('payfournisseurs.type_operation', 'paiement'); // <-- LE FILTRE EST ICI

        if (!empty($this->search)) {
            $paiements = $query->where(function($q) {
                                $q->where('fournisseurs.four_nom', 'like', '%' . $this->search . '%')
                                  ->orWhere('payfournisseurs.fpay_montant', 'like', '%' . $this->search . '%')
                                  ->orWhere('methodes.meth_nom', 'like', '%' . $this->search . '%')
                                  ->orWhere('payfournisseurs.fpay_date', 'like', '%' . $this->search . '%');
                            })
                            ->orderByDesc('payfournisseurs.updated_at')
                            ->paginate(10);
        } else {
            $paiements = $query->orderByDesc('payfournisseurs.updated_at')
                               ->paginate(10);
        }

        return view('livewire.liste-pfournisseur', compact('paiements'));
    }
}