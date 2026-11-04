<?php

namespace App\Livewire;

use App\Models\Fournisseur;
use App\Models\Methode;
use App\Models\Operat;
use App\Models\Payfournisseur;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class CreateEncaissementFournisseur extends Component
{
    public $fournisseur_id;
    public $current_fournisseur;
    public $fpay_type_p;
    public $fpay_montant;
    public $fpay_date;
    public $recherche_fournisseur;

    public function rules()
    {
        return [
            'fournisseur_id' => 'required|min:1',
            'fpay_montant' => 'required|numeric|min:1',
            'fpay_type_p' => 'required',
            'fpay_date' => 'required|date',
        ];
    }

    public function store(Payfournisseur $paiement)
    {
        $this->validate();

        try {
            $paiement->fournisseur_id = $this->current_fournisseur->id;
            $paiement->type_operation = 'encaissement';
            $paiement->fpay_montant = $this->fpay_montant;
            $paiement->fpay_frais = 0; // Pas de frais pour un encaissement
            $paiement->fpay_type_p = $this->fpay_type_p;
            $paiement->fpay_date = $this->fpay_date;
            $paiement->save();

            // 1. Le fournisseur nous a donné de l'argent, sa situation augmente (devient plus positive)
            $this->current_fournisseur->four_situation += (float)$this->fpay_montant;
            $this->current_fournisseur->save();

            // 2. On ajoute l'argent à notre caisse
            $methode = Methode::find($this->fpay_type_p);
            $methode->meth_solder += (float)$this->fpay_montant;
            $methode->meth_soldev += (float)$this->fpay_montant;
            $methode->save();

            // 3. On enregistre l'opération de trésorerie (entrée d'argent)
            Operat::create([
                'operat_meth_id' => $this->fpay_type_p,
                'operat_vent_id' => 0,
                'operat_tr_id' => 0,
                'operat_pa_cli_id' => 0,
                'operat_pa_four_id' => $paiement->id,
                'operat_montant' => $this->fpay_montant, // Positif car c'est une entrée
            ]);

            return redirect()->route('fournisseurs.pindex')->with('success', __('Encaissement fournisseur enregistré avec succès.'));
        } catch (Exception $e) {
            return redirect()->route('fournisseurs.pindex')->with('danger', 'Un problème est rencontré.');
        }
    }

    public function render()
    {
        if (!empty($this->recherche_fournisseur)) {
            $this->fournisseur_id = $this->recherche_fournisseur;
        }

        $this->current_fournisseur = Fournisseur::where('id', $this->fournisseur_id)
                                        ->orWhere('four_tel', $this->fournisseur_id)
                                        ->orWhere('four_email', $this->fournisseur_id)
                                        ->first();

        if ($this->current_fournisseur) {
            $this->fournisseur_id = $this->current_fournisseur->id;
        }

        // On affiche TOUS les fournisseurs (sauf l'ID 0) pour pouvoir leur donner un crédit
        $fournisseursList = Fournisseur::where('id', '!=', '0')
                            ->orderBy('id')
                            ->get();

        $methodesList = Methode::where('meth_active', '>', '0')
                                ->where('meth_nom', 'not like', 'credit')
                                ->get();

        return view('livewire.create-encaissement-fournisseur', compact('fournisseursList', 'methodesList'));
    }
}