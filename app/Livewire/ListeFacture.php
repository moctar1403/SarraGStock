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
        
        $count_vente=$ventes->count();
        
        $methode_choisie=Methode::where('id',$ventes->first()->type_p)->first();
        $methode_choisie->meth_solder-=$prix_total;
        $methode_choisie->meth_soldev-=$prix_total;
        $methode_choisie->save();
        
        foreach ($ventes as $key => $vente) {
                $article=Article::where('id',$vente->article_id)->first();
                $srt=Sortstock::where('sor_vente',$vente->id)->first();
                $quantite=$vente->ve_quantite;
                $article->ar_qte+=$quantite;
                $article->save();
                
                $operat=Operat::where('operat_vent_id',$vente->id)->first();
                if ($operat) {
                    $data="Suppresion de l'operat id ".$operat->id." ";
                    $model="App\Models\Operat";
                    trace($data,$model);
                    $operat->delete();   
                }
                $vente->delete(); 
                $data="Suppresion de la vente id ".$vente->id." ";
                $model="App\Models\Vente";
                trace($data,$model);
                if($srt){
                    $srt->delete();
                    $data="Suppresion de la sortie de stock id ".$srt->id." ";
                    $model="App\Models\Sortstock";
                    trace($data,$model);    
                }        
        }
        if ($remise) {
            $remise->delete();
            $data="Suppresion de la remise id ".$remise->id." ";
            $model="App\Models\Facture";
            trace($data,$model); 
        }
        $facture->delete();
        $data="Suppresion de la facture id ".$facture->id." ";
        $model="App\Models\Facture";
        trace($data,$model);    
        return redirect()->route('factures.index')->with('success', __('Facture supprimée'));
    }
    public function render()
    {
        if (!empty($this->search)) {
            $factures=Facture::leftJoin('clients','factures.fa_client','=','clients.id')
                                ->leftJoin('methodes','factures.fa_type_p','=','methodes.id')
                                ->select('factures.*','clients.cli_nom','clients.cli_tel','methodes.meth_nom')
                                ->where('factures.fa_origine', 'classique') // <-- NOUVEAU
                                ->where(function($query) {
                                    $query->where('clients.cli_nom', 'like', '%' . $this->search . '%')
                                          ->orWhere('clients.cli_tel', 'like', '%' . $this->search . '%')
                                          ->orWhere('methodes.meth_nom', 'like', '%' . $this->search . '%');
                                })
                                ->orderByDesc('factures.updated_at')
                                ->paginate(10);
        }else{
            $factures=Facture::leftJoin('clients','factures.fa_client','=','clients.id')
                                ->leftJoin('methodes','factures.fa_type_p','=','methodes.id')
                                ->select('factures.*','clients.cli_nom','clients.cli_tel','methodes.meth_nom')
                                ->where('factures.fa_origine', 'classique') // <-- NOUVEAU
                                ->orderByDesc('factures.updated_at')
                                ->paginate(10);
        }
        return view('livewire.liste-facture',compact('factures'));
    }
}