<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


class Homs7 extends Component
{
    use WithPagination;
    public $previous;
    public function mount(){
        
    }
    public function render(Request $request)
    {
        $this->previous = $request->session()->previousUrl();                   
         return view('livewire.homs7');
    }
}
