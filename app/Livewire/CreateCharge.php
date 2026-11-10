<?php

namespace App\Livewire;

use App\Models\Charge;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Exception;

#[Layout('layouts.app')]
class CreateCharge extends Component
{
    public $ch_libelle;
    public $ch_montant;
    public $ch_date;
    public $ch_observations;
    // ❌ public $methode_id; supprimé

    public function mount()
    {
        $this->ch_date = now()->format('Y-m-d');
    }

    public function rules()
    {
        return [
            'ch_libelle' => 'required|string|max:255',
            'ch_montant' => 'required|numeric|min:1',
            'ch_date' => 'required|date',
            'ch_observations' => 'nullable|string',
            // ❌ règle methode_id supprimée
        ];
    }

    public function store()
    {
        $this->validate();

        try {
            // Enregistrement unique de la charge (plus de déduction, plus d'opération)
            Charge::create([
                'ch_libelle' => $this->ch_libelle,
                'ch_montant' => $this->ch_montant,
                'ch_date' => $this->ch_date,
                'user_id' => Auth::id(),
                'ch_observations' => $this->ch_observations,
                // ❌ methode_id supprimé
            ]);

            session()->flash('success', __('Charge enregistrée avec succès.'));
            return redirect()->route('charges.index');

        } catch (Exception $e) {
            session()->flash('danger', __('Un problème est survenu.'));
        }
    }

    public function render()
    {
        // ❌ On ne charge plus la liste des méthodes
        return view('livewire.create-charge');
    }
}