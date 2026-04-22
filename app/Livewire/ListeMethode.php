<?php

namespace App\Livewire;

use App\Models\Methode;
use Livewire\Component;
use App\Models\Entrstock;
use Livewire\WithPagination;
use App\Livewire\Traits\WithDelete;


class ListeMethode extends Component
{
    use WithPagination;
    public $search = '';
use WithDelete {
        delete as protected traitDelete;
    }
    public function delete()
    {
        $methode=Methode::where('id','=',$this->deleteId)->first();
        //verification s'il y a une entree pour le fournisseur 
        $methode->delete();
        return redirect()->route('methodes.index')->with('success', 'Methode de paiement supprimée');
       
    }
    public function render()
    {
        $methodes = Methode::where('id','>',0)
                            ->orderByDesc('meth_active')
                            ->paginate(10);
        
        if (!empty($this->search)) {
            $methodes = Methode::where('meth_nom', 'like', '%' . $this->search . '%')
                            ->orWhere('meth_tel', 'like', '%' . $this->search . '%')
                            ->orWhere('meth_active', 'like', '%' . $this->search . '%')
                            ->orWhere('created_at', 'like', '%' . $this->search . '%')
                            ->orderByDesc('meth_active')
                            ->paginate(10);
        } 

        return view('livewire.liste-methode',compact('methodes'));
    }
}
