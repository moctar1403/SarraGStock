<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;

class EditClient extends Component
{
    public $client;
    public $cli_nom;
    public $cli_societe;
    public $cli_civilite;
    public $cli_tel;
    public $cli_adresse;
    public $cli_email;
    public $cli_observations="";
    public $cli_saisi_par;
    public function mount()
    {
        $this->cli_nom = $this->client->cli_nom;
        $this->cli_societe = $this->client->cli_societe;
        $this->cli_civilite = $this->client->cli_civilite;
        $this->cli_tel = $this->client->cli_tel;
        $this->cli_adresse = $this->client->cli_adresse;
        $this->cli_email = $this->client->cli_email;
        $this->cli_observations = $this->client->cli_observations;
    }
    public function store(Client $client)
    {
        // dd($this->client->id);
        // $client=Client::find($this->client->id);
        $this->validate([
            'cli_nom' => 'string|required|unique:clients,cli_nom,'.$this->client->id,
            'cli_societe' => 'string|required|unique:clients,cli_societe,'.$this->client->id,
            'cli_civilite' => 'string|required',
            'cli_tel' => 'required|numeric|digits:8|unique:clients,cli_tel,'.$this->client->id,
            'cli_adresse' => 'nullable|string',
            'cli_email' => 'nullable|email|unique:clients,cli_email,'.$this->client->id,
            'cli_observations' => 'string|nullable',
        ]);
        try {
            $this->client->update([
                'cli_nom'=>$this->cli_nom,
                'cli_societe'=>$this->cli_societe,
                'cli_civilite'=>$this->cli_civilite,
                'cli_tel'=>$this->cli_tel,
                'cli_adresse'=>$this->cli_adresse,
                'cli_email'=>$this->cli_email,
                'cli_observations'=>$this->cli_observations,
            ]);
        return redirect()->route('clients.index')->with('success', __('Client mis à jour avec succès'));
    } catch (Exception $e) {
        //Sera pris en compte si on a un problème
        return redirect()->route('clients.index')->with('danger', 'Un problème est rencontré');
        }
    }

    public function render()
    {
        return view('livewire.edit-client');
    }
}
