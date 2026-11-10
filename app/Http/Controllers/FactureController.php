<?php

namespace App\Http\Controllers;

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
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class FactureController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view facture', ['only' =>['index']]);
        $this->middleware('permission:facture print', ['only' =>['print','print2']]);
        $this->middleware('permission:facture pdf', ['only' =>['pdf','pdf2']]);
        $this->middleware('permission:facture detail', ['only' =>['detail','detailv']]);
    }

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
                $path = $societe->soc_logo;
                $logoExists = $path && file_exists(public_path($path));
            }
            else {
                $societe=null;
                $logoExists=false;
            }
        $methode=Methode::where('id',$facture->fa_type_p)->first();
        $ventes=Vente::where('facture_id',$facture->id)->get();
        
        $data['fa_num']=$facture->fa_num;
        $data['fa_tot']=$facture->fa_tot;
        $data['fa_t_remise']=$facture->fa_t_remise;
        $data['fa_m_remise']=$facture->fa_m_remise;
        $data['fa_tot_apres_remise']=$facture->fa_tot_apres_remise;
        $data['created_at']=$facture->created_at->format('d/m/Y');
        $data['fa_type_p']=$methode->meth_nom;
        
        if (($cli)) {
            $data['cli_nom']=$cli->cli_nom;
            $data['cli_societe']=$cli->cli_societe;
            $data['cli_civilite']=$cli->cli_civilite;
            $data['cli_tel']=$cli->cli_tel;
            $data['cli_adresse']=$cli->cli_adresse;
            $data['cli_email']=$cli->cli_email;
        } else {
            $data['cli_nom']=''; $data['cli_societe']=''; $data['cli_civilite']='';
            $data['cli_tel']=''; $data['cli_adresse']=''; $data['cli_email']='';
        }
        
        if ($societe) {
            $data['soc_nom']=$societe->soc_nom; $data['soc_adresse']=$societe->soc_adresse;
            $data['soc_code_postal']=$societe->soc_code_postal; $data['soc_tel']=$societe->soc_tel;
            $data['soc_email']=$societe->soc_email; $data['soc_nif']=$societe->soc_nif;
            $data['soc_rc']=$societe->soc_rc; $data['logoExists']=$logoExists;
            $data['soc_logo']=$societe->soc_logo;
        } else {
            $data['soc_nom']=''; $data['soc_adresse']=''; $data['soc_code_postal']='';
            $data['soc_tel']=''; $data['soc_email']=''; $data['soc_nif']='';
            $data['soc_rc']=''; $data['soc_logo']=''; $data['logoExists']='';
        }
        $items=[];
        foreach ($ventes as $key => $value) {
            $items[]=[
                'article_id'=>$value->article_id,
                've_quantite'=>$value->ve_quantite,
                'unite'=>Unite::where('id',$value->article->ar_unite)->first()->unit_lib,
                've_prix_vente'=>$value->ve_prix_vente,
                've_prix_tot'=>$value->ve_prix_tot,
            ];
        }
        $data['items']=$items;
        $pdf = PDF::loadView('factures.pdf', $data);
        return $pdf->stream('Facture '.$facture->fa_num. '.pdf');
    }

    public function pdf2(Facture $facture)
    {
        $cli=Client::where('id',$facture->fa_client)->first();
        $societe = Societe::first();
        $methode=Methode::where('id',$facture->fa_type_p)->first();
        $ventes=Vente::where('facture_id',$facture->id)->get();
        
        $data['fa_num']=$facture->fa_num;
        $data['fa_tot']=$facture->fa_tot;
        $data['fa_t_remise']=$facture->fa_t_remise;
        $data['fa_m_remise']=$facture->fa_m_remise;
        $data['fa_tot_apres_remise']=$facture->fa_tot_apres_remise;
        $data['created_at']=$facture->created_at->format('d/m/Y');
        $data['fa_type_p']=$methode->meth_nom;
        
        if (($cli)) {
            $data['cli_nom']=$cli->cli_nom; $data['cli_societe']=$cli->cli_societe;
            $data['cli_civilite']=$cli->cli_civilite; $data['cli_tel']=$cli->cli_tel;
            $data['cli_adresse']=$cli->cli_adresse; $data['cli_email']=$cli->cli_email;
        } else {
            $data['cli_nom']=''; $data['cli_societe']=''; $data['cli_civilite']='';
            $data['cli_tel']=''; $data['cli_adresse']=''; $data['cli_email']='';
        }
        
        if ($societe) {
            $data['soc_nom']=$societe->soc_nom; $data['soc_adresse']=$societe->soc_adresse;
            $data['soc_code_postal']=$societe->soc_code_postal; $data['soc_tel']=$societe->soc_tel;
            $data['soc_email']=$societe->soc_email; $data['soc_nif']=$societe->soc_nif;
            $data['soc_rc']=$societe->soc_rc; $data['soc_logo']=$societe->soc_logo;
        } else {
            $data['soc_nom']=''; $data['soc_adresse']=''; $data['soc_code_postal']='';
            $data['soc_tel']=''; $data['soc_email']=''; $data['soc_nif']='';
            $data['soc_rc']=''; $data['soc_logo']='';
        }
        $items=[];
        foreach ($ventes as $key => $value) {
            $items[]=[
                'article_id'=>$value->article_id,
                've_quantite'=>$value->ve_quantite,
                'unite'=>Unite::where('id',$value->article->ar_unite)->first()->unit_lib,
                've_prix_vente'=>$value->ve_prix_vente,
                've_prix_tot'=>$value->ve_prix_tot,
            ];
        }
        $data['items']=$items;
        $pdf = PDF::loadView('factures.pdf', $data);
        return $pdf->stream('Facture '.$facture->fa_num. '.pdf');
    }

    public function detail(Facture $facture)
    {
        return view ('factures.detail',compact('facture'));
    }

    public function detailv(Facture $vente)
    {
        return view ('factures.detailv',compact('vente'));
    }

        public function printTicket($id)
    {
        $facture = Facture::findOrFail($id);
        $items = Vente::where('facture_id', $id)->get()->toArray();
        
        $societe = \App\Models\Societe::first();
        $client = \App\Models\Client::find($facture->fa_client);
        $monnaie = \App\Models\Monnaie::where('monn_active', 1)->first();
        
        // NOUVEAU : Récupération du nom du caissier (le premier utilisateur de la vente)
        $caissier = \App\Models\User::find($items[0]['ve_saisi_par'] ?? null);

        $data = [
            'fa_num' => $facture->fa_num,
            'fa_tot' => $facture->fa_tot,
            'fa_t_remise' => $facture->fa_t_remise,
            'fa_m_remise' => $facture->fa_m_remise,
            'fa_tot_apres_remise' => $facture->fa_tot_apres_remise,
            'fa_type_p' => \App\Models\Methode::find($facture->fa_type_p)->meth_nom ?? '',
            'created_at' => $facture->created_at->format('d/m/Y H:i'),
            'items' => $items,
            'soc_nom' => $societe->soc_nom ?? '',
            'soc_adresse' => $societe->soc_adresse ?? '',
            'soc_tel' => $societe->soc_tel ?? '',
            'cli_nom' => $client->cli_nom ?? null,
            'monnaie' => $monnaie->monn_sym ?? '',
            'caissier' => $caissier->name ?? 'N/A', // NOUVEAU
        ];

        $customFormat = [80, 200]; 

        $pdf = PDF::loadView('pdf.ticket', $data, [], [
            'format' => $customFormat,
            'orientation' => 'P',
            'margin_left' => 1, 
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'default_font' => 'DejaVu Sans',
        ]);
          
        return $pdf->stream('ticket-' . $facture->fa_num . '.pdf');
    }
    public function printTicketold($id)
    {
        $facture = Facture::findOrFail($id);
        $items = Vente::where('facture_id', $id)->get()->toArray();
        
        $societe = \App\Models\Societe::first();
        $client = \App\Models\Client::find($facture->fa_client);
        $monnaie = \App\Models\Monnaie::where('monn_active', 1)->first();
        
        $data = [
            'fa_num' => $facture->fa_num,
            'fa_tot' => $facture->fa_tot,
            'fa_t_remise' => $facture->fa_t_remise,
            'fa_m_remise' => $facture->fa_m_remise,
            'fa_tot_apres_remise' => $facture->fa_tot_apres_remise,
            'fa_type_p' => \App\Models\Methode::find($facture->fa_type_p)->meth_nom ?? '',
            'created_at' => $facture->created_at->format('d/m/Y H:i'),
            'items' => $items,
            'soc_nom' => $societe->soc_nom ?? '',
            'soc_adresse' => $societe->soc_adresse ?? '',
            'soc_tel' => $societe->soc_tel ?? '',
            'cli_nom' => $client->cli_nom ?? null,
            'monnaie' => $monnaie->monn_sym ?? '',
        ];

        // On remet à 100mm pour être sûr que le texte tienne sur une seule page
        $customFormat = [48, 100]; 

        $pdf = PDF::loadView('pdf.ticket', $data, [], [
            'format' => $customFormat,
            'orientation' => 'P',
            'margin_left' => 2, 
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'default_font' => 'DejaVu Sans',
        ]);
          
        return $pdf->stream('ticket-' . $facture->fa_num . '.pdf');
    }

    public function printTicketCaisse($id)
    {
        $caisse = \App\Models\Caisse::with('user')->findOrFail($id);
        
        $factureIds = \App\Models\Vente::where('ve_saisi_par', $caisse->user_id)
                        ->where('updated_at', '>=', $caisse->date_ouverture)
                        ->when($caisse->date_cloture, function($q) use ($caisse) {
                            return $q->where('updated_at', '<=', $caisse->date_cloture);
                        }, function($q) {
                            return $q->where('updated_at', '<=', now());
                        })
                        ->pluck('facture_id')->unique()->filter();

        $factures = \App\Models\Facture::whereIn('id', $factureIds)->get();
        $total = $factures->sum('fa_tot_apres_remise');

        $methodes = \App\Models\Methode::where('meth_active', 1)->get();
        $detailsPaiements = [];
        foreach ($methodes as $methode) {
            $montantMethode = $factures->where('fa_type_p', $methode->id)->sum('fa_tot_apres_remise');
            if ($montantMethode > 0) {
                $detailsPaiements[] = [
                    'nom' => $methode->meth_nom,
                    'montant' => $montantMethode
                ];
            }
        }

        $societe = \App\Models\Societe::first();
        $monnaie = \App\Models\Monnaie::where('monn_active', 1)->first();
        
        $data = [
            'caisse_id' => $caisse->id,
            'caissier' => $caisse->user->name ?? 'N/A',
            'date_ouverture' => \Carbon\Carbon::parse($caisse->date_ouverture)->format('d/m/Y H:i'),
            'date_cloture' => $caisse->date_cloture ? \Carbon\Carbon::parse($caisse->date_cloture)->format('d/m/Y H:i') : 'En cours',
            'montant_initial' => $caisse->montant_initial,
            'montant_theorique' => $caisse->montant_theorique ?? 0,
            'ecart' => $caisse->ecart,
            'total_ventes' => $total,
            'nb_factures' => $factures->count(),
            'soc_nom' => $societe->soc_nom ?? '',
            'soc_adresse' => $societe->soc_adresse ?? '',
            'soc_tel' => $societe->soc_tel ?? '',
            'details_paiements' => $detailsPaiements,
            'monnaie' => $monnaie->monn_sym ?? '',
        ];

        $customFormat = [80, 200]; 

        $pdf = PDF::loadView('pdf.ticket_caisse', $data, [], [
            'format' => $customFormat,
            'orientation' => 'P',
            'margin_left' => 1, 
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'default_font' => 'DejaVu Sans',
        ]);

        return $pdf->stream('ticket-caisse-' . $caisse->id . '.pdf');
    }
    public function printTicketCaisseold($id)
    {
        $caisse = \App\Models\Caisse::with('user')->findOrFail($id);
        
        $factureIds = \App\Models\Vente::where('ve_saisi_par', $caisse->user_id)
                        ->where('updated_at', '>=', $caisse->date_ouverture)
                        ->when($caisse->date_cloture, function($q) use ($caisse) {
                            return $q->where('updated_at', '<=', $caisse->date_cloture);
                        }, function($q) {
                            return $q->where('updated_at', '<=', now());
                        })
                        ->pluck('facture_id')->unique()->filter();

        $factures = \App\Models\Facture::whereIn('id', $factureIds)->get();
        $total = $factures->sum('fa_tot_apres_remise');

        $methodes = \App\Models\Methode::where('meth_active', 1)->get();
        $detailsPaiements = [];
        foreach ($methodes as $methode) {
            $montantMethode = $factures->where('fa_type_p', $methode->id)->sum('fa_tot_apres_remise');
            if ($montantMethode > 0) {
                $detailsPaiements[] = [
                    'nom' => $methode->meth_nom,
                    'montant' => $montantMethode
                ];
            }
        }

        $societe = \App\Models\Societe::first();
        $monnaie = \App\Models\Monnaie::where('monn_active', 1)->first();
        
        $data = [
            'caisse_id' => $caisse->id,
            'caissier' => $caisse->user->name ?? 'N/A',
            'date_ouverture' => \Carbon\Carbon::parse($caisse->date_ouverture)->format('d/m/Y H:i'),
            'date_cloture' => $caisse->date_cloture ? \Carbon\Carbon::parse($caisse->date_cloture)->format('d/m/Y H:i') : 'En cours',
            'montant_initial' => $caisse->montant_initial,
            'montant_theorique' => $caisse->montant_theorique ?? 0,
            'ecart' => $caisse->ecart,
            'total_ventes' => $total,
            'nb_factures' => $factures->count(),
            'soc_nom' => $societe->soc_nom ?? '',
            'soc_adresse' => $societe->soc_adresse ?? '',
            'soc_tel' => $societe->soc_tel ?? '',
            'details_paiements' => $detailsPaiements,
            'monnaie' => $monnaie->monn_sym ?? '',
        ];

        $customFormat = [48, 100]; 

        $pdf = PDF::loadView('pdf.ticket_caisse', $data, [], [
            'format' => $customFormat,
            'orientation' => 'P',
            'margin_left' => 2, 
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'default_font' => 'DejaVu Sans',
        ]);

        return $pdf->stream('ticket-caisse-' . $caisse->id . '.pdf');
    }
}