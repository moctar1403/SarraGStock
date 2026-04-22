<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Unite;
use App\Models\Entrstock;
use Livewire\WithPagination;


class ListeUnite extends Component
{
    use WithPagination;
    public $search = '';

    public function delete(Unite $unite)
    {    
            $unite->delete();
             //tracing
             $data="Suppresion de l'unite id ".$unite->id. " ";
             $model="App\Models\Unite";
             trace($data,$model);
            return redirect()->route('unites.index')->with('success',"l'unité est supprimée");
    }
    public function render()
    {
        $unites = Unite::paginate(10);
        if (!empty($this->search)) {
            $unites = Unite::where('unit_lib', 'like', '%' . $this->search . '%')
                            ->paginate(10);
        } 

        return view('livewire.liste-unite',compact('unites'));
    }
}
