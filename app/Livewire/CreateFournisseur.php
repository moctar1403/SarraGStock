<?php

namespace App\Livewire;

use App\helpers;
use Livewire\Component;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateFournisseur extends Component
{
    public $four_nom;
    public $four_societe;
    public $four_civilite;
    public $four_tel;
    public $four_adresse="";
    public $four_email="";
    public $four_observations="";
    public function rules()
    {
        $rules = [];       
        $rules["four_nom"] = 'required|string|unique:fournisseurs,four_nom';
        $rules["four_societe"] = 'required|string|unique:fournisseurs,four_societe';
        $rules["four_civilite"] = 'required|min:2';
        $rules["four_tel"] = 'required|numeric|digits:8|unique:fournisseurs,four_tel';
        $rules["four_adresse"] = 'nullable|string';
        $rules["four_email"] = 'nullable|email';
        $rules["four_observations"] = 'string|nullable';
        
        return $rules;
    }
    public function store(Request $request,Fournisseur $fournisseur)
    {
        // $rules = $this->rules; 
        // $rules['name'] = $rules['name'].',id,'.$taxonomy->id;
        // $validator = Validator::make($request->all(), $rules);
        $this->validate();
        // $this->validate([
        //     'four_nom' => 'string|required',
        //     'four_societe' => 'string|required',
        //     'four_civilite' => 'required|min:2',
        //     'four_tel' => 'required|numeric|digits:8|unique:fournisseurs,four_tel',
        //     'four_adresse' => 'string|required',
        //     'four_email' => 'required|email',
        //     'four_observations' => 'string|nullable',
        // ]);
        try {
            $fournisseur->four_nom = $this->four_nom;
            $fournisseur->four_societe = $this->four_societe;
            $fournisseur->four_civilite = $this->four_civilite;
            $fournisseur->four_tel = $this->four_tel;
            $fournisseur->four_adresse = $this->four_adresse;
            $fournisseur->four_email = $this->four_email;
            $fournisseur->four_observations = $this->four_observations;
            $fournisseur->four_saisi_par = Auth::user()->id;;
            $fournisseur->save();
            //trace table
            $data="enregistrement du fournisseur id ".$fournisseur->id." nom ".$fournisseur->four_nom. " ";
            $model="App\Models\Fournisseur";
            trace($data,$model);

            return redirect()->route('fournisseurs.index')->with('success', __('Fournisseur ajouté avec succès'));
        } catch (Exception $e) {
            //Sera pris en compte si on a un problème
            return redirect()->route('fournisseurs.index')->with('danger', 'Un problème est rencontré');
        }
    }

    public function render()
    {
        return view('livewire.create-fournisseur');
    }
}
