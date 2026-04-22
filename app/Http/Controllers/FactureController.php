<?php

namespace App\Http\Controllers;

use PDF;
use App\helpers;
use App\Models\Unite;
use App\Models\Vente;
use App\Models\Client;
use App\Models\Remise;
use App\Models\Facture;
use App\Models\Methode;
use App\Models\Monnaie;
use App\Models\Societe;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view facture', ['only' =>['index']]);
        $this->middleware('permission:facture print', ['only' =>['print','print2']]);
        $this->middleware('permission:facture pdf', ['only' =>['pdf','pdf2']]);
        $this->middleware('permission:facture detail', ['only' =>['detail','detailv']]);
        // $this->middleware('permission:update societe', ['only'=> ['update','edit']]);
        // $this->middleware('permission:delete societe', ['only' =>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('factures.index');
    }
    public function print(Facture $facture)
    {
        $remise=Remise::where('facture_id','=',$facture->id)->first();
        $ventes=Vente::where('facture_id','=',$facture->id)->get();
        $client=Client::where('id','=',$facture->fa_client)->first();
        $paiement=Methode::where('id','=',$facture->fa_type_p)->first();
        $monnaie=Monnaie::where('monn_active','=',1)->first();
        $societe = Societe::first();
        if ($societe) {
                // $path = $societe->soc_logo ? str_replace('storage/', '', $societe->soc_logo) : null;
                // $logoExists = $path && Storage::disk('public')->exists($path);
                // $path = $societe->soc_logo ? str_replace('storage/', '', $societe->soc_logo) : null;
                // $logoExists = $path && Storage::disk('public')->exists($path);
                $path = $societe->soc_logo;
                $logoExists = $path && file_exists(public_path($path));
            }
            else {
                $societe=null;
                $logoExists=false;
            }
        return view ('factures.print',compact('facture','remise','ventes','client','paiement','monnaie','societe', 'logoExists'));
    }
    public function print2(Facture $facture)
    {
        return view ('factures.print',compact('facture'));
    }
    public function pdf(Facture $facture)
    {
        $cli=Client::where('id',$facture->fa_client)->first();
        $societe = Societe::first();
        if ($societe) {
                // $path = $societe->soc_logo ? str_replace('storage/', '', $societe->soc_logo) : null;
                $path = $societe->soc_logo;
                // $logoExists = $path && Storage::disk('public')->exists($path);
                $logoExists = $path && file_exists(public_path($path));
            }
            else {
                $societe=null;
                $logoExists=false;
            }
        $methode=Methode::where('id',$facture->fa_type_p)->first();
        $ventes=Vente::where('facture_id',$facture->id)->get();
        //dd($methode);
        $data['fa_num']=$facture->fa_num;
        $data['fa_tot']=$facture->fa_tot;
        $data['fa_t_remise']=$facture->fa_t_remise;
        $data['fa_m_remise']=$facture->fa_m_remise;
        $data['fa_tot_apres_remise']=$facture->fa_tot_apres_remise;
        $data['created_at']=$facture->created_at->format('d/m/Y');
        $data['fa_type_p']=$methode->meth_nom;
        //client 
        if (($cli)) {
            $data['cli_nom']=$cli->cli_nom;
            $data['cli_societe']=$cli->cli_societe;
            $data['cli_civilite']=$cli->cli_civilite;
            $data['cli_tel']=$cli->cli_tel;
            $data['cli_adresse']=$cli->cli_adresse;
            $data['cli_email']=$cli->cli_email;
        }
        else {
            $data['cli_nom']='';
            $data['cli_societe']='';
            $data['cli_civilite']='';
            $data['cli_tel']='';
            $data['cli_adresse']='';
            $data['cli_email']='';
        }
        
        //societe
        if ($societe) {
            $data['soc_nom']=$societe->soc_nom;
            $data['soc_adresse']=$societe->soc_adresse;
            $data['soc_code_postal']=$societe->soc_code_postal;
            $data['soc_tel']=$societe->soc_tel;
            $data['soc_email']=$societe->soc_email;
            $data['soc_nif']=$societe->soc_nif;
            $data['soc_rc']=$societe->soc_rc;
            $data['logoExists']=$logoExists;
            $data['soc_logo']=$societe->soc_logo;
        }
        else {
            $data['soc_nom']='';
            $data['soc_adresse']='';
            $data['soc_code_postal']='';
            $data['soc_tel']='';
            $data['soc_email']='';
            $data['soc_nif']='';
            $data['soc_rc']='';
            $data['soc_logo']='';
            $data['logoExists']='';
        }
        $items=[];
        foreach ($ventes as $key => $value) {
            // $article=Article::
            $items[]=[
                'article_id'=>$value->article_id,
                // 'article_id'=>$value->article->ar_lib,
                've_quantite'=>$value->ve_quantite,
                'unite'=>Unite::where('id',$value->article->ar_unite)->first()->unit_lib,
                've_prix_vente'=>$value->ve_prix_vente,
                've_prix_tot'=>$value->ve_prix_tot,
            ];
        }
        $data['items']=$items;
        $pdf = PDF::loadView('factures.pdf', $data);
        return $pdf->stream('Facture '.$facture->fa_num. '.pdf');
        //return view ('factures.pdf',compact('facture'));
    }
    public function pdf2(Facture $facture)
    {
        $cli=Client::where('id',$facture->fa_client)->first();
        $societe = Societe::first();
        $methode=Methode::where('id',$facture->fa_type_p)->first();
        $ventes=Vente::where('facture_id',$facture->id)->get();
        //dd($methode);
        $data['fa_num']=$facture->fa_num;
        $data['fa_tot']=$facture->fa_tot;
        $data['fa_t_remise']=$facture->fa_t_remise;
        $data['fa_m_remise']=$facture->fa_m_remise;
        $data['fa_tot_apres_remise']=$facture->fa_tot_apres_remise;
        $data['created_at']=$facture->created_at->format('d/m/Y');
        $data['fa_type_p']=$methode->meth_nom;
        //client 
        if (($cli)) {
            $data['cli_nom']=$cli->cli_nom;
            $data['cli_societe']=$cli->cli_societe;
            $data['cli_civilite']=$cli->cli_civilite;
            $data['cli_tel']=$cli->cli_tel;
            $data['cli_adresse']=$cli->cli_adresse;
            $data['cli_email']=$cli->cli_email;
        }
        else {
            $data['cli_nom']='';
            $data['cli_societe']='';
            $data['cli_civilite']='';
            $data['cli_tel']='';
            $data['cli_adresse']='';
            $data['cli_email']='';
        }
        
        //societe
        if ($societe) {
            $data['soc_nom']=$societe->soc_nom;
            $data['soc_adresse']=$societe->soc_adresse;
            $data['soc_code_postal']=$societe->soc_code_postal;
            $data['soc_tel']=$societe->soc_tel;
            $data['soc_email']=$societe->soc_email;
            $data['soc_nif']=$societe->soc_nif;
            $data['soc_rc']=$societe->soc_rc;
            $data['soc_logo']=$societe->soc_logo;
        }
        else {
            $data['soc_nom']='';
            $data['soc_adresse']='';
            $data['soc_code_postal']='';
            $data['soc_tel']='';
            $data['soc_email']='';
            $data['soc_nif']='';
            $data['soc_rc']='';
            $data['soc_logo']='';
        }
        $items=[];
        foreach ($ventes as $key => $value) {
            // $article=Article::
            $items[]=[
                'article_id'=>$value->article_id,
                // 'article_id'=>$value->article->ar_lib,
                've_quantite'=>$value->ve_quantite,
                'unite'=>Unite::where('id',$value->article->ar_unite)->first()->unit_lib,
                've_prix_vente'=>$value->ve_prix_vente,
                've_prix_tot'=>$value->ve_prix_tot,
            ];
        }
        $data['items']=$items;
        $pdf = PDF::loadView('factures.pdf', $data);
        return $pdf->stream('Facture '.$facture->fa_num. '.pdf');
        //return view ('factures.pdf',compact('facture'));
    }
    public function detail(Facture $facture)
    {
        return view ('factures.detail',compact('facture'));
    }
    public function detailv(Facture $vente)
    {
        return view ('factures.detailv',compact('vente'));
    }
}
