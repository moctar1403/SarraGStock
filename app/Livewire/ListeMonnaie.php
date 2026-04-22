<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Monnaie;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;

class ListeMonnaie extends Component
{
    use WithPagination;
    public $search = '';
    public $msg = '';

    public function delete(Monnaie $monnaie)
    {
            //pas de verification
            $monnaie->delete();
             //tracing
             $data="Suppresion de la monnaie id ".$monnaie->id." libelle ".$monnaie->monn_lib. " ";
             $model="App\Models\Monnaie";
             trace($data,$model);
            return redirect()->route('configs.monnaie')->with('success', 'Monnaie supprimée');
    }
    public function toggleStatus(Monnaie $monn){
        // Vérifier permission
        if (!Gate::allows('update monnaie')) {
            return redirect()->route('configs.monnaie')->with('danger', 'Action non autorisée');
        }
        $query=Monnaie::where('monn_active','1')->update(['monn_active'=>'0']);
        $monn->monn_active='1';
        $monn->save();
        $this->msg=__('Monnaie modifiée avec succès en ')." ".__($monn->monn_lib)." ".__($monn->monn_code);
        // $this->render()->with('success','Monnaie modifiée avec succès');
        return redirect()->route('configs.monnaie')->with('success',$this->msg);
    }
    public function render()
    {
        $monnaies = Monnaie::orderByDesc('monn_active')->paginate(10);
        if (!empty($this->search)) {
            $monnaies = Monnaie::where('monn_lib', 'like', '%' . $this->search . '%')
                            ->orWhere('monn_sym', 'like', '%' . $this->search . '%')
                            ->orWhere('monn_code', 'like', '%' . $this->search . '%')
                            ->orderByDesc('monn_active')
                            ->paginate(10);
        } 

        return view('livewire.liste-monnaie',compact('monnaies'));
    }
}
