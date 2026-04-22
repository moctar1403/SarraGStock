<?php

namespace App\Livewire;

use App\Models\Operat;
use App\Models\Methode;
use Livewire\Component;
use App\Models\Transfert;
use Livewire\WithPagination;
use App\Livewire\Traits\WithDelete;

class Ltransfert extends Component
{
    use WithPagination;
    public $search = '';
    // écoute l'événement JS 'confirmDelete'
    use WithDelete {
        delete as protected traitDelete;
    }
    
    public function delete()
    {
        $transfert=Transfert::where('id','=',$this->deleteId)->first();
        //recuperation de la methode envoyante
        $current_methode1=Methode::where('meth_nom','like',$transfert->tr_meth_env_nom)->first();
        //actualisation 
        $current_methode1->meth_solder=$current_methode1->meth_solder+$transfert->tr_montant+$transfert->tr_frais;
        $current_methode1->save();
        /////////////////////////////////////////////////////////////////////////////
        //recuperation de la méthode beneficiante
        $current_methode2=Methode::where('meth_nom','like',$transfert->tr_meth_ben_nom)->first();
        //actualisation 
        $current_methode2->meth_solder=$current_methode2->meth_solder-$transfert->tr_montant;
        $current_methode2->save();
        //suppression de l'enregistrement de la table operats
        $operat=Operat::where('operat_tr_id',$transfert->id)->first();
        if ($operat) {
            $operat->delete();
             //tracing
             $data="Suppresion de l'operat id ".$operat->id." ";
             $model="App\Models\Operat";
             trace($data,$model);   
        }
        //annulation le transfert
        $transfert->delete();
         //tracing
         $data="Suppresion du transfert id ".$transfert->id." ";
         $model="App\Models\Transfert";
         trace($data,$model);
        return redirect()->route('operation.ltransfert')->with('success', 'Le transfert est annulé');

        //return redirect()->route('transferts.index')->with('danger', 'transfert n est pas annulé car le stock réel est inférieur ');      
    }
    public function render()
    {
        $transfert=Transfert::paginate(10);
        if (!empty($this->search)) {
            $transfert=Transfert::where('tr_meth_env_nom', 'like', '%' . $this->search . '%')
                                    ->orWhere('tr_meth_ben_nom', 'like', '%' . $this->search . '%')
                                    ->paginate(10);
        }
        
        return view('livewire.ltransfert',compact('transfert'));
    }
}
