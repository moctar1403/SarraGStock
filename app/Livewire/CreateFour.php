<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fournisseur;
use Illuminate\Support\Facades\Auth;

class CreateFour extends Component
{
    public $fournisseurs = [
        [
            'four_nom' => '',
            'four_societe' => '',
            'four_civilite' => '',
            'four_tel' => '',
            'four_adresse' => '',
            'four_email' => '',
        ],
    ];
    public function rules()
    {
        $rules = [];

        foreach ($this->fournisseurs as $index => $fournisseur) {
            $rules["fournisseurs.{$index}.four_nom"] = 'required|string';
            $rules["fournisseurs.{$index}.four_societe"] = 'required|string';
            $rules["fournisseurs.{$index}.four_tel"] = 'required|numeric|digits:8';
            $rules["fournisseurs.{$index}.four_adresse"] = 'required|string';
            $rules["fournisseurs.{$index}.four_email"] = 'required|email';
        }

        return $rules;
    }
    public function messages(): array
    {
        return[
            'fournisseurs.*.four_nom.required' => 'nom :position est requis',
            'fournisseurs.*.four_societe.required' => 'societe :position est requis',
            'fournisseurs.*.four_civilite.required' => 'civilite :position est requis',
            'fournisseurs.*.four_tel.required' => 'tel :position est requis',
            'fournisseurs.*.four_tel.numeric' => 'tel :position est numérique',
            'fournisseurs.*.four_tel.digits' => 'tel :position doit être 8 chiffres',
            'fournisseurs.*.four_adresse.required' => 'adresse :position est requis',
            'fournisseurs.*.four_email.required' => 'email :position est requis',
            'fournisseurs.*.four_email.email' => 'email :position non valide',
        ];

    }
    public function store()
    {
        $this->validate();
        $count=count($this->fournisseurs);
        foreach ($this->fournisseurs as $index =>  $fournisseur) {
            try {
                $fr = Fournisseur::create([
                    'four_nom' => $fournisseur['four_nom'],
                    'four_societe' => $fournisseur['four_societe'],
                    'four_civilite' => $fournisseur['four_civilite'],
                    'four_tel' => $fournisseur['four_tel'],
                    'four_adresse' => $fournisseur['four_adresse'],
                    'four_email' => $fournisseur['four_email'],
                    'four_observations' => 'my',
                    'four_saisi_par' => Auth::user()->id,
                ]);
                $fr->save();
            } catch (Exception $e) {
                //Sera pris en compte si on a un problème
            }
        }
        if($count>1)
        return redirect()->route('fournisseurs.index')->with('success', __('Fournisseurs ajoutés avec succès'));
        return redirect()->route('fournisseurs.index')->with('success', __('Fournisseur ajouté avec succès'));
    }
    public function addFournisseur()
    {
        $this->fournisseurs[] = [
            'four_nom' => '',
            'four_societe' => '',
            'four_civilite' => '',
            'four_adresse' => '',
            'four_email' => '',
            'four_observations' => '',
        ];
    }
    public function removeFournisseur($index)
    {
        unset($this->fournisseurs[$index]);
        $this->fournisseurs = array_values($this->fournisseurs);
    }
    public function mount(){

    }
    
    

    public function render()
    {
        return view('livewire.create-four');
    }
}
