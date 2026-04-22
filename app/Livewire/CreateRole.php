<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\helpers;

class CreateRole extends Component
{
    public $name;
    public function store()
    {
        $this->validate([
            'name'=>'required|string|min:4|unique:roles,name',
        ]);
        Role::create([
            'name'=>$this->name,
        ]);
        //trace
        $data="enregistrement du role ".$this->name." ";
        $model="Spatie\Permission\Models\Role";
        trace($data,$model);  
        //end trace   
        return redirect('roles')->with('succes',__('Rôle créé avec succès'));
    }
    public function render()
    {
        return view('livewire.create-role');
    }
}
