<?php

namespace App\Livewire;

use App\Models\Caisse;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;


#[Layout('layouts.app')]
class OuvrirCaisse extends Component
{
    public $montant_initial = 0;

    public function rules()
    {
        return [
            'montant_initial' => 'required|numeric|min:0',
        ];
    }

    public function ouvrir()
    {
        $this->validate();

        // Vérifier si l'utilisateur a déjà une caisse ouverte
        $caisseOuverte = Caisse::where('user_id', Auth::id())
                                ->where('statut', 'ouvert')
                                ->first();

        if ($caisseOuverte) {
            session()->flash('danger', 'Vous avez déjà une caisse ouverte.');
            return redirect()->route('pos.index');
        }

        // Créer la session de caisse
        Caisse::create([
            'user_id' => Auth::id(),
            'date_ouverture' => now(),
            'montant_initial' => $this->montant_initial,
            'statut' => 'ouvert',
        ]);

        session()->flash('success', 'Caisse ouverte avec succès. Bon service !');
        
        // Rediriger vers l'écran de vente (Point of Sale)
        // return redirect()->route('pos.index');
        // Rediriger vers la liste des caisses (qui affichera le bouton pour aller au POS)
        return redirect()->route('caisse.liste');
    }

    public function render()
    {
        return view('livewire.ouvrir-caisse');
    }
}