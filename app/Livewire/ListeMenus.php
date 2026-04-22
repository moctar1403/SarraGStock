<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use Livewire\WithPagination;

class ListeMenus extends Component
{
    public function render()
    {
        $roles=Role::get();
        return view('livewire.liste-menus',compact('roles'));
    }
}
