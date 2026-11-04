<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Methode;
use App\Models\Operat;
use App\Models\Remboursement;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class CreateRemboursement extends Component
{
    public $client_id;
    public $current_client;
    public $rem_type_p;
    public $rem_montant;
    public $rem_date;
    public $recherche_client;

    public function rules()
    {
        return [
            'client_id' => 'required|min:1',
            'rem_montant' => 'required|numeric|min:1',
            'rem_type_p' => 'required',
            'rem_date' => 'required|date',
        ];
    }

    public function store(Remboursement $remboursement)
    {
        $this->validate();

        try {
            $remboursement->client_id = $this->current_client->id;
            $remboursement->rem_montant = $this->rem_montant;
            $remboursement->rem_type_p = $this->rem_type_p;
            $remboursement->rem_date = $this->rem_date;
            $remboursement->save();

            // 1. Le client a reçu de l'argent, donc sa situation diminue (elle devient négative = crédit)
            $this->current_client->cli_situation -= (float)$this->rem_montant;
            $this->current_client->save();

            // 2. On retire l'argent de la caisse
            $methode = Methode::find($this->rem_type_p);
            $methode->meth_solder -= (float)$this->rem_montant;
            $methode->meth_soldev -= (float)$this->rem_montant;
            $methode->save();

            // 3. On enregistre l'opération de trésorerie (sortie d'argent)
            Operat::create([
                'operat_meth_id' => $this->rem_type_p,
                'operat_vent_id' => 0,
                'operat_tr_id' => 0,
                'operat_pa_cli_id' => 0,
                'operat_pa_four_id' => 0,
                'operat_re_id' => $remboursement->id,
                'operat_montant' => -$this->rem_montant, // Négatif car c'est une sortie
            ]);

            return redirect()->route('remboursements.index')->with('success', __('Remboursement enregistré avec succès.'));
        } catch (Exception $e) {
            return redirect()->route('remboursements.index')->with('danger', 'Un problème est rencontré.');
        }
    }

    public function render()
    {
        if (!empty($this->recherche_client)) {
            $this->client_id = $this->recherche_client;
        }

        $this->current_client = Client::where('id', $this->client_id)
                                        ->orWhere('cli_tel', $this->client_id)
                                        ->orWhere('cli_email', $this->client_id)
                                        ->first();

        if ($this->current_client) {
            $this->client_id = $this->current_client->id;
        }

        // On affiche TOUS les clients (sauf l'ID 0) pour pouvoir leur donner un crédit
        $clientsList = Client::where('id', '!=', '0')
                            ->orderBy('id')
                            ->get();

        $methodesList = Methode::where('meth_active', '>', '0')
                                ->where('meth_nom', 'not like', 'credit')
                                ->get();

        return view('livewire.create-remboursement', compact('clientsList', 'methodesList'));
    }
}