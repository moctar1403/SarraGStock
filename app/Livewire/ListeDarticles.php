<?php

namespace App\Livewire;

use App\Models\Unite;
use App\Models\Article;
use Livewire\Component;
use App\Models\Darticle;
use App\Models\Entrstock;
use App\Models\Sortstock;
use Livewire\WithPagination;
use App\Livewire\Traits\WithDelete;

class ListeDarticles extends Component
{
    use WithPagination;
    public $search = '';
    use WithDelete {
        delete as protected traitDelete;
    }
    public function delete()
    {
        $darticle=Darticle::where('id','=',$this->deleteId)->first();
         //deleting
        $darticle->delete();
        //tracing
        $data="Suppresion de l'article id ".$darticle->id." ";
        $model="App\Models\Darticle";
        trace($data,$model);
        return redirect()->route('darticles.index')->with('success', __('Configuration détail article supprimée'));        
    }
    public function render()
    { 
        if (!empty($this->search)) {
            $darticles = Darticle::where('dar_principal', 'like', '%' . $this->search . '%')
                                ->orWhere('dar_detail', 'like', '%' . $this->search . '%')
                                ->paginate(10);
        }else{
            $darticles = Darticle::paginate(10);
        }

        return view('livewire.liste-darticles',compact('darticles'));
    }
}
