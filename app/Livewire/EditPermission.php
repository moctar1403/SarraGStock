<?php

namespace App\Livewire;

use Livewire\Component;

class EditPermission extends Component
{
    public $permission;
    public function render()
    {
        return view('livewire.edit-permission');
    }
}
