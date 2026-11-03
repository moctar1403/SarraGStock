<?php

namespace App\Livewire;

use App\Models\Caisse;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class HistoriqueCaisses extends Component
{
    use WithPagination;

    public $search = '';
    public $maCaisseOuverte = null;

    public function mount()
    {
        // On vérifie si l'utilisateur connecté a une caisse ouverte
        $this->maCaisseOuverte = Caisse::where('user_id', Auth::id())
                                        ->where('statut', 'ouvert')
                                        ->first();
    }

    public function render()
    {
        $caisses = Caisse::with('user')
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhere('statut', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('date_ouverture')
            ->paginate(10);

        return view('livewire.historique-caisses', compact('caisses'));
    }
}