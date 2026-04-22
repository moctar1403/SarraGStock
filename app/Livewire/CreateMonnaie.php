<?php

namespace App\Livewire;

use App\Models\Monnaie;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreateMonnaie extends Component
{
    public $monn_lib;
    public $monn_sym;
    public $monn_code;
    public function store(Monnaie $monnaie)
    {
        $this->validate([
            'monn_lib' => 'required|string|unique:monnaies,monn_lib|min:3',
            'monn_sym' => 'required|string',
            'monn_code' => 'required|string|unique:monnaies,monn_code',
        ]);
        try {
            $monnaie->monn_lib = $this->monn_lib;
            $monnaie->monn_sym = $this->monn_sym;
            $monnaie->monn_code = $this->monn_code;
            $monnaie->monn_saisi_par = Auth::user()->id;;
            $monnaie->save();
             //trace
             $data="enregistrement de la monnaie id ".$monnaie->id. " ";
             $model="App\Models\Monnaie";
             trace($data,$model);
            return redirect()->route('configs.monnaie')->with('success', __('Monnaie ajoutée avec succès'));
        } catch (Exception $e) {
            //Sera pris en compte si on a un problème
            return redirect()->route('configs.monnaie')->with('danger', 'Un problème est rencontré');
        }
    }
    public function render()
    {
        return view('livewire.create-monnaie');
    }
}
