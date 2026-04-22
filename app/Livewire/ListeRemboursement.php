<?php

namespace App\Livewire;

use App\Models\Vente;
use App\Models\Client;
use App\Models\Article;
use App\Models\Methode;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Remboursement;

class ListeRemboursement extends Component
{
    use WithPagination;
    public $search = '';
    public function delete(Remboursement $remboursement)
    {
        $remboursement->delete();
        return redirect()->route('remboursements.index')->with('success', 'remboursement supprimée');
    }
    public function annuler(Remboursement $remboursement)
    {
        //recuperation du client
        $current_client=Client::where('id','=',$remboursement->client_id)->first();
        //actualisation de la situation du client en enlevant le montant de remboursement
        $current_client->cli_situation+=$remboursement->rem_montant;
        $current_client->save();
        /////////////////////////////////////////////////////////////////////////////
        //recuperation de la méthode
        $current_methode=Methode::where('id',$remboursement->rem_type_p)->first();
        //recuperer le montant de remboursement
        //dd($current_methode);
        $current_methode->meth_solde+=$remboursement->pay_montant;
        $current_methode->save();
        //annulation le remboursement
        $remboursement->delete();
        //annuler une remboursement
        
        return redirect()->route('remboursements.index')->with('success', 'remboursement annulé');

        return redirect()->route('remboursements.index')->with('danger', 'remboursement n est pas annulé car le stock réel est inférieur ');
       
        
    }
    public function print(Remboursement $remboursement)
    {
        $remboursement->delete();
        return redirect()->route('remboursements.index')->with('success', 'remboursement supprimée');
    }
    public function render()
    {
        if (!empty($this->search)) {
            $remboursements = Remboursement::leftJoin('clients','remboursements.client_id','=','clients.id')
                                            ->leftJoin('methodes','remboursements.rem_type_p','=','methodes.id')
                                            ->select('clients.cli_nom', 'remboursements.*','methodes.meth_nom')
                                            ->where('clients.cli_nom', 'like', '%' . $this->search . '%')
                                            ->orWhere('remboursements.rem_montant', 'like', '%' . $this->search . '%')
                                            ->orWhere('remboursements.rem_type', 'like', '%' . $this->search . '%')
                                            ->orWhere('remboursements.rem_date', 'like', '%' . $this->search . '%')
                                            ->paginate(10);
        }else{
            $remboursements = Remboursement::leftJoin('clients','remboursements.client_id','=','clients.id')
                                            ->leftJoin('methodes','remboursements.rem_type_p','=','methodes.id')         
                                            ->select('clients.cli_nom', 'remboursements.*','methodes.meth_nom')
                                            ->orderByDesc('remboursements.updated_at')
                                            ->paginate(10);
                                 //dd($remboursements);
        }
        return view('livewire.liste-remboursement',compact('remboursements'));
    }
}
