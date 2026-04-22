<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Societe;
use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Traits\WithDelete;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class LSociete extends Component
{
    use WithPagination;
    public $search = '';
    use WithDelete {
        delete as protected traitDelete;
    }
    public function delete()
    {
        // Vérifier la permission avant d'exécuter
        // if (!Gate::allows('delete societe')) {
        //     $this->dispatch('show-toast', [
        //         'type' => 'error',
        //         'message' => 'Vous n\'avez pas la permission de suppression.'
        //     ]);
        //     return;
        // }
        $societe=Societe::where('id','=',$this->deleteId)->first();
        $societe->delete();
        return redirect()->route('configs.societe')->with('success', __('Infomations supprimées'));
    }
    public function modifier(Article $article)
    {
        return redirect()->route('configs.societe')->with('success', 'Infomations modifiées');
    }
     public function mount()
    {

    }
    public function render()
    { 
            $societe = Societe::first();
            if ($societe) {
                $path = $societe->soc_logo ? str_replace('storage/', '', $societe->soc_logo) : null;
                // $path = $societe->soc_logo ? $societe->soc_logo : null;
                //$logoExists = $path && Storage::disk('public')->exists($path);
            }
            else {
                $societe='';
                //$logoExists='';
            }
            
        return view('livewire.l-societe',compact('societe'));
    }
}
