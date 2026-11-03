<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Caisse;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Methode;
use App\Models\Operat;
use App\Models\Remise;
use App\Models\Sortstock;
use App\Models\Vente;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class PointOfSale extends Component
{
    public $caisse;
    
    // Panier du POS
    public $panier = []; 
    
    // Informations de vente
    public $paiement_id = '0';
    public $client_id = '0';
    public $recherche_client = '';
    public $client;
    public $meth_credit = '';
    public $type_paiement;

    // Totaux et Remise
    public $total_vente = 0;
    public $compteur_remise = 0;
    public $remise = 0;
    public $remise2 = 0;
    public $receiveRemise = '1';
    public $mremise = 0;
    public $total_vente_apres_remise = 0;

    public function mount()
    {
        // Vérifier la caisse
        $this->caisse = Caisse::where('user_id', Auth::id())->where('statut', 'ouvert')->first();
        if (!$this->caisse) {
            return redirect()->route('caisse.ouvrir');
        }

        // Initialisation remise
        $this->meth_credit = Methode::where('meth_nom', 'like', '%credit%')->first();
    }

    // ==================== GESTION DU PANIER ====================
    public function addToCart($articleId)
    {
        $article = Article::find($articleId);
        
        if (isset($this->panier[$articleId])) {
            $this->panier[$articleId]['quantite']++;
        } else {
            $this->panier[$articleId] = [
                'id' => $article->id,
                'nom' => $article->ar_lib,
                'prix' => $article->ar_prix_vente,
                'quantite' => 1,
                'unite' => $article->ar_unite,
            ];
        }
        $this->calculerTotaux();
    }

    public function removeFromCart($articleId)
    {
        if (isset($this->panier[$articleId])) {
            if ($this->panier[$articleId]['quantite'] > 1) {
                $this->panier[$articleId]['quantite']--;
            } else {
                unset($this->panier[$articleId]);
            }
        }
        $this->calculerTotaux();
    }

    public function updatedPanier()
    {
        $this->calculerTotaux();
    }

    // ==================== CALCULS ====================
    public function calculerTotaux()
    {
        $this->total_vente = 0;
        foreach ($this->panier as $item) {
            $this->total_vente += $item['prix'] * $item['quantite'];
        }
        $this->calculerRemise();
    }

    public function calculerRemise()
    {
        if ($this->compteur_remise > 0) {
            if ($this->receiveRemise == '1') {
                $remiseValue = str_replace(',', '.', $this->remise);
                $this->remise = round(floatval($remiseValue), 3);
                $this->mremise = $this->total_vente * $this->remise * 0.01;
                $this->remise2 = $this->mremise;
            } else {
                $remise2Value = str_replace(',', '.', $this->remise2);
                $this->remise2 = round(floatval($remise2Value), 3);
                $this->mremise = $this->remise2;
                if ($this->total_vente > 0) {
                    $this->remise = round((100 * $this->mremise) / $this->total_vente, 3);
                }
            }
            $this->total_vente_apres_remise = $this->total_vente - $this->mremise;
        } else {
            $this->mremise = 0;
            $this->total_vente_apres_remise = $this->total_vente;
        }
    }

    public function clickRemise1()
    {
        $this->compteur_remise = 1;
    }

    public function clickRemise2()
    {
        $this->compteur_remise = 0;
        $this->remise = 0;
        $this->remise2 = 0;
    }

    public function updateClientBySearch()
    {
        if (empty($this->recherche_client)) return;

        $client = Client::where('cli_tel', $this->recherche_client)
            ->orWhere('cli_email', $this->recherche_client)
            ->first();

        if ($client) {
            $this->client_id = $client->id;
            $this->client = $client;
        }
    }

    // ==================== VALIDATION ====================
    public function validerVente()
    {
        if (empty($this->panier)) {
            session()->flash('danger', 'Le panier est vide.');
            return;
        }
        if ($this->paiement_id == '0') {
            session()->flash('danger', 'Veuillez sélectionner une méthode de paiement.');
            return;
        }
        if ($this->paiement_id == $this->meth_credit->id && $this->client_id == '0') {
            session()->flash('danger', 'Le client est obligatoire pour une vente à crédit.');
            return;
        }

        try {
            // 1. Créer la facture AVEC l'origine 'resto'
            $facture = Facture::create([
                'fa_num' => 'TEMP', // Sera mis à jour avec l'ID
                'fa_client' => $this->client_id,
                'fa_type_p' => $this->paiement_id,
                'fa_origine' => 'resto', // <-- DISTINCTION ICI
                'fa_tot' => $this->total_vente,
                'fa_t_remise' => $this->remise,
                'fa_m_remise' => $this->mremise,
                'fa_tot_apres_remise' => $this->total_vente_apres_remise,
            ]);
            
            // Mettre à jour le numéro avec l'ID réel
            $facture->update(['fa_num' => $facture->id]);

            foreach ($this->panier as $item) {
                $vnt = Vente::create([
                    'article_id' => $item['id'],
                    've_client' => $this->client_id,
                    've_quantite' => $item['quantite'],
                    've_prix_achat' => Article::find($item['id'])->ar_prix_achat,
                    've_prix_vente' => $item['prix'],
                    've_prix_tot' => $item['prix'] * $item['quantite'],
                    'type_p' => $this->paiement_id,
                    'facture_id' => $facture->id,
                    've_saisi_par' => Auth::id(),
                ]);

                // Gestion du stock
                $article = Article::find($item['id']);
                if ($article->gerer_stock) {
                    $article->decrement('ar_qte', $item['quantite']);
                }

                // Mouvement de stock
                Sortstock::create([
                    'article_id' => $vnt->article_id,
                    'sor_vente' => $vnt->id,
                    'sor_qte' => $vnt->ve_quantite,
                    'sor_prix_achat' => $vnt->ve_prix_achat,
                    'sor_prix_vente' => $vnt->ve_prix_vente,
                    'sor_montant_t_achat' => $vnt->ve_quantite * $vnt->ve_prix_achat,
                    'sor_montant_t_vente' => $vnt->ve_quantite * $vnt->ve_prix_vente,
                    'sor_date' => now(),
                    'sor_motif' => 'vente',
                    'sor_observations' => 'vente resto',
                    'sor_saisi_par' => Auth::id(),
                ]);

                $data = "enregistrement de la vente id " . $vnt->id;
                trace($data, "App\Models\Vente");
            }

            // Mise à jour méthode de paiement
            $methode = Methode::find($this->paiement_id);
            $methode->meth_solder += $this->total_vente_apres_remise;
            $methode->meth_soldev += $this->total_vente_apres_remise;
            $methode->save();

            // Opération
            Operat::create([
                'operat_meth_id' => $this->paiement_id,
                'operat_vent_id' => $vnt->id,
                'operat_tr_id' => 0,
                'operat_montant' => $facture->fa_tot_apres_remise,
            ]);

            // Remise
            if ($this->compteur_remise > 0) {
                $remise = new Remise();
                $remise->facture_id = $facture->id;
                $remise->re_taux_remise = $this->remise;
                $remise->re_montant_facture = $this->total_vente;
                $remise->re_montant_remise = $this->mremise;
                $remise->re_prix_tot_apres_remise = $this->total_vente_apres_remise;
                $remise->save();
            }

            // Client crédit
            if ($this->client_id != 0 && $this->paiement_id == $this->meth_credit->id) {
                $cli = Client::find($this->client_id);
                $cli->cli_situation += $this->total_vente_apres_remise;
                $cli->save();
            }

            // Reset panier
            $this->panier = [];
            $this->total_vente = 0;
            $this->compteur_remise = 0;
            
            session()->flash('success', __('Vente enregistrée avec succès !'));
            
            // On redirige vers la liste des ventes resto
            return redirect()->route('caisse.ventes_resto');

        } catch (Exception $e) {
            session()->flash('danger', __('Un problème est rencontré lors de la vente.'));
            // Optionnel : \Log::error($e->getMessage());
        }
    }

    // Quand on tape dans le champ "Taux de remise %"
    public function updatedRemise()
    {
        $this->calculerRemise();
    }

    // Quand on tape dans le champ "Montant de la remise"
    public function updatedRemise2()
    {
        $this->calculerRemise();
    }

    public function render()
    {
        $categories = \App\Models\Categorie::with(['articles' => function($query) {
            $query->where('gerer_stock', false)->orWhere(function($q) {
                $q->where('gerer_stock', true)->where('ar_qte', '>', 0);
            });
        }])->get();

        $methodesList = Methode::where('meth_active', '1')->get();
        $clientsList = Client::all();

        $this->type_paiement = Methode::find($this->paiement_id);

        return view('livewire.point-of-sale', compact('categories', 'methodesList', 'clientsList'));
    }
}