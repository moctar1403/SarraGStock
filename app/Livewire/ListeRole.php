<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use App\Livewire\Traits\WithDelete;

class ListeRole extends Component
{
    use WithPagination;
    use WithDelete {
        delete as protected traitDelete;
    }
    
    public function delete()
    {
        $role=Role::where('id','=',$this->deleteId)->first();
         
        // $role=Role::find($roleId);
        //Trace
        $data="suppression du role ".$role->name." ";
        $model="Spatie\Permission\Models\Role";
        trace($data,$model);  
        //end Trace  
        $role->delete();
        return redirect('roles')->with('succes',__('Rôle supprimé avec succès'));
    }
    public function render()
    {
        $roles=Role::get();
        return view('livewire.liste-role',compact('roles'));
    }
}
