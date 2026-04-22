<?php

namespace App\Livewire;

use App\Models\Vente;
use App\Models\Client;
use App\Models\Operat;
use App\Models\Remise;
use App\Models\Article;
use App\Models\Facture;
use App\Models\Methode;
use Livewire\Component;
use App\Models\Sortstock;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Livewire\Traits\WithDelete;

class ListeFacture extends Component
{
    use WithPagination;
    public $search = '';
    public function print(Facture $facture)
    {
        return redirect()->route('factures.print',$facture);
    }
    public function pdf(Facture $facture)
    {
        return redirect()->route('factures.pdf',$facture);
    }
    public function pdf2(Facture $facture)
    {
        return redirect()->route('factures.pdf',$facture);
    }
    public function detail(Facture $facture)
    {
        return redirect()->route('factures.detail',$facture);
    }
    use WithDelete {
        delete as protected traitDelete;
        // message as protected traitMessage;
    }
    protected function confirmMessage(): string
    {
        return __('Cette facture sera définitivement supprimée. Continuer ?');
    }
    public function delete()
    {
        $facture=Facture::where('id','=',$this->deleteId)->first();
        $remise=Remise::where('facture_id',$facture->id)->first();
        if ($remise) {
            $prix_total=$remise->re_prix_tot_apres_remise;
        }
        else {
            $prix_total=$facture->fa_tot;
        }
        $client=Client::where('id',$facture->fa_client)->first();
        $ventes=Vente::where('facture_id',$facture->id)->get();
        if ($client) {
            $client->cli_situation-=$prix_total;
            $client->save();
        }
        else {
            // dd('le client est vide');
        }
        //suppression des ventes
        //Conteur de ventes
        $count_vente=$ventes->count();
        //recuperation de la methode de ventee et l'actualisation
        $methode_choisie=Methode::where('id',$ventes->first()->type_p)->first();
        $methode_choisie->meth_solder-=$prix_total;
        $methode_choisie->meth_soldev-=$prix_total;
        $methode_choisie->save();
        //fin de l'actualisation me la methode
        foreach ($ventes as $key => $vente) {
                $article=Article::where('id',$vente->article_id)->first();
                $srt=Sortstock::where('sor_vente',$vente->id)->first();
                $quantite=$vente->ve_quantite;
                //article
                $article->ar_qte+=$quantite;
                //save
                $article->save();
                //actualiser du solde de la methode de vente
                //suppression de l'enregistrement de la table operats
                $operat=Operat::where('operat_vent_id',$vente->id)->first();
                if ($operat) {
                    //tracing
                    $data="Suppresion de l'operat id ".$operat->id." ";
                    $model="App\Models\Operat";
                    trace($data,$model);
                    $operat->delete();   
                }
                //suppression de la vente
                $vente->delete(); 
                //tracing
                $data="Suppresion de la vente id ".$vente->id." ";
                $model="App\Models\Vente";
                trace($data,$model);
                //suppression des sorties
                if($srt){
                    $srt->delete();
                    //tracing
                    $data="Suppresion de la sortie de stock id ".$srt->id." ";
                    $model="App\Models\Sortstock";
                    trace($data,$model);    
                }        
        }
        //suppression enregistrement operat de la remise
        if ($remise) {
            // $operat2=Operat::where('operat_re_id',$remise->id)->first();
            //     if ($operat2) {
            //         //tracing
            //         $data="Suppresion de l'operat id ".$operat2->id." ";
            //         $model="App\Models\Operat";
            //         trace($data,$model);
            //         $operat2->delete();   
            //     }   
            //suppression de la remise
            $remise->delete();
            //tracing
            $data="Suppresion de la remise id ".$remise->id." ";
            $model="App\Models\Facture";
            trace($data,$model); 
        }
        //suppression de la facture
        $facture->delete();
        //tracing
        $data="Suppresion de la facture id ".$facture->id." ";
        $model="App\Models\Facture";
        trace($data,$model);    
        return redirect()->route('factures.index')->with('success', __('Facture supprimée'));
    }
    public function render()
    {
        if (!empty($this->search)) {
            // dd('je');
            $factures=Facture::leftJoin('clients','factures.fa_client','=','clients.id')
                                ->leftJoin('methodes','factures.fa_type_p','=','methodes.id')
                                ->select('factures.*','clients.cli_nom','clients.cli_tel','methodes.meth_nom')
                                ->where('clients.cli_nom', 'like', '%' . $this->search . '%')
                                ->orWhere('clients.cli_tel', 'like', '%' . $this->search . '%')
                                ->orWhere('methodes.meth_nom', 'like', '%' . $this->search . '%')
                                ->orderByDesc('factures.updated_at')
                                ->paginate(10);
        }else{
            // $facts = Vente::get();
            // $factures = $facts->unique('facture_id');
            // $factures->values()->all();
            $factures=Facture::leftJoin('clients','factures.fa_client','=','clients.id')
                                ->leftJoin('methodes','factures.fa_type_p','=','methodes.id')
                                ->select('factures.*','clients.cli_nom','clients.cli_tel','methodes.meth_nom')
                                ->orderByDesc('factures.updated_at')
                                ->paginate(10);
                                // dd($factures);                    
        
        }
        return view('livewire.liste-facture',compact('factures'));
    }
}
