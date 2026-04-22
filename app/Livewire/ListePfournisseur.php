<?php

namespace App\Livewire;

use App\Models\Vente;
use App\Models\Operat;
use App\Models\Article;
use App\Models\Methode;
use Livewire\Component;
use App\Models\Fournisseur;
use Livewire\WithPagination;
use App\Models\Payfournisseur;
use App\Livewire\Traits\WithDelete;

class ListePfournisseur extends Component
{
    use WithPagination;
    public $search = '';
    use WithDelete {
        delete as protected traitDelete;
    }
    public function delete()
    {
        $paiement=Payfournisseur::where('id','=',$this->deleteId)->first();
        $montant_total=$paiement->fpay_montant+$paiement->fpay_frais;
        //recuperation du client
        $current_fournisseur=Fournisseur::where('id','=',$paiement->fournisseur_id)->first();
        //actualisation de la situation du client en ajoutant le montant de paiement fournisseur
        $current_fournisseur->four_situation+=$paiement->fpay_montant;
        $current_fournisseur->save();
        /////////////////////////////////////////////////////////////////////////////
        //recuperation de la méthode
        $current_methode=Methode::where('id',$paiement->fpay_type_p)->first();
        //enlevement du montant de paiement fournisseur
        //dd($current_methode);
        $current_methode->meth_solder+=$montant_total;
        $current_methode->save();
        //actualisation la methode credit
        // $credit_methode=Methode::where('meth_nom','like','credit')->first();
        // $credit_methode->meth_solder+=$paiement->fpay_montant;
        // $credit_methode->save();

        //annulation le paiement fournisseur
        $paiement->delete();
        //actualisation de la table operats
        //recuperer l'enre concerné
        $operats=Operat::where('operat_pa_four_id','=',$paiement->id)->get();
        foreach ($operats as $key => $value) {
            $value->delete();
        }
        return redirect()->route('fournisseurs.pindex')->with('success', __('Paiement supprimé'));

        // return redirect()->route('paiements.index')->with('danger', 'paiement fournisseur n est pas annulé car le stock réel est inférieur ');      
    }
    // public function print(Payfournisseur $paiement)
    // {
    //     $paiement->delete();
    //     return redirect()->route('paiements.index')->with('success', 'paiement fournisseur supprimé');
    // }
    public function render()
    {
        if (!empty($this->search)) {
            $paiements = Payfournisseur::leftJoin('fournisseurs','payfournisseurs.fournisseur_id','=','fournisseurs.id')
                                 ->leftJoin('methodes','payfournisseurs.fpay_type_p','=','methodes.id')
                                 ->select('fournisseurs.four_nom', 'payfournisseurs.*','methodes.meth_nom')
                                ->where('fournisseurs.four_nom', 'like', '%' . $this->search . '%')
                                ->orWhere('payfournisseurs.fpay_montant', 'like', '%' . $this->search . '%')
                                ->orWhere('payfournisseurs.fpay_type_p', 'like', '%' . $this->search . '%')
                                ->orWhere('payfournisseurs.fpay_date', 'like', '%' . $this->search . '%')
                                ->paginate(10);
        }else{
            $paiements = Payfournisseur::leftJoin('fournisseurs','payfournisseurs.fournisseur_id','=','fournisseurs.id')
                                    ->leftJoin('methodes','payfournisseurs.fpay_type_p','=','methodes.id')
                                    ->select('fournisseurs.four_nom', 'payfournisseurs.*','methodes.meth_nom')
                                    ->orderByDesc('payfournisseurs.updated_at')
                                    ->paginate(10);
                                 //dd($paiements);
        }
        return view('livewire.liste-pfournisseur',compact('paiements'));
    }
}
