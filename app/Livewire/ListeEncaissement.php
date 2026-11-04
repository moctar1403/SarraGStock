<?php

namespace App\Livewire;

use App\Models\Payfournisseur;
use App\Models\Fournisseur;
use App\Models\Methode;
use App\Models\Operat;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\WithDelete;

#[Layout('layouts.app')]
class ListeEncaissement extends Component
{
    use WithPagination;
    
    use WithDelete {
        delete as protected traitDelete;
    }

    public $search = '';

    public function delete()
    {
        $encaissement = Payfournisseur::where('id', '=', $this->deleteId)->first();
        
        if (!$encaissement) {
            return redirect()->route('fournisseurs.encaisse_index')->with('danger', __('Encaissement introuvable.'));
        }

        $fournisseur = Fournisseur::find($encaissement->fournisseur_id);
        if ($fournisseur) {
            $fournisseur->four_situation -= $encaissement->fpay_montant;
            $fournisseur->save();
        }

        $methode = Methode::find($encaissement->fpay_type_p);
        if ($methode) {
            $methode->meth_solder -= $encaissement->fpay_montant;
            $methode->meth_soldev -= $encaissement->fpay_montant;
            $methode->save();
        }

        $encaissement->delete();

        $operats = Operat::where('operat_pa_four_id', '=', $encaissement->id)->get();
        foreach ($operats as $value) {
            $value->delete();
        }

        return redirect()->route('fournisseurs.encaisse_index')->with('success', __('Encaissement supprimé.'));
    }

    public function render()
    {
        // FILTRE : On n'affiche que les encaissements
        $query = Payfournisseur::leftJoin('fournisseurs', 'payfournisseurs.fournisseur_id', '=', 'fournisseurs.id')
                            ->leftJoin('methodes', 'payfournisseurs.fpay_type_p', '=', 'methodes.id')
                            ->select('fournisseurs.four_nom', 'payfournisseurs.*', 'methodes.meth_nom')
                            ->where('payfournisseurs.type_operation', 'encaissement'); // <-- LE FILTRE EST ICI

        if (!empty($this->search)) {
            $encaissements = $query->where(function($q) {
                                $q->where('fournisseurs.four_nom', 'like', '%' . $this->search . '%')
                                  ->orWhere('payfournisseurs.fpay_montant', 'like', '%' . $this->search . '%')
                                  ->orWhere('methodes.meth_nom', 'like', '%' . $this->search . '%')
                                  ->orWhere('payfournisseurs.fpay_date', 'like', '%' . $this->search . '%');
                            })
                            ->orderByDesc('payfournisseurs.updated_at')
                            ->paginate(10);
        } else {
            $encaissements = $query->orderByDesc('payfournisseurs.updated_at')
                               ->paginate(10);
        }

        return view('livewire.liste-encaissement', compact('encaissements'));
    }
}