<?php

namespace App\Livewire;

use App\Models\Methode;
use Livewire\Component;

class EditMethode extends Component
{
    public $methode;
    public $meth_nom;
    public $meth_tel;
    public $meth_active;
    public $checkbox=0;
    public function mount()
    {
        $this->meth_nom = $this->methode->meth_nom;
        $this->meth_tel = $this->methode->meth_tel;
        $this->meth_active = $this->methode->meth_active;
        $this->checkbox = $this->methode->meth_active;
    }
    public function rules()
    {
        $rules = [];       
        $rules["meth_nom"] = 'required|string|min:4|unique:methodes,meth_nom,'.$this->methode->id;
        $rules["meth_tel"] = 'required|string|min:8|max:8';
        return $rules;
    }
    public function store(Methode $methode)
    {
        $this->validate();
        $this->methode->update([
            'meth_nom'=>$this->meth_nom,
            'meth_tel'=>$this->meth_tel,
            'meth_active'=>$this->checkbox,
        ]);
        return redirect('methodes')->with('success',__('Méthode de paiement modifiée avec succès'));
    }
    public function render()
    {
        if ($this->meth_active) {
            $this->checkbox=1;
        }
        else {
                $this->checkbox=0;
        }
        return view('livewire.edit-methode');
    }
}
