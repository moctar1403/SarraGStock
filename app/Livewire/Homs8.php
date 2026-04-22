<?php

namespace App\Livewire;
use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;


class Homs8 extends Component
{
    use WithPagination;
    public $previous;
    public function mount(){
        
    }
    public function render(Request $request)
    {
    //    $this->previous = $request->session()->previousUrl();     
         return view('livewire.homs8');
    }
}
