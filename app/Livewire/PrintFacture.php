<?php

namespace App\Livewire;

use App\Models\Unite;
use App\Models\Vente;
use App\Models\Client;
use App\Models\Remise;
use App\Models\Methode;
use App\Models\Monnaie;
use App\Models\Societe;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class PrintFacture extends Component
{
    public $facture;
    public function render()
    {
        $remise=Remise::where('facture_id','=',$this->facture->id)->first();
        $ventes=Vente::where('facture_id','=',$this->facture->id)->get();
        $client=Client::where('id','=',$this->facture->fa_client)->first();
        $paiement=Methode::where('id','=',$this->facture->fa_type_p)->first();
        $monnaie=Monnaie::where('monn_active','=',1)->first();
        $societe = Societe::first();
        if ($societe) {
                $path = $societe->soc_logo ? str_replace('storage/', '', $societe->soc_logo) : null;
                $logoExists = $path && Storage::disk('public')->exists($path);
            }
            else {
                $societe='';
                $logoExists='';
            }
        return view('livewire.print-facture',compact('ventes','client','paiement','societe','monnaie','remise','logoExists'));
    }
}
