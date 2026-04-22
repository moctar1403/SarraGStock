<?php

namespace App\Livewire;

use App\Models\Vente;
use App\Models\Client;
use App\Models\Operat;
use App\Models\Article;
use App\Models\Methode;
use Livewire\Component;
use App\Models\Payement;
use Livewire\WithPagination;
use App\Livewire\Traits\WithDelete;

class ListePaiement extends Component
{
    use WithPagination;
    public $search = '';
    use WithDelete {
        delete as protected traitDelete;
    }
    public function delete()
    {
        $paiement=Payement::where('id','=',$this->deleteId)->first();
        //recuperation du client
        $current_client=Client::where('id','=',$paiement->client_id)->first();
        //actualisation de la situation du client en ajoutant le montant de paiement
        $current_client->cli_situation+=$paiement->pay_montant;
        $current_client->save();
        /////////////////////////////////////////////////////////////////////////////
        //recuperation de la méthode
        $current_methode=Methode::where('id',$paiement->pay_type_p)->first();
        //enlevement du montant de paiement
        //dd($current_methode);
        $current_methode->meth_solder-=$paiement->pay_montant;
        $current_methode->save();
        //actualisation la methode credit
        $credit_methode=Methode::where('meth_nom','like','credit')->first();
        $credit_methode->meth_solder+=$paiement->pay_montant;
        $credit_methode->save();

        //annulation le paiement
        $paiement->delete();
        //actualisation de la table operats
        //recuperer l'enre concerné
        $operats=Operat::where('operat_pa_cli_id','=',$paiement->id)->get();
        foreach ($operats as $key => $value) {
            $value->delete();
        }
        return redirect()->route('paiements.index')->with('success', __('Paiement supprimé'));

        // return redirect()->route('paiements.index')->with('danger', 'paiement n est pas annulé car le stock réel est inférieur ');      
    }
    public function print(Payement $paiement)
    {
        $paiement->delete();
        return redirect()->route('paiements.index')->with('success', 'paiement supprimé');
    }
    public function render()
    {
        if (!empty($this->search)) {
            $paiements = Payement::leftJoin('clients','payements.client_id','=','clients.id')
                                 ->leftJoin('methodes','payements.pay_type_p','=','methodes.id')
                                 ->select('clients.cli_nom', 'payements.*','methodes.meth_nom')
                                ->where('clients.cli_nom', 'like', '%' . $this->search . '%')
                                ->orWhere('payements.pay_montant', 'like', '%' . $this->search . '%')
                                ->orWhere('payements.pay_type_p', 'like', '%' . $this->search . '%')
                                ->orWhere('payements.pay_date', 'like', '%' . $this->search . '%')
                                ->paginate(10);
        }else{
            $paiements = Payement::leftJoin('clients','payements.client_id','=','clients.id')
                                    ->leftJoin('methodes','payements.pay_type_p','=','methodes.id')
                                    ->select('clients.cli_nom', 'payements.*','methodes.meth_nom')
                                    ->orderByDesc('payements.updated_at')
                                    ->paginate(10);
                                 //dd($paiements);
        }
        return view('livewire.liste-paiement',compact('paiements'));
    }
}
