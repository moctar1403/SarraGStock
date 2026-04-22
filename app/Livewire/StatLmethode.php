<?php

namespace App\Livewire;

use App\Models\Vente;
use App\Models\Methode;
use Livewire\Component;
use App\Models\Entrstock;
use Livewire\WithPagination;


class StatLmethode extends Component
{
    use WithPagination;
    public $search = '';

    public function delete(Methode $methode)
    {       
       
    }
    public function render()
    {
        // $methodes = Methode::where('meth_active','>',0)->get();
        $solde = Methode::where('meth_active', '>', 0)
                            ->orderBy('id')
                            ->get();
         
        if (!empty($this->search)) {
            $solde = Methode::where('meth_active', '>', 0)
                            ->where('meth_nom', 'like', '%' . $this->search . '%')
                            ->orWhere('meth_solder', 'like', '%' . $this->search . '%')
                            ->orWhere('meth_soldev', 'like', '%' . $this->search . '%')
                            ->orderBy('id')
                            ->get();
        } 

        return view('livewire.stat-lmethode',compact('solde'));
    }
}
