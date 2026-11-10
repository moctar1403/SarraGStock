<?php

namespace App\Livewire;

use App\Models\Charge;
use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Traits\WithDelete;
use Illuminate\Support\Facades\Gate;

class ListeCharges extends Component
{
    use WithPagination;

    public $search = '';

    // On garde le trait WithDelete pour la suppression unitaire
    use WithDelete {
        delete as protected traitDelete;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Suppression d'une seule charge (SANS toucher à la méthode de paiement)
    public function delete()
    {
        if (!Gate::allows('delete charge')) {
            session()->flash('danger', "Vous n'avez pas la permission de suppression");
            return;
        }

        $charge = Charge::find($this->deleteId);

        if ($charge) {
            $libelle = $charge->ch_libelle;
            
            // 👉 ON SUPPRIME JUSTE LA CHARGE, PAS DE REMBOURSEMENT DE LA METHODE
            $charge->delete();

            // Tracing
            $data = __('Suppression de la charge id :id libelle :libelle', [
                'id' => $charge->id,
                'libelle' => $libelle
            ]);
            trace($data, "App\Models\Charge");

            session()->flash('success', __('Charge') . ' ' . $libelle . ' ' . __('supprimée'));
        }

        $this->reset('deleteId');
    }

    // Statistiques
    private function getStats($charges)
    {
        $totalCharges = $charges->total();

        $today = now()->toDateString();
        $todayTotal = Charge::whereDate('ch_date', $today)->sum('ch_montant');
        $monthTotal = Charge::whereMonth('ch_date', now()->month)
                             ->whereYear('ch_date', now()->year)
                             ->sum('ch_montant');

        return [
            [
                'label' => 'Total Charges',
                'value' => $totalCharges,
                'color' => 'blue',
                'icon' => '<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>'
            ],
            [
                'label' => "Charges aujourd'hui",
                'value' => format_number($todayTotal),
                'color' => 'green',
                'icon' => '<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
            ],
            [
                'label' => 'Charges du mois',
                'value' => format_number($monthTotal),
                'color' => 'yellow',
                'icon' => '<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" /></svg>'
            ],
        ];
    }

    // Requête de base (jointure UNIQUEMENT avec users, plus de methodes)
    private function buildBaseQuery()
    {
        return Charge::leftJoin('users', 'charges.user_id', '=', 'users.id')
                     ->select(
                         'charges.*',
                         'users.name as user_name'
                     );
    }

    // Filtres de recherche
    private function applySearchFilters($query)
    {
        if (!empty($this->search)) {
            return $query->where(function ($q) {
                $q->where('ch_libelle', 'like', '%' . $this->search . '%')
                  ->orWhere('ch_observations', 'like', '%' . $this->search . '%')
                  ->orWhere('ch_montant', 'like', '%' . $this->search . '%')
                  ->orWhere('users.name', 'like', '%' . $this->search . '%');
            });
        }
        return $query;
    }

    public function render()
    {
        $query = $this->buildBaseQuery();
        $query = $this->applySearchFilters($query);

        $charges = $query->orderByDesc('ch_date')->paginate(10);

        $stats = $this->getStats($charges);

        $searchInfo = $this->search
            ? __('Résultats pour') . ' : ' . $this->search
            : null;

        return view('livewire.liste-charges', [
            'charges' => $charges,
            'stats' => $stats,
            'searchInfo' => $searchInfo,
            'search' => $this->search,
        ]);
    }
}