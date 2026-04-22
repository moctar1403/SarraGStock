<?php

namespace App\Livewire;

use App\Models\Societe;
use Livewire\Component;
use App\Models\Entrstock;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;


class CreateSociete extends Component
{
    use WithFileUploads;
    public $soc_nom;
    public $soc_adresse;
    public $soc_code_postal;
    public $soc_tel;
    public $soc_email;
    public $soc_nif;
    public $soc_rc;
    public $soc_logo;
    public $soc_observations=" ";
    
    public function store(Societe $societe)
    {
        
        $this->validate([
            'soc_nom' => 'string|required',
            'soc_adresse' => 'string|required',
            'soc_tel' => 'string|required',
            'soc_email' => 'email|nullable',
            'soc_nif' => 'string|nullable',
            'soc_rc' => 'string|nullable',
            'soc_logo' => 'nullable|sometimes|image|max:1024|mimes:jpg,jpeg,png|dimensions:min_width=30,max_width=200,min_height=30,max_height=200',
            'soc_observations' => 'string|nullable',
        ]);
        if ($this->soc_logo) {
            $filePath= $this->soc_logo->store('uploads','public');
        }
        else{
            $filePath= '';
        }
        try {
            $societe->soc_nom = $this->soc_nom;
            $societe->soc_adresse = $this->soc_adresse;
            $societe->soc_tel = $this->soc_tel;
            $societe->soc_email = $this->soc_email ? $this->soc_email : '';
            $societe->soc_code_postal = $this->soc_code_postal ? $this->soc_code_postal  : '';
            $societe->soc_nif = $this->soc_nif ? $this->soc_nif : '';
            $societe->soc_rc = $this->soc_rc ? $this->soc_rc : '';
            $societe->soc_logo = "storage/".$filePath;
            $societe->soc_observations = $this->soc_observations ? $this->soc_observations : '';
            $societe->soc_saisi_par = Auth::user()->id;
            $societe->save();
             //trace
             $data="enregistrement de la societe id ".$societe->id. " ".$societe->soc_nom;
             $model="App\Models\Societe";
             trace($data,$model);
            $this->reset('soc_nom','soc_adresse','soc_tel','soc_email','soc_code_postal','soc_nif','soc_rc','soc_logo','soc_observations');
            //rediriger vers la page des societes
            return redirect()->route('configs.societe')->with('success', 'Informations ajoutée avec succès');
        } catch (Exception $e) {
            return redirect()->route('configs.societe')->with('danger', 'Un problème est rencontré');
        }
    }

    public function render()
    {
        
        return view('livewire.create-societe');
    }
}
