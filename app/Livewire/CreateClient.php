<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class CreateClient extends Component
{ 
    public $cli_nom;
    public $cli_societe;
    public $cli_civilite;
    public $cli_tel;
    public $cli_adresse="";
    public $cli_email="";
    public $cli_observations="";
    public function store(Client $client)
    {
        $this->validate([
            'cli_nom' => 'required|string|unique:clients,cli_nom',
            'cli_societe' => 'required|string|unique:clients,cli_societe',
            'cli_civilite' => 'required|min:2',
            'cli_tel' => 'required|numeric|digits:8|unique:clients,cli_tel',
            'cli_adresse' => 'nullable|string',
            'cli_email' => 'email|nullable',
            // 'cli_email' => 'required|email|unique:clients,cli_email',
            'cli_observations' => 'string|nullable',
        ]);
        try {
            $client->cli_nom = $this->cli_nom;
            $client->cli_societe = $this->cli_societe;
            $client->cli_civilite = $this->cli_civilite;
            $client->cli_tel = $this->cli_tel;
            $client->cli_adresse = $this->cli_adresse;
            $client->cli_email = $this->cli_email;
            $client->cli_observations = $this->cli_observations;
            $client->cli_saisi_par = Auth::user()->id;
            $client->save();
             //trace
             $data="enregistrement du client id ".$client->id." nom ".$client->cli_nom. " ";
             $model="App\Models\Client";
             trace($data,$model);
            return redirect()->route('clients.index')->with('success', __('Client ajouté avec succès'));
        } catch (Exception $e) {
            //Sera pris en compte si on a un problème
            return redirect()->route('clients.index')->with('danger','Il y a un problème');
        }
    }

    public function render()
    {
        return view('livewire.create-client');
    }
}
