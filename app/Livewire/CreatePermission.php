<?php 

namespace App\Livewire;

use App\helpers;
use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreatePermission extends Component
{
    public $name;
    public function store()
    {
        $this->validate([
            'name'=>'required|string|min:4|unique:permissions,name',
        ]);
        Permission::create([
            'name'=>$this->name,
        ]);
        $permission=Permission::where('name', $this->name)->first();
        // Assigner la permission au super admin
        // Méthode 1: Si vous avez un rôle super-admin
        $superAdminRole = Role::where('name', 'super-admin')->first();
        if ($superAdminRole) {
            $superAdminRole->givePermissionTo($permission);
        }
        //trace
        $data="création de permission ".$this->name;
        $model="Spatie\Permission\Models\Permission";
        trace($data,$model);  
        //end trace   
        return redirect('permissions')->with('succes',__('Permission créée avec succès'));
    }
    public function render()
    {
        return view('livewire.create-permission');
    }
}
