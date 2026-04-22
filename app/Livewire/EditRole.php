<?php

namespace App\Livewire;

use Livewire\Component;

class EditRole extends Component
{
    public $role;
    public function render()
    {
        return view('livewire.edit-role');
    }
}
