<?php

namespace App\Livewire;

use App\Livewire\Traits\WithDelete;
use App\Models\Article;
use App\Models\Caisse;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Methode;
use App\Models\Monnaie;
use App\Models\Operat;
use App\Models\Remise;
use App\Models\Sortstock;
use App\Models\Vente;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ListeVentesResto extends Component
{
    use WithPagination;
    
    use WithDelete {
        delete as protected traitDelete;
    }

    public $search = '';
    public $date_debut;
    public $date_fin;
    public $total_ventes = 0;
    public $monnaie = '';

    public function mount()
    {
        $this->date_debut = Carbon::today()->format('Y-m-d');
        $this->date_fin = Carbon::today()->format('Y-m-d');
    }

    protected function confirmMessage(): string
    {
        return __('Cette vente sera définitivement supprimée et les articles remis en stock. Continuer ?');
    }
        public function delete()
    {
        $facture = Facture::find($this->deleteId);
        
        if (!$facture) {
            return redirect()->route('caisse.ventes_resto')->with('danger', __('Facture introuvable.'));
        }

        // 1. Récupérer la vente pour connaître le caissier
        $premiereVente = Vente::where('facture_id', $facture->id)->first();
        if (!$premiereVente) {
            return redirect()->route('caisse.ventes_resto')->with('danger', __('Aucune vente associée.'));
        }

        // 2. Vérifier si la caisse du caissier est fermée
        // On cherche la caisse qui était ouverte au moment de la vente
        $caisse = Caisse::where('user_id', $premiereVente->ve_saisi_par)
                        ->where('date_ouverture', '<=', $facture->created_at)
                        ->where(function($q) use ($facture) {
                            $q->whereNull('date_cloture')
                              ->orWhere('date_cloture', '>=', $facture->created_at);
                        })
                        ->first();

        if ($caisse && $caisse->statut === 'ferme') {
            return redirect()->route('caisse.ventes_resto')->with('danger', __('Impossible de supprimer une vente d\'une caisse déjà clôturée.'));
        }

        // Si on est ici, la caisse est ouverte ou introuvable (on autorise)
        
        $remise = Remise::where('facture_id', $facture->id)->first();
        $prix_total = $remise ? $remise->re_prix_tot_apres_remise : $facture->fa_tot;
        
        $client = Client::find($facture->fa_client);
        $ventes = Vente::where('facture_id', $facture->id)->get();

        if ($client) {
            $client->cli_situation -= $prix_total;
            $client->save();
        }

        if ($ventes->count() > 0) {
            $methode_choisie = Methode::find($ventes->first()->type_p);
            if ($methode_choisie) {
                $methode_choisie->meth_solder -= $prix_total;
                $methode_choisie->meth_soldev -= $prix_total;
                $methode_choisie->save();
            }
        }

        foreach ($ventes as $vente) {
            $article = Article::find($vente->article_id);
            $srt = Sortstock::where('sor_vente', $vente->id)->first();
            
            if ($article && $article->gerer_stock) {
                $article->ar_qte += $vente->ve_quantite;
                $article->save();
            }

            $operat = Operat::where('operat_vent_id', $vente->id)->first();
            if ($operat) {
                $operat->delete();
            }

            $vente->delete();

            if ($srt) {
                $srt->delete();
            }
        }

        if ($remise) {
            $remise->delete();
        }

        $facture->delete();

        return redirect()->route('caisse.ventes_resto')->with('success', __('Vente supprimée avec succès.'));
    }
    public function delete_old()
    {
        $facture = Facture::find($this->deleteId);
        
        if (!$facture) {
            return redirect()->route('caisse.ventes_resto')->with('danger', __('Facture introuvable.'));
        }

        $remise = Remise::where('facture_id', $facture->id)->first();
        $prix_total = $remise ? $remise->re_prix_tot_apres_remise : $facture->fa_tot;
        
        $client = Client::find($facture->fa_client);
        $ventes = Vente::where('facture_id', $facture->id)->get();

        if ($client) {
            $client->cli_situation -= $prix_total;
            $client->save();
        }

        if ($ventes->count() > 0) {
            $methode_choisie = Methode::find($ventes->first()->type_p);
            if ($methode_choisie) {
                $methode_choisie->meth_solder -= $prix_total;
                $methode_choisie->meth_soldev -= $prix_total;
                $methode_choisie->save();
            }
        }

        foreach ($ventes as $vente) {
            $article = Article::find($vente->article_id);
            $srt = Sortstock::where('sor_vente', $vente->id)->first();
            
            if ($article && $article->gerer_stock) {
                $article->ar_qte += $vente->ve_quantite;
                $article->save();
            }

            $operat = Operat::where('operat_vent_id', $vente->id)->first();
            if ($operat) {
                $operat->delete();
            }

            $vente->delete();

            if ($srt) {
                $srt->delete();
            }
        }

        if ($remise) {
            $remise->delete();
        }

        $facture->delete();

        return redirect()->route('caisse.ventes_resto')->with('success', __('Vente supprimée avec succès.'));
    }

    public function render()
    {
        $monnaieActive = Monnaie::where('monn_active', 1)->first();
        $this->monnaie = $monnaieActive ? $monnaieActive->monn_sym : '';

        $query = Facture::query()
            ->leftJoin('methodes', 'factures.fa_type_p', '=', 'methodes.id')
            ->leftJoin('users', 'users.id', '=', DB::raw('(SELECT ve_saisi_par FROM ventes WHERE ventes.facture_id = factures.id LIMIT 1)'))
            ->select('factures.*', 'methodes.meth_nom', 'users.name as caissier')
            ->where('factures.fa_origine', 'resto') // <-- NOUVEAU FILTRE
            
            ->when($this->search, function ($q) {
                $q->where(function($sub) {
                    $sub->where('factures.fa_num', 'like', '%' . $this->search . '%')
                      ->orWhere('users.name', 'like', '%' . $this->search . '%')
                      ->orWhere('methodes.meth_nom', 'like', '%' . $this->search . '%');
                });
            })

            ->when($this->date_debut, function ($q) {
                $q->whereDate('factures.created_at', '>=', $this->date_debut);
            })
            ->when($this->date_fin, function ($q) {
                $q->whereDate('factures.created_at', '<=', $this->date_fin);
            });

        $this->total_ventes = $query->sum('factures.fa_tot');

        $factures = $query->orderByDesc('factures.created_at')->paginate(10);

        return view('livewire.liste-ventes-resto', compact('factures'));
    }
}