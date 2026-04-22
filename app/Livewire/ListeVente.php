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

class ListeVente extends Component
{
    use WithPagination;
    public $search = '';
    public function annuler(Vente $vente)
    {
        //selection id de la facture et la remise en question si elle existe
        $counter=0;
        $remise=Remise::where('facture_id',$vente->facture_id)->first();
        if ($remise) {
            $counter=1;
             //tracing
                 $data="Echec de suppression de vente id ".$vente->id." ";
                 $model="App\Models\Vente";
                 trace($data,$model);
            //retour echec     
            return redirect()->route('ventes.index')->with('danger', "La Vente n'est pas supprimée car elle a la remise numero: ".$remise->id.", cette remise doit être d'abord supprimée ");
        }
        if ($counter==0) {
            //Conteur de ventes
        $count_vente=Vente::where('facture_id',$vente->facture_id)->get();
        //recuperation de la methode de ventee
        $methode_choisie=Methode::where('id',$vente->type_p)->first();
        //id de la methode credit
        $credit=Methode::where('meth_nom','like','credit')->first();
        $credit_id=$credit->id;
        ////////////////////////////////
        $article=Article::where('id',$vente->article_id)->first();
        $srt=Sortstock::where('sor_vente',$vente->id)->first();
        //vérification si la vente par crédit client ou pas?
        if($vente->type_p==$credit_id){
            $quantite=$vente->ve_quantite;
            //client
            $client=Client::where('id',$vente->ve_client)->first();
            $client->cli_situation=$client->cli_situation-$vente->ve_prix_tot;
            //article
            $article->ar_qte+=$quantite;
            //save
            $article->save();
            $client->save();
            //actualiser du solde de la methode de vente
            $methode_choisie->meth_solder-=$vente->ve_prix_tot;
            $methode_choisie->meth_soldev-=$vente->ve_prix_tot;
            $methode_choisie->save();
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
        }
        else{
            //actualiser article courent
            $quantite=$vente->ve_quantite;
            $article->ar_qte+=$quantite;
            $article->save();
            //actualiser du solde de la methode de vente
            $methode_choisie->meth_solder-=$vente->ve_prix_tot;
            $methode_choisie->meth_soldev-=$vente->ve_prix_tot;
            $methode_choisie->save();
            //suppression de l'enregistrement de la table operats
            $operat=Operat::where('operat_vent_id',$vente->id)->first();
            if ($operat) {
                $operat->delete();   
                //tracing
                $data="Suppresion de l'operat id ".$operat->id." ";
                $model="App\Models\Operat";
                trace($data,$model);
            }
            
            //suppression de la vente
            $vente->delete();
             //tracing
             $data="Suppresion de la vente id ".$vente->id." ";
             $model="App\Models\Vente";
             trace($data,$model);    
            }
            //suppression des sorties
            if($srt){
                $srt->delete();
                 //tracing
                $data="Suppresion de la sortie de stock id ".$srt->id." ";
                $model="App\Models\Sortstock";
                trace($data,$model);    
            }
            //actualisation  de la facture
            $facture=Facture::where('id',$vente->facture_id)->first();
            $facture->fa_tot=$facture->fa_tot-$vente->ve_prix_tot;
            $facture->save();
            //suppression de la facture
            if (count($count_vente)==1) {
                $facture->delete();
                 //tracing
                 $data="Suppresion de la facture id ".$facture->id." ";
                 $model="App\Models\Facture";
                 trace($data,$model);    
            }
        return redirect()->route('ventes.index')->with('success', 'Vente supprimée');
        }
                
    }
    public function render()
    {
        if (!empty($this->search)) {
            $ventes = Vente::leftJoin('articles','ventes.article_id','=','articles.id')
                                ->leftJoin('clients','ventes.ve_client','=','clients.id')
                                ->leftJoin('methodes','ventes.type_p','=','methodes.id')
                                ->leftJoin('unites','unites.id','=','articles.ar_unite')
                                ->select('ventes.*', 'clients.cli_nom','clients.cli_societe','methodes.meth_nom','unites.unit_lib')
                                ->where('articles.ar_lib', 'like', '%' . $this->search . '%')
                                ->orWhere('clients.cli_nom', 'like', '%' . $this->search . '%')
                                ->orWhere('clients.cli_societe', 'like', '%' . $this->search . '%')
                                ->orWhere('ventes.ve_quantite', 'like', '%' . $this->search . '%')
                                ->orWhere('ventes.ve_prix_vente', 'like', '%' . $this->search . '%')
                                ->orWhere('ventes.ve_prix_tot', 'like', '%' . $this->search . '%')
                                ->orWhere('ventes.created_at', 'like', '%' . $this->search . '%')
                                ->orWhere('ventes.updated_at', 'like', '%' . $this->search . '%')
                                ->orWhere('methodes.meth_nom', 'like', '%' . $this->search . '%')
                                ->orderByDesc('ventes.updated_at')
                                ->paginate(10);
        }else{
            $ventes = Vente::leftJoin('articles','ventes.article_id','=','articles.id')
                            ->leftJoin('clients','ventes.ve_client','=','clients.id')
                            ->leftJoin('methodes','ventes.type_p','=','methodes.id')
                            ->leftJoin('unites','unites.id','=','articles.ar_unite')
                            ->select('ventes.*', 'clients.cli_nom','clients.cli_societe','methodes.meth_nom','unites.unit_lib')
                            ->orderByDesc('ventes.updated_at')
                            ->paginate(10);
            //dd($ventes);
         
        }
        if ($ventes) {
            // $ventes[0];
            //dd($ventes[0]);
            // $ventes[0]->visit()->withIp()->withSession()->withData(["Hello"=>"Bonjour"])->withUser();
            // foreach ($ventes as $key => $value) {
            //     $value->visit()->withIp()->withSession()->withData(["Hello"=>"Bonjour"])->withUser();
            // }
        }
        return view('livewire.liste-vente',compact('ventes'));
    }
}
