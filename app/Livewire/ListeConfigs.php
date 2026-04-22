<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use Livewire\WithPagination;

class ListeConfigs extends Component
{
    public function render()
    {
        // $roles1=Role::get(['id','name']);
        // foreach()
        // dd($roles1);
        $roles=Role::leftJoin('role_has_permissions','roles.id','=','role_has_permissions.role_id')
                                ->leftJoin('permissions','permissions.id','=','role_has_permissions.permission_id')
                                ->select('roles.id as rid','roles.name as rname','permissions.name as pname')
                                ->orderBy('rname')
                                ->paginate(10);
        $permissions=Permission::leftJoin('role_has_permissions','permissions.id','=','role_has_permissions.permission_id')
                                ->leftJoin('roles','roles.id','=','role_has_permissions.role_id')
                                ->select('roles.id as rid','roles.name as rname','permissions.name as pname')
                                ->orderBy('rname')
                                ->paginate(10);
        $users=User::leftJoin('model_has_roles','users.id','=','model_has_roles.model_id')
                    ->leftJoin('roles','roles.id','=','model_has_roles.role_id')
                    ->select('users.id','users.name','users.email', 'roles.name as nom')
                    ->paginate(10);
        //dd($permissions);
        return view('livewire.liste-configs',compact('users','permissions','roles'));
    }
}
