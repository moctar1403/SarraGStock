<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Vente;
use App\Models\Payement;
use App\Models\Remboursement;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class DetailsClient extends Component
{
    public $client;
    public $ventes;
    public $paiements;
    public $remboursements;
    public $historique;

        public function mount($id)
    {
        $this->client = Client::findOrFail($id);

        // On récupère l'ID de la méthode "Crédit"
        $creditId = \App\Models\Methode::where('meth_nom', 'like', '%credit%')->value('id');

        // On récupère UNIQUEMENT les ventes à crédit (qui ont généré une dette)
        $this->ventes = Vente::where('ve_client', $this->client->id)
                             ->where('type_p', $creditId)
                             ->with('facture')
                             ->get();

        // Les paiements (qui réduisent la dette)
        $this->paiements = Payement::where('client_id', $this->client->id)->get();
        
        // Les remboursements (qui augmentent la dette ou créent un crédit)
        $this->remboursements = Remboursement::where('client_id', $this->client->id)->get();

        // On fusionne et on trie par date décroissante
        $this->historique = collect()
            ->merge($this->ventes->map(fn($v) => [
                'date' => $v->created_at,
                'type' => 'Vente (Crédit)',
                'montant' => $v->ve_prix_tot,
                'ref' => 'Facture #' . $v->facture_id,
                'color' => 'red'
            ]))
            ->merge($this->paiements->map(fn($p) => [
                'date' => $p->created_at,
                'type' => 'Paiement',
                'montant' => -$p->pay_montant,
                'ref' => 'Paiement #' . $p->id,
                'color' => 'green'
            ]))
            ->merge($this->remboursements->map(fn($r) => [
                'date' => $r->created_at,
                'type' => 'Remboursement',
                'montant' => $r->rem_montant,
                'ref' => 'Remboursement #' . $r->id,
                'color' => 'blue'
            ]))
            ->sortByDesc('date');
    }

    public function render()
    {
        return view('livewire.details-client');
    }
}