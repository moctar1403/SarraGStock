<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Vente;
use App\Models\Payement;
use App\Models\Remboursement; // <-- NOUVEAU
use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Traits\WithDelete;
use Illuminate\Support\Facades\Gate;

class ListeClient extends Component
{
    use WithPagination;
    public $search = '';
    
    use WithDelete {
        delete as protected traitDelete;
    }

    public function delete()
    {
        // Vérification de la permission
        if (!Gate::allows('delete client')) {
            return redirect()->route('clients.index')->with('danger', __("Vous n'avez pas la permission de suppression"));
        }

        $client = Client::where('id', '=', $this->deleteId)->first();
        
        if (!$client) {
            return redirect()->route('clients.index')->with('danger', __("Client introuvable."));
        }

        // 1. Vérification des ventes en cours
        $vente = Vente::where('ve_client', $client->id)->first();
        if ($vente) {
            return redirect()->route('clients.index')->with('danger', __("Client n'est pas supprimé car il a des ventes en cours, voir la liste des ventes"));
        }

        // 2. Vérification des paiements en cours
        $paiement = Payement::where('client_id', $client->id)->first();
        if ($paiement) {
            return redirect()->route('clients.index')->with('danger', __("Client n'est pas supprimé car il a des paiements en cours, voir la liste des paiements"));
        }

        // 3. NOUVEAU : Vérification des remboursements
        $remboursement = Remboursement::where('client_id', $client->id)->first();
        if ($remboursement) {
            return redirect()->route('clients.index')->with('danger', __("Client n'est pas supprimé car il a un historique de remboursement"));
        }

        // Si tout est bon, on supprime
        $client->delete();
        
        $this->deleteId = null;
        
        // Tracing
        $data = "Suppression du client id " . $client->id . " libelle " . $client->cli_nom;
        $model = "App\Models\Client";
        trace($data, $model);
        
        return redirect()->route('clients.index')->with('success', __('Client supprimé'));
    }
    
    public function render()
    {
        if (!empty($this->search)) {
            $clients = Client::where('cli_nom', 'like', '%' . $this->search . '%')
                            ->orWhere('cli_societe', 'like', '%' . $this->search . '%')
                            ->orWhere('cli_civilite', 'like', '%' . $this->search . '%')
                            ->orWhere('cli_tel', 'like', '%' . $this->search . '%')
                            ->orWhere('cli_adresse', 'like', '%' . $this->search . '%')
                            ->orWhere('cli_email', 'like', '%' . $this->search . '%')
                            ->orWhere('cli_observations', 'like', '%' . $this->search . '%')
                            ->orderByDesc('cli_situation')
                            ->paginate(10);
        } else {
            $clients = Client::where('id', '>', 0)
                            ->orderByDesc('cli_situation')
                            ->paginate(10);      
        } 

        return view('livewire.liste-client', compact('clients'));
    }
}