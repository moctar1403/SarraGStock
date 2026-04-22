<?php

namespace App\Livewire;

use App\Models\Vente;
use App\Models\Methode;
use Livewire\Component;
use App\Models\Entrstock;
use Livewire\WithPagination;


class OpLmethode extends Component
{
    use WithPagination;
    public $search = '';

    public function delete(Methode $methode)
    {       
       
    }
    public function render()
    {
        // $methodes = Methode::where('meth_active','>',0)->get();
        $solde = Methode::where('meth_solder', '>', '0')
                            ->orderBy('id')
                            ->get();
        if (!empty($this->search)) {
            $solde = Methode::where('meth_solder', '>', '0')
                            ->where('meth_nom', 'like', '%' . $this->search . '%')
                            ->orWhere('meth_solder', 'like', '%' . $this->search . '%')
                            ->orWhere('meth_soldev', 'like', '%' . $this->search . '%')
                            ->orderBy('id')
                            ->get();
            // $methodes = Methode::where('meth_nom', 'like', '%' . $this->search . '%')
            //                 ->orWhere('meth_solde', 'like', '%' . $this->search . '%')
            //                 ->get();
        }
        $credit=Methode::where('meth_nom', 'like', 'credit')
                            ->first(); 
        $credit_id=$credit->id;

        return view('livewire.op-lmethode',compact('solde','credit_id'));
    }
}
