<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fournisseur;

class EditFournisseur extends Component
{
    public $fournisseur;
    public $four_nom;
    public $four_societe;
    public $four_civilite;
    public $four_tel;
    public $four_adresse;
    public $four_email;
    public $four_observations='';
    public function rules()
    {
        $rules = [];       
        $rules["four_nom"] = 'required|string|unique:fournisseurs,four_nom,'.$this->fournisseur->id;
        $rules["four_societe"] = 'required|string|unique:fournisseurs,four_societe,'.$this->fournisseur->id;
        $rules["four_civilite"] = 'required|min:2';
        $rules["four_tel"] = 'required|numeric|digits:8|unique:fournisseurs,four_tel,'.$this->fournisseur->id;
        $rules["four_adresse"] = 'required|string';
        $rules["four_email"] = 'nullable|email|unique:fournisseurs,four_email,'.$this->fournisseur->id;
        $rules["four_observations"] = 'string|nullable';
        
        return $rules;
    }

    public function mount()
    {
        $this->four_nom = $this->fournisseur->four_nom;
        $this->four_societe = $this->fournisseur->four_societe;
        $this->four_civilite = $this->fournisseur->four_civilite;
        $this->four_tel = $this->fournisseur->four_tel;
        $this->four_adresse = $this->fournisseur->four_adresse;
        $this->four_email = $this->fournisseur->four_email;
        $this->four_observations = $this->fournisseur->four_observations;
    }
    public function store(Fournisseur $fournisseur)
    {
        $this->validate();
        try {
            $this->fournisseur->update([
                'four_nom'=>$this->four_nom,
                'four_societe'=>$this->four_societe,
                'four_civilite'=>$this->four_civilite,
                'four_tel'=>$this->four_tel,
                'four_adresse'=>$this->four_adresse,
                'four_email'=>$this->four_email,
                'four_observations'=>$this->four_observations,
            ]);
        return redirect()->route('fournisseurs.index')->with('success', __('Fournisseur mis à jour avec succès'));
    } catch (Exception $e) {
        //Sera pris en compte si on a un problème
        return redirect()->route('fournisseurs.index')->with('danger', 'Un problème est rencontré');
        }
    }

    public function render()
    {
        return view('livewire.edit-fournisseur');
    }
}
