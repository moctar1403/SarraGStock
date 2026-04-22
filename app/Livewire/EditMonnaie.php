<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Monnaie;
use App\Models\Entrstock;
use Illuminate\Support\Facades\Auth;


class EditMonnaie extends Component
{
    public $monnaie;
    public $monn_lib;
    public $monn_sym;
    public $monn_code;
    
    public function store()
    {
        $monnaie=Monnaie::find($this->monnaie->id);
        $this->validate([
            'monn_lib' => 'required|string|min:3|unique:monnaies,monn_lib,'.$monnaie->id,
            'monn_sym' => 'required|string',
            'monn_code' => 'required|string|unique:monnaies,monn_code,'.$monnaie->id,
        ]);
        try {
            $monnaie->update([
                'monn_lib' => $this->monn_lib,
                'monn_sym' => $this->monn_sym,
                'monn_code' => $this->monn_code,
                'monn_saisi_par' => Auth::user()->id,
            ]);
            return redirect()->route('configs.monnaie')->with('success', 'Monnaie modifiée avec succès');
        } catch (Exception $e) {
            return redirect()->route('configs.monnaie')->with('danger', 'Un problème est rencontré');
        }
       
    }

    public function mount()
    {
        $this->monn_lib = $this->monnaie->monn_lib;
        $this->monn_sym = $this->monnaie->monn_sym;
        $this->monn_code = $this->monnaie->monn_code;
        
    }
    public function render()
    {
        return view('livewire.edit-monnaie');
    }
}
