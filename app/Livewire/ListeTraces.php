<?php

namespace App\Livewire;

use App\Models\Trace;
use Livewire\Component;

use Livewire\WithPagination;

class ListeTraces extends Component
{
    use WithPagination;
    public $search = '';

    public function delete()
    {
        try {
            // Supprimer toutes les traces
            Trace::truncate(); // Ou votre logique de suppression spécifique
            
            session()->flash('success', 'Toutes les traces ont été supprimées avec succès.');
            
            // Fermer le modal après suppression
            $this->dispatch('close-delete-modal');
            
        } catch (\Exception $e) {
            session()->flash('danger', 'Une erreur est survenue lors de la suppression.');
        }
    }
    public function render()
    { 
        if (!empty($this->search)) {
            $traces = Trace::orderBy('created_at','desc')
                            ->where('ip', 'like', '%' . $this->search . '%')
                            ->orWhere('user_id', 'like', '%' . $this->search . '%')
                            ->orWhere('user_name', 'like', '%' . $this->search . '%')
                            ->orWhere('session', 'like', '%' . $this->search . '%')
                            ->orWhere('model', 'like', '%' . $this->search . '%')
                            ->orderBy('created_at','desc')
                            ->paginate(10);
        }else{
            $traces = Trace::orderBy('created_at','desc')
                                ->paginate(10);            
        }

        return view('livewire.liste-traces',compact('traces'));
    }
}
