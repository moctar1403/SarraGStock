<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class EditUser2 extends Component
{
    public $user;
    public $userRoles;
    public $roles;
    public function render()
    {
        return view('livewire.edit-user2');
    }
}
