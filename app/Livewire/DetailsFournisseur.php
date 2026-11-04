<?php

namespace App\Livewire;

use App\Models\Fournisseur;
use App\Models\Entrstock;
use App\Models\Payfournisseur;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class DetailsFournisseur extends Component
{
    public $fournisseur;
    public $entrees;
    public $paiements;
    public $historique;

    public function mount($id)
    {
        $this->fournisseur = Fournisseur::findOrFail($id);

        // 1. On récupère les entrées en stock
        $this->entrees = Entrstock::where('ent_fournisseur', $this->fournisseur->id)->get();

        // 2. On récupère les opérations
        $this->paiements = Payfournisseur::where('fournisseur_id', $this->fournisseur->id)->get();

        // 3. On fusionne et on trie par date décroissante
        $this->historique = collect()
            ->merge($this->entrees->map(fn($e) => [
                'date' => $e->created_at,
                'type' => 'Entrée en stock',
                'montant' => $e->ent_qte * $e->ent_prix_achat,
                'ref' => 'Entrée #' . $e->id,
                'color' => 'red'
            ]))
            ->merge($this->paiements->map(function($p) {
                // DISTINCTION FIABLE
                $isEncaissement = ($p->type_operation === 'encaissement');
                
                return [
                    'date' => $p->created_at,
                    'type' => $isEncaissement ? 'Encaissement' : 'Paiement',
                    'montant' => $isEncaissement ? -$p->fpay_montant : $p->fpay_montant,
                    'ref' => ($isEncaissement ? 'Encaissement #' : 'Paiement #') . $p->id,
                    'color' => $isEncaissement ? 'blue' : 'green'
                ];
            }))
            ->sortByDesc('date');
    }

    public function render()
    {
        return view('livewire.details-fournisseur');
    }
}