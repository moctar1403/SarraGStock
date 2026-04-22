<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Methode;
use App\Models\Operat;
use App\Models\Remise;
use App\Models\Sortstock;
use App\Models\Unite;
use App\Models\Vente;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateVenteg extends Component
{
    public $selectedState;
    public $selectedCity;
    public $arts;
    public $init_client;
    public $recherche_client = '';
    public $client;
    public $paiement_id = '0';
    public $client_id = '0';
    public $type_paiement;
    public $meth_credit = '';
    public $total_vente = 0;
    public $remise = 0;
    public $receiveRemise;
    public $remise2 = 0;
    public $count = 0;
    public $compteur_remise = 0;
    public $classeremise = "";
    public $msg_remise = "";
    public $clickRemise = "";
    public $mremise = 0;
    public $total_vente_apres_remise = 0;
    public $current_article = null;
    
    public $vgs = [
        [
            'article_id' => '',
            'code_barre' => '',
            'quantite_dispo' => '',
            'client_id' => '0',
            'ar_unite' => '1',
            'ar_unite2' => '',
            've_quantite' => '0',
            've_prix_achat' => '',
            've_prix_vente' => '',
            've_prix_tot' => '',
            'selectPro' => '0',
        ],
    ];

    public function mount()
    {
        $this->meth_credit = Methode::where('meth_nom', 'like', '%credit%')->first();
        $this->classeremise = "bg-blue-600 rounded-md p-2 text-sm text-white";
        $this->msg_remise = "+ Accorder une remise";
        $this->clickRemise = "clickRemise1()";
        $this->receiveRemise = '1';
    }

    public function addVente()
    {
        $this->vgs[] = [
            'article_id' => '',
            'code_barre' => '',
            'quantite_dispo' => '',
            'client_id' => '0',
            'ar_unite' => '1',
            'ar_unite2' => '',
            've_quantite' => '0',
            've_prix_achat' => '',
            've_prix_vente' => '',
            've_prix_tot' => '',
            'selectPro' => '0',
        ];
    }

    public function removeVente($index)
    {
        unset($this->vgs[$index]);
        $this->vgs = array_values($this->vgs);
    }

    public function rules()
    {
        $rules = [];
        
        foreach ($this->vgs as $index => $vg) {
            $rules["vgs.{$index}.quantite_dispo"] = 'required|numeric';
            $rules["vgs.{$index}.ve_prix_vente"] = 'required|numeric';
            $rules["vgs.{$index}.ve_prix_tot"] = 'required|numeric';
        }
        
        foreach ($this->vgs as $index => $vg) {
            if ($vg['ar_unite'] == 1) {
                $rules["vgs.{$index}.ve_quantite"] = "required|integer|lte:vgs.{$index}.quantite_dispo|gt:0";
            } else {
                $rules["vgs.{$index}.ve_quantite"] = "required|numeric|lte:vgs.{$index}.quantite_dispo|gt:0";
            }
        }
        
        $rules["vgs.*.article_id"] = 'required|distinct';
        $rules["paiement_id"] = 'required|numeric|min:1';
        $rules["client_id"] = 'required|numeric';
        $rules["remise"] = 'numeric';
        $rules["remise2"] = 'numeric';
        
        if ($this->paiement_id == $this->meth_credit->id && $this->client_id == 0) {
            $rules['client_id'] = 'required|numeric|min:1';
        }
        
        if ($this->compteur_remise > 0) {
            $rules['remise'] = 'required|numeric|gt:0';
            $rules['remise2'] = 'required|numeric|gt:0';
        }
        
        return $rules;
    }

    public function messages(): array
    {
        return [
            'vgs.*.article_id.required' => __("Article") . ":position" . __("est requis"),
            'vgs.*.article_id.distinct' => __("Article") . " " . __("dupliqué"),
            'vgs.*.quantite_dispo.required' => __("Quantite dispo") . ":position" . __("est requise"),
            'vgs.*.quantite_dispo.numeric' => __("Quantite dispo") . ":position" . __("pas numerique"),
            'vgs.*.ve_quantite.required' => __("Quantite") . ":position" . __("est requise"),
            'vgs.*.ve_quantite.integer' => __("Quantite") . ":position" . __("doit être un entier"),
            'vgs.*.ve_quantite.numeric' => __("Quantite") . ":position" . __("doit être numerique"),
            "vgs.*.ve_quantite.lte" => __("Quantite") . ":position" . __("doit être inf à quantite dispo"),
            "vgs.*.ve_quantite.min" => __("Quantite") . ":position" . __("minimum 1"),
            "vgs.*.ve_quantite.gt" => __("Quantite") . " " . __("doit être supérieur à") . " :value",
            'vgs.*.ve_prix_vente.required' => __("Prix") . ":position" . __("est requis"),
            'vgs.*.ve_prix_vente.numeric' => __("Prix") . ":position" . __("est requis"),
            'vgs.*.ve_prix_tot.required' => __("Prix total") . ":position" . __("est requis"),
            'vgs.*.ve_prix_tot.numeric' => __("Prix total") . ":position" . __("doit être numerique"),
            'paiement_id.required' => __("Le type de paiement est requis"),
            'paiement_id.min' => __("Choisissez le mode de paiement"),
            'client_id.min' => __("Séléctionnez un client"),
        ];
    }

    public function store()
    {
        $this->validate();
        
        $facture = new Facture();
        $facture->save();
        
        for ($j = 0; $j < $this->count; $j++) {
            try {
                $vnt = Vente::create([
                    'article_id' => $this->vgs[$j]['article_id'],
                    've_client' => $this->client_id,
                    've_quantite' => $this->vgs[$j]['ve_quantite'],
                    've_prix_achat' => $this->vgs[$j]['ve_prix_achat'],
                    've_prix_vente' => $this->vgs[$j]['ve_prix_vente'],
                    've_prix_tot' => $this->vgs[$j]['ve_prix_tot'],
                    'type_p' => $this->paiement_id,
                    'facture_id' => $facture->id,
                    've_saisi_par' => Auth::user()->id,
                ]);

                $article = Article::find($this->vgs[$j]['article_id']);
                $article->ar_qte -= $this->vgs[$j]['ve_quantite'];
                $article->save();

                $methode = Methode::find($this->paiement_id);
                $methode->meth_solder += $this->vgs[$j]['ve_prix_tot'];
                $methode->meth_soldev += $this->vgs[$j]['ve_prix_tot'];
                $methode->save();

                Sortstock::create([
                    'article_id' => $vnt->article_id,
                    'sor_vente' => $vnt->id,
                    'sor_qte' => $vnt->ve_quantite,
                    'sor_prix_achat' => $vnt->ve_prix_achat,
                    'sor_prix_vente' => $vnt->ve_prix_vente,
                    'sor_montant_t_achat' => $vnt->ve_quantite * $vnt->ve_prix_achat,
                    'sor_montant_t_vente' => $vnt->ve_quantite * $vnt->ve_prix_vente,
                    'sor_date' => $vnt->created_at,
                    'sor_motif' => 'vente',
                    'sor_observations' => 'vente',
                    'sor_saisi_par' => $vnt->ve_saisi_par,
                ]);

                $data = "enregistrement de la vente id " . $vnt->id . " ";
                $model = "App\Models\Vente";
                trace($data, $model);

            } catch (Exception $e) {
                return redirect()->route('ventes.index')->with('danger', 'Un problème est rencontré');
            }
        }

        $fact = Facture::find($vnt->facture_id);
        $fact->fa_num = $fact->id;
        $fact->fa_client = $this->client_id;
        $fact->fa_type_p = $this->paiement_id;
        $fact->fa_tot = $this->total_vente;
        $fact->fa_t_remise = $this->remise;
        $fact->fa_m_remise = $this->mremise;
        $fact->fa_tot_apres_remise = $this->total_vente_apres_remise;
        $fact->save();

        Operat::create([
            'operat_meth_id' => $vnt->type_p,
            'operat_vent_id' => $vnt->id,
            'operat_tr_id' => 0,
            'operat_montant' => $fact->fa_tot_apres_remise,
        ]);

        if ($this->compteur_remise > 0) {
            $remise = new Remise();
            $remise->facture_id = $fact->id;
            $remise->re_taux_remise = $this->remise;
            $remise->re_montant_facture = $this->total_vente;
            $remise->re_montant_remise = $this->mremise;
            $remise->re_prix_tot_apres_remise = $this->total_vente_apres_remise;
            $remise->save();

            $methode = Methode::find($this->paiement_id);
            $methode->meth_solder -= $remise->re_montant_remise;
            $methode->meth_soldev -= $remise->re_montant_remise;
            $methode->save();
        }

        if ($this->client_id != 0 && $this->paiement_id == $this->meth_credit->id) {
            $cli = Client::find($this->client_id);
            $cli->cli_situation += $this->total_vente_apres_remise;
            $cli->save();
        }

        return redirect()->route('factures.detail', $fact->id)
            ->with('success', $this->count > 1 
            ? __('Ventes ajoutées avec succès') 
            : __('Vente ajoutée avec succès'));
    }

    // ==================== MÉTHODES DE RECHERCHE ====================

    public function searchArticleByCode($index)
    {
        if (!isset($this->vgs[$index])) {
            return;
        }

        $codeBarre = trim($this->vgs[$index]['code_barre'] ?? '');

        if (empty($codeBarre)) {
            $this->resetArticleFields($index);
            return;
        }

        $article = Article::where('id', $codeBarre)
            ->orWhere('ar_codebarre', $codeBarre)
            ->orWhere('ar_reference', $codeBarre)
            ->first();

        if ($article) {
            $this->vgs[$index]['article_id'] = $article->id;
            $this->vgs[$index]['quantite_dispo'] = $article->ar_qte;
            $this->vgs[$index]['ve_prix_achat'] = $article->ar_prix_achat;
            $this->vgs[$index]['ve_prix_vente'] = $article->ar_prix_vente;
            
            $unite = Unite::find($article->ar_unite);
            $this->vgs[$index]['ar_unite'] = $article->ar_unite;
            $this->vgs[$index]['ar_unite2'] = $unite ? $unite->unit_lib : '';
            
            if (empty($this->vgs[$index]['ve_quantite']) || $this->vgs[$index]['ve_quantite'] == '0') {
                $this->vgs[$index]['ve_quantite'] = 1;
            }
            
            $this->calculateTotals();
        } else {
            $this->resetArticleFields($index);
        }
    }

    public function resetArticleFields($index)
    {
        $this->vgs[$index]['article_id'] = '';
        $this->vgs[$index]['quantite_dispo'] = '0';
        $this->vgs[$index]['ve_prix_achat'] = '0';
        $this->vgs[$index]['ve_prix_vente'] = '0';
        $this->vgs[$index]['ve_quantite'] = '0';
        $this->vgs[$index]['ve_prix_tot'] = '0';
        $this->vgs[$index]['ar_unite'] = '1';
        $this->vgs[$index]['ar_unite2'] = '';
    }

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

    // ==================== MÉTHODES DE CALCUL ====================

    public function updateArticleData($index)
    {
        if (!isset($this->vgs[$index])) {
            return;
        }

        $article = Article::find($this->vgs[$index]['article_id'] ?? 0);

        if ($article) {
            $this->vgs[$index]['quantite_dispo'] = ($article->ar_unite == 1) 
                ? (int)$article->ar_qte 
                : $article->ar_qte;
            $this->vgs[$index]['ve_prix_achat'] = $article->ar_prix_achat;
            $this->vgs[$index]['ve_prix_vente'] = $article->ar_prix_vente;
        }
    }

    public function calculateTotals()
    {
        $this->total_vente = 0;

        foreach ($this->vgs as $index => $vg) {
            $prixVente = (float)($vg['ve_prix_vente'] ?? 0);
            $quantite = (float)($vg['ve_quantite'] ?? 0);
            $this->vgs[$index]['ve_prix_tot'] = $prixVente * $quantite;
            $this->total_vente += $this->vgs[$index]['ve_prix_tot'];
        }
    }

    public function updateUnits()
    {
        foreach ($this->vgs as $index => $vg) {
            $article = Article::find($vg['article_id'] ?? 0);
            if ($article) {
                $this->vgs[$index]['ar_unite'] = $article->ar_unite;
            }

            $unite = Unite::find($this->vgs[$index]['ar_unite'] ?? 1);
            $this->vgs[$index]['ar_unite2'] = $unite->unit_lib ?? '';
        }
    }

    // ==================== MÉTHODE REMISE AVEC GESTION DES VIRGULES ====================

    public function calculateRemise()
    {
        if ($this->compteur_remise > 0) {
            if ($this->receiveRemise == '1') {
                // Gestion des virgules et arrondi à 3 décimales
                $remiseValue = str_replace(',', '.', $this->remise);
                $this->remise = round(floatval($remiseValue), 3);
                $this->mremise = $this->total_vente * $this->remise * 0.01;
                $this->remise2 = $this->mremise;
            } else {
                // Gestion des virgules et arrondi à 3 décimales
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

    // ==================== MÉTHODES D'INTERACTION ====================

    public function clickClient()
    {
        $this->recherche_client = '';
    }

    public function clickPaiment()
    {
        // Méthode requise par le template
    }

    public function clickArticle(int $index)
    {
        $this->vgs[$index]['code_barre'] = '';
    }

    public function clickselectPro1(int $index)
    {
        $this->vgs[$index]['code_barre'] = '';
        $this->vgs[$index]['selectPro'] = '1';
    }

    public function clickselectPro2(int $index)
    {
        $this->vgs[$index]['article_id'] = '';
        $this->vgs[$index]['selectPro'] = '0';
    }

    public function clickRemise1()
    {
        $this->compteur_remise = 1;
        $this->classeremise = "bg-red-600 rounded-md p-2 text-sm text-white";
        $this->msg_remise = "- Supprimer la remise";
        $this->clickRemise = "clickRemise2()";
    }

    public function clickRemise2()
    {
        $this->compteur_remise = 0;
        $this->remise = 0;
        $this->remise2 = 0;
        $this->classeremise = "bg-blue-600 rounded-md p-2 text-sm text-white";
        $this->msg_remise = "+ Accorder une remise";
        $this->clickRemise = "clickRemise1()";
    }

    // ==================== HOOKS LIVEWIRE ====================

    public function updatedVgs($value, $key)
    {
        // Recherche par code barre
        if (str_contains($key, 'code_barre')) {
            $parts = explode('.', $key);
            if (count($parts) >= 2) {
                $index = (int)$parts[1];
                if (isset($this->vgs[$index])) {
                    $this->searchArticleByCode($index);
                }
            }
        }
        
        // Sélection manuelle d'article
        if (str_contains($key, 'article_id')) {
            $parts = explode('.', $key);
            if (count($parts) >= 2) {
                $index = (int)$parts[1];
                if (isset($this->vgs[$index])) {
                    $this->updateArticleData($index);
                    $this->calculateTotals();
                    $this->calculateRemise();
                }
            }
        }
        
        // Changement de quantité
        if (str_contains($key, 've_quantite')) {
            $this->calculateTotals();
            $this->calculateRemise();
        }
    }

    public function updatedRechercheClient()
    {
        $this->updateClientBySearch();
    }

    // ==================== RENDER ====================

    public function render()
    {
        $this->count = count($this->vgs);

        // Mettre à jour le client et les autres données
        $this->type_paiement = Methode::find($this->paiement_id);
        $this->client = Client::find($this->client_id);
        $this->updateClientBySearch();

        // Calculer les totaux et mettre à jour les unités
        $this->calculateTotals();
        $this->updateUnits();
        $this->calculateRemise();

        // Récupérer les listes pour les selects
        $unitesList = Unite::all();
        $clientsList = Client::all();
        $methodesList = Methode::where('meth_active', '1')->get();
        $articlesList = Article::where('ar_qte', '>', '0')->get();

        return view('livewire.create-venteg', compact(
            'unitesList',
            'clientsList',
            'methodesList',
            'articlesList'
        ));
    }
}