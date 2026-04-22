<?php

namespace App\Livewire;

use App\Models\Vente;
use App\Models\Client;
use App\Models\Methode;
use App\Models\Societe;
use Livewire\Component;

class DetailVente extends Component
{
    public $vente;
    public function render()
    {
        $ventes=Vente::where('facture_id','=',$this->vente->id)->get();
        $client=Client::where('id','=',$this->vente->fa_client)->first();
        $paiement=Methode::where('id','=',$this->vente->fa_type_p)->first();
        $societe = Societe::first();
        return view('livewire.detail-vente',compact('ventes','client','paiement','societe'));
    }
}
