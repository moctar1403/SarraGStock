<?php

namespace App\Livewire;

use App\Models\Remboursement;
use App\Models\Client;
use App\Models\Methode;
use App\Models\Operat;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\WithDelete;

#[Layout('layouts.app')]
class ListeRemboursement extends Component
{
    use WithPagination;
    
    use WithDelete {
        delete as protected traitDelete;
    }

    public $search = '';

    public function delete()
    {
        $remboursement = Remboursement::where('id', '=', $this->deleteId)->first();
        
        if (!$remboursement) {
            return redirect()->route('remboursements.index')->with('danger', __('Remboursement introuvable.'));
        }

        // 1. Récupération du client et annulation de la situation
        // (Puisque c'était un remboursement, on avait augmenté sa situation. Donc on la diminue à nouveau)
        $current_client = Client::where('id', '=', $remboursement->client_id)->first();
        if ($current_client) {
            // $current_client->cli_situation -= $remboursement->rem_montant;
            $current_client->cli_situation += $remboursement->rem_montant; 
            $current_client->save();
        }

        // 2. Récupération de la méthode et annulation du solde
        // (Puisque c'était une sortie d'argent, on remet l'argent dans la caisse)
        $current_methode = Methode::where('id', $remboursement->rem_type_p)->first();
        if ($current_methode) {
            $current_methode->meth_solder += $remboursement->rem_montant;
            $current_methode->meth_soldev += $remboursement->rem_montant;
            $current_methode->save();
        }

        // 3. Suppression des opérations liées (table operats)
        $operats = Operat::where('operat_re_id', '=', $remboursement->id)->get();
        foreach ($operats as $operat) {
            $operat->delete();
        }

        // 4. Suppression du remboursement
        $remboursement->delete();

        return redirect()->route('remboursements.index')->with('success', __('Remboursement supprimé'));
    }

    public function render()
    {
        if (!empty($this->search)) {
            $remboursements = Remboursement::leftJoin('clients', 'remboursements.client_id', '=', 'clients.id')
                                 ->leftJoin('methodes', 'remboursements.rem_type_p', '=', 'methodes.id')
                                 ->select('clients.cli_nom', 'remboursements.*', 'methodes.meth_nom')
                                ->where('clients.cli_nom', 'like', '%' . $this->search . '%')
                                ->orWhere('remboursements.rem_montant', 'like', '%' . $this->search . '%')
                                ->orWhere('remboursements.rem_date', 'like', '%' . $this->search . '%')
                                ->orderByDesc('remboursements.updated_at')
                                ->paginate(10);
        } else {
            $remboursements = Remboursement::leftJoin('clients', 'remboursements.client_id', '=', 'clients.id')
                                    ->leftJoin('methodes', 'remboursements.rem_type_p', '=', 'methodes.id')
                                    ->select('clients.cli_nom', 'remboursements.*', 'methodes.meth_nom')
                                    ->orderByDesc('remboursements.updated_at')
                                    ->paginate(10);
        }
        return view('livewire.liste-remboursement', compact('remboursements'));
    }
}