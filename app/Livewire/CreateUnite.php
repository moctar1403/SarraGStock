<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Unite;
use Illuminate\Support\Facades\Auth;

class CreateUnite extends Component
{
    public $unit_lib;
    
    public function rules()
    {
        $rules = [];       
        $rules["unit_lib"] = 'required|string|unique:unites,unit_lib';
        return $rules;
    }
    public function store(Unite $unite)
    {
       
        $this->validate();
        try {
            $unite->unit_lib = $this->unit_lib;
            $unite->save();
            //trace
            $data="enregistrement de l'unite id ".$unite->id. " ".$unite->unit_lib;
            $model="App\Models\Unite";
            trace($data,$model);
            return redirect()->route('unites.index')->with('success', 'Unité ajouté avec succès');
        } catch (Exception $e) {
            //Sera pris en compte si on a un problème
            return redirect()->route('unites.index')->with('danger', 'Un problème est rencontré');
        }
    }

    public function render()
    {
        return view('livewire.create-unite');
    }
}
