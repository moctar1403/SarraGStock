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
    public $panier = []; 
    public $type_vente = 'resto'; 
    public $code_barre = ''; 

    public $paiement_id = '0';
    public $client_id = '0';
    public $client;
    public $meth_credit = '';
    public $type_paiement;

    // NOUVEAU : Pour la recherche rapide du client
    public $recherche_client = '';

    public $total_vente = 0;
    public $compteur_remise = 0;
    public $remise = 0;
    public $remise2 = 0;
    public $receiveRemise = '1';
    public $mremise = 0;
    public $total_vente_apres_remise = 0;

    public function mount()
    {
        $this->caisse = Caisse::where('user_id', Auth::id())->where('statut', 'ouvert')->first();
        if (!$this->caisse) {
            return redirect()->route('caisse.ouvrir');
        }
        $this->meth_credit = Methode::where('meth_nom', 'like', '%credit%')->first();
    }

    // NOUVEAU : Recherche du client
    public function updateClientBySearch()
    {
        if (empty($this->recherche_client)) {
            return;
        }

        $client = Client::where('cli_tel', $this->recherche_client)
            ->orWhere('cli_email', $this->recherche_client)
            ->first();

        if ($client) {
            $this->client_id = $client->id;
            $this->client = $client;
        } else {
            $this->client_id = '0';
            $this->client = null;
        }
    }

    // NOUVEAU : Déclenché quand on tape dans le champ de recherche
    public function updatedRechercheClient()
    {
        $this->updateClientBySearch();
    }

    // ... Le reste de vos méthodes (searchArticleByCode, addToCart, etc.) reste inchangé ...

    public function searchArticleByCode()
    {
        if (empty($this->code_barre)) {
            return;
        }

        $article = Article::where('ar_codebarre', $this->code_barre)
            ->orWhere('ar_reference', $this->code_barre)
            ->orWhere('id', $this->code_barre)
            ->first();

        if ($article) {
            if ($this->type_vente === 'resto' && $article->gerer_stock) {
                session()->flash('danger', __('Cet article est un article de stock, changez de mode.'));
                return;
            }
            if ($this->type_vente === 'stock' && !$article->gerer_stock) {
                session()->flash('danger', __('Cet article est un plat, changez de mode.'));
                return;
            }

            $this->addToCart($article->id);
            $this->code_barre = '';
        } else {
            session()->flash('danger', __('Article introuvable.'));
            $this->code_barre = '';
        }
    }

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

    public function clickRemise1() { $this->compteur_remise = 1; }
    public function clickRemise2() { $this->compteur_remise = 0; $this->remise = 0; $this->remise2 = 0; }
    
    public function updatedRemise() { $this->calculerRemise(); }
    public function updatedRemise2() { $this->calculerRemise(); }

    public function validerVente()
    {
        if (empty($this->panier)) {
            session()->flash('danger', __('Le panier est vide.'));
            return;
        }
        if ($this->paiement_id == '0') {
            session()->flash('danger', __('Veuillez sélectionner une méthode de paiement.'));
            return;
        }
        if ($this->paiement_id == $this->meth_credit->id && $this->client_id == '0') {
            session()->flash('danger', __('Le client est obligatoire pour une vente à crédit.'));
            return;
        }

        try {
            $hasResto = false;
            $hasStock = false;

            foreach ($this->panier as $item) {
                $article = Article::find($item['id']);
                if ($article->gerer_stock) {
                    $hasStock = true;
                } else {
                    $hasResto = true;
                }
            }

            if ($hasResto && $hasStock) {
                $origine = 'mixte';
            } elseif ($hasStock) {
                $origine = 'classique';
            } else {
                $origine = 'resto';
            }

            $facture = Facture::create([
                'fa_num' => 'TEMP',
                'fa_client' => $this->client_id,
                'fa_type_p' => $this->paiement_id,
                'fa_origine' => $origine,
                'fa_tot' => $this->total_vente,
                'fa_t_remise' => $this->remise,
                'fa_m_remise' => $this->mremise,
                'fa_tot_apres_remise' => $this->total_vente_apres_remise,
            ]);
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

                $article = Article::find($item['id']);
                if ($article->gerer_stock) {
                    $article->decrement('ar_qte', $item['quantite']);
                }

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
                    'sor_observations' => 'vente ' . $origine,
                    'sor_saisi_par' => Auth::id(),
                ]);
            }

            $methode = Methode::find($this->paiement_id);
            $methode->meth_solder += $this->total_vente_apres_remise;
            $methode->meth_soldev += $this->total_vente_apres_remise;
            $methode->save();

            Operat::create([
                'operat_meth_id' => $this->paiement_id,
                'operat_vent_id' => $vnt->id,
                'operat_tr_id' => 0,
                'operat_montant' => $facture->fa_tot_apres_remise,
            ]);

            if ($this->compteur_remise > 0) {
                $remise = new Remise();
                $remise->facture_id = $facture->id;
                $remise->re_taux_remise = $this->remise;
                $remise->re_montant_facture = $this->total_vente;
                $remise->re_montant_remise = $this->mremise;
                $remise->re_prix_tot_apres_remise = $this->total_vente_apres_remise;
                $remise->save();
            }

            if ($this->client_id != 0 && $this->paiement_id == $this->meth_credit->id) {
                $cli = Client::find($this->client_id);
                $cli->cli_situation += $this->total_vente_apres_remise;
                $cli->save();
            }

            $this->panier = [];
            $this->total_vente = 0;
            $this->compteur_remise = 0;
            $this->recherche_client = ''; // On réinitialise le champ de recherche
            
            session()->flash('success', __('Vente enregistrée avec succès !'));
            
            if ($origine === 'resto' || $origine === 'mixte') {
                return redirect()->route('caisse.ventes_resto');
            } else {
                return redirect()->route('factures.index'); 
            }

        } catch (Exception $e) {
            session()->flash('danger', __('Un problème est rencontré lors de la vente.'));
        }
    }

    public function render()
    {
        if ($this->type_vente === 'resto') {
            $query = Article::where('gerer_stock', false);
        } else {
            $query = Article::where('gerer_stock', true)->where('ar_qte', '>', 0);
        }

        if (!empty($this->code_barre)) {
            $articles = $query->where(function($q) {
                $q->where('ar_codebarre', 'like', '%' . $this->code_barre . '%')
                  ->orWhere('ar_reference', 'like', '%' . $this->code_barre . '%')
                  ->orWhere('id', 'like', '%' . $this->code_barre . '%');
            })->get();

            $categories = collect();
            if ($articles->count() > 0) {
                $catRecherche = new \App\Models\Categorie(['nom' => __('Résultat de recherche')]);
                $catRecherche->setRelation('articles', $articles);
                $categories->push($catRecherche);
            }
        } else {
            if ($this->type_vente === 'resto') {
                $categories = \App\Models\Categorie::with(['articles' => function($q) {
                    $q->where('gerer_stock', false);
                }])->get();
            } else {
                $articles = Article::where('gerer_stock', true)->where('ar_qte', '>', 0)->get();
                $categories = collect();
                
                $sansCategorie = $articles->whereNull('categorie_id');
                if ($sansCategorie->count() > 0) {
                    $catSans = new \App\Models\Categorie(['nom' => 'Sans catégorie']);
                    $catSans->setRelation('articles', $sansCategorie);
                    $categories->push($catSans);
                }

                $avecCategorie = $articles->whereNotNull('categorie_id')->groupBy('categorie_id');
                foreach ($avecCategorie as $catId => $arts) {
                    $cat = \App\Models\Categorie::find($catId);
                    if ($cat) {
                        $cat->setRelation('articles', $arts);
                        $categories->push($cat);
                    }
                }
            }
            $categories = $categories->filter(fn($c) => $c->articles->count() > 0);
        }

        $methodesList = Methode::where('meth_active', '1')->get();
        $clientsList = Client::all();
        $this->type_paiement = Methode::find($this->paiement_id);

        return view('livewire.point-of-sale', compact('categories', 'methodesList', 'clientsList'));
    }
}