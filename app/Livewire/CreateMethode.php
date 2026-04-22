<?php

namespace App\Livewire;

use App\Models\Methode;
use Livewire\Component;
use Illuminate\Http\Request;

class CreateMethode extends Component
{
    public $meth_nom;
    public $meth_tel;
    public $meth_active;
    public $checkbox=0;
    public function rules()
    {
        $rules = [];       
        $rules["meth_nom"] = 'required|string|min:4|unique:methodes,meth_nom';
        $rules["meth_tel"] = 'required|string|min:8|max:8';
        return $rules;
    }
    public function store(Request $request)
    {
        
    //     Request::macro('checkbox', function ($key, $checked = 1, $notChecked = 0) {
    //         return $this->input($key) ? $checked : $notChecked;
    //    });
       $this->validate();
        Methode::create([
            'meth_nom'=>$this->meth_nom,
            'meth_tel'=>$this->meth_tel,
            // 'meth_active'=>$request->checkbox('meth_active', '1', '0'),
            'meth_active'=>$this->checkbox,
        ]);
        return redirect('methodes')->with('success',__('Méthode de paiement créée avec succès'));
    }

    public function render()
    {
        if ($this->meth_active) {
            $this->checkbox=1;
        }
        else {
                $this->checkbox=0;
        }
        return view('livewire.create-methode');
    }
}
