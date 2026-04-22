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

class ListeRemise extends Component
{
    use WithPagination;
    public $search = '';
    use WithDelete {
        delete as protected traitDelete;
    }
    protected function confirmMessage(): string
    {
        return __('Cette facture sera définitivement supprimée. Continuer ?');
    }
    public function delete()
    {
        $remise=Remise::where('id','=',$this->deleteId)->first();
        // dd($remise);
        $facture=Facture::where('id','=',$remise->facture_id)->first();
        $client=Client::where('id',$facture->fa_client)->first();
        $ventes=Vente::where('facture_id',$facture->id)->get();
        if ($client) {
            $client->cli_situation-=$remise->re_prix_tot_apres_remise;
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
        $methode_choisie->meth_solder-=$remise->re_prix_tot_apres_remise;
        $methode_choisie->meth_soldev-=$remise->re_prix_tot_apres_remise;
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
        $operat2=Operat::where('operat_re_id',$remise->id)->first();
                if ($operat2) {
                    //tracing
                    $data="Suppresion de l'operat id ".$operat2->id." ";
                    $model="App\Models\Operat";
                    trace($data,$model);
                    $operat2->delete();   
                }   
        //suppression de la remise
        $remise->delete();
        //tracing
        $data="Suppresion de la remise id ".$remise->id." ";
        $model="App\Models\Facture";
        trace($data,$model); 
        //suppression de la facture
        $facture->delete();
        //tracing
        $data="Suppresion de la facture id ".$facture->id." ";
        $model="App\Models\Facture";
        trace($data,$model);    
        return redirect()->route('remises.index')->with('success', 'Remise supprimée');
    }
    public function render()
    {
        if (!empty($this->search)) {
            $remises=Remise::paginate(10);
        }else{
            $remises=Remise::paginate(10);               
        }
        return view('livewire.liste-remise',compact('remises'));
    }
}
