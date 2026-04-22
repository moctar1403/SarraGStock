<?php

namespace App\Livewire;

// use App\Models\Unite;
use App\Models\Article;
use Livewire\Component;
use App\Models\Darticle;
use App\Models\Entrstock;
use App\Models\Sortstock;
use Livewire\WithPagination;
use App\Livewire\Traits\WithDelete;
use Illuminate\Support\Facades\Gate;

class ListeArticles extends Component
{
    use WithPagination;
    
    public $search = '';
    public $selectedArticles = [];
    public $selectAll = false;
    
    use WithDelete {
        delete as protected traitDelete;
    }
    
    // Réinitialiser la pagination lors de la recherche
    public function updatingSearch()
    {
        $this->resetPage();
        $this->reset(['selectedArticles', 'selectAll']);
    }
    
    // Gérer la sélection/désélection de tous les articles
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedArticles = $this->getFilteredArticles()
                ->pluck('id')
                ->toArray();
        } else {
            $this->selectedArticles = [];
        }
    }
    
    // Mettre à jour selectAll quand on modifie la sélection manuelle
    public function updatedSelectedArticles()
    {
        $filteredCount = $this->getFilteredArticles()->count();
        $this->selectAll = count($this->selectedArticles) === $filteredCount && $filteredCount > 0;
    }
    
    // Supprimer la sélection d'articles
    public function deleteSelected()
    {
        // Vérification de la permission
        if (!Gate::allows('delete article')) {
            session()->flash('danger', __("Vous n'avez pas la permission de suppression"));
            return;
        }
        
        if (empty($this->selectedArticles)) {
            session()->flash('danger', __('Veuillez sélectionner au moins un article'));
            return;
        }
        
        $articles = Article::whereIn('id', $this->selectedArticles)->get();
        $deletedCount = 0;
        $errorMessages = [];
        
        foreach ($articles as $article) {
            // Vérifications avant suppression
            $canDelete = $this->checkIfArticleCanBeDeleted($article);
            
            if (!$canDelete['can_delete']) {
                $errorMessages[] = $canDelete['message'];
                continue;
            }
            
            // Suppression
            $article->delete();
            
            // Tracing
            $data = __('Suppression de l\'article id :id libelle :libelle', [
                'id' => $article->id,
                'libelle' => $article->ar_lib
            ]);
            $model = "App\Models\Article";
            trace($data, $model);
            
            $deletedCount++;
        }
        
        // Messages de résultat
        if ($deletedCount > 0) {
            session()->flash('success', trans_choice(':count article(s) supprimé(s) avec succès', $deletedCount, ['count' => $deletedCount]));
        }
        
        if (!empty($errorMessages)) {
            session()->flash('danger', implode('<br>', $errorMessages));
        }
        
        $this->reset(['selectedArticles', 'selectAll']);
    }
    
    // Vérifier si un article peut être supprimé
    private function checkIfArticleCanBeDeleted(Article $article)
    {
        $entree = Entrstock::where('article_id', $article->id)->first();
        if ($entree) {
            return [
                'can_delete' => false,
                'message' => __('Article :name n\'est pas supprimé, il a une entrée en stock', ['name' => $article->ar_lib])
            ];
        }
        
        $sortie = Sortstock::where('article_id', $article->id)->first();
        if ($sortie) {
            return [
                'can_delete' => false,
                'message' => __('Article :name n\'est pas supprimé, il a une sortie en stock', ['name' => $article->ar_lib])
            ];
        }
        
        $darticle1 = Darticle::where('dar_principal', $article->id)->first();
        if ($darticle1) {
            return [
                'can_delete' => false,
                'message' => __('Article :name n\'est pas supprimé, il a un article de détail', ['name' => $article->ar_lib])
            ];
        }
        
        $darticle2 = Darticle::where('dar_detail', $article->id)->first();
        if ($darticle2) {
            return [
                'can_delete' => false,
                'message' => __('Article :name n\'est pas supprimé, c\'est un article de détail d\'un autre article', ['name' => $article->ar_lib])
            ];
        }
        
        return ['can_delete' => true, 'message' => ''];
    }
    
    // Suppression d'un seul article
    public function delete()
    {
        // Vérification de la permission
        if (!Gate::allows('delete article')) {
            return redirect()->route('articles.index')->with('danger', "Vous n'avez pas la permission de suppression");
            // session()->flash('danger', __("Vous n'avez pas la permission de suppression"));
            // return;
        }
        
        $article = Article::find($this->deleteId);
        
        if (!$article) {
            return redirect()->route('articles.index')->with('danger', __("Article non trouvé"));
            // session()->flash('danger', __('Article non trouvé'));
            // return;
        }
        
        // Vérifications avant suppression
        $canDelete = $this->checkIfArticleCanBeDeleted($article);
        
        if (!$canDelete['can_delete']) {
            // session()->flash('danger', $canDelete['message']);
            $this->reset(['deleteId', 'selectedArticles']);
            return redirect()->route('articles.index')->with('danger', $canDelete['message']);
            // return;
        }
        
        // Suppression
        $article->delete();
        
        // Tracing
        $data = __('Suppression de l\'article id :id libelle :libelle', [
            'id' => $article->id,
            'libelle' => $article->ar_lib
        ]);
        $model = "App\Models\Article";
        trace($data, $model);
        $this->reset(['deleteId', 'selectedArticles']);
        return redirect()->route('articles.index')->with('success', __('Article').__(' ').$article->ar_lib.__(' ').__('supprimé'));
        // session()->flash('success', __('Article supprimé avec succès'));
        
    }
    
    // Obtenir les articles filtrés pour la sélection
    private function getFilteredArticles()
    {
        return Article::when($this->search, function ($query) {
            $query->where(function($q) {
                $q->where('ar_lib', 'like', '%' . $this->search . '%')
                  ->orWhere('ar_reference', 'like', '%' . $this->search . '%')
                  ->orWhere('ar_description', 'like', '%' . $this->search . '%')
                  ->orWhere('ar_codebarre', 'like', '%' . $this->search . '%');
            });
        })->get();
    }
    
    // Obtenir les statistiques pour le template
    private function getStats($articles)
    {
        $totalArticles = $articles->total();
        
        // Pour calculer le stock suffisant et faible
        $allArticles = Article::all();
        $stockSuffisant = 0;
        $stockFaible = 0;
        
        foreach ($allArticles as $article) {
            if ($article->ar_qte >= $article->ar_qte_mini) {
                $stockSuffisant++;
            } else {
                $stockFaible++;
            }
        }
        
        return [
            [
                'label' => 'Total Articles',
                'value' => $totalArticles,
                'color' => 'blue',
                'icon' => '<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>'
            ],
            [
                'label' => 'Stock suffisant',
                'value' => $stockSuffisant,
                'color' => 'green',
                'icon' => '<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
            ],
            [
                'label' => 'Stock faible',
                'value' => $stockFaible,
                'color' => 'yellow',
                'icon' => '<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" /></svg>'
            ],
        ];
    }
    
    // Construire la requête de base
    private function buildBaseQuery()
    {
        return Article::leftJoin('unites', 'articles.ar_unite', '=', 'unites.id')
                     ->select('articles.*', 'unites.unit_lib');
    }
    
    // Appliquer les filtres de recherche
    private function applySearchFilters($query)
    {
        if (!empty($this->search)) {
            return $query->where(function($q) {
                $q->where('ar_lib', 'like', '%' . $this->search . '%')
                  ->orWhere('ar_reference', 'like', '%' . $this->search . '%')
                  ->orWhere('ar_description', 'like', '%' . $this->search . '%')
                  ->orWhere('ar_codebarre', 'like', '%' . $this->search . '%')
                  ->orWhere('ar_qte', 'like', '%' . $this->search . '%')
                  ->orWhere('ar_qte_mini', 'like', '%' . $this->search . '%')
                  ->orWhere('ar_prix_vente', 'like', '%' . $this->search . '%');
            });
        }
        
        return $query;
    }
    
    public function render()
    {
        // Construire la requête
        $query = $this->buildBaseQuery();
        $query = $this->applySearchFilters($query);
        
        // Paginer les résultats
        $articles = $query->orderByDesc('ar_qte')->paginate(10);
        
        // Calculer les statistiques
        $stats = $this->getStats($articles);
        
        // Informations de recherche
        $searchInfo = null;
        if ($this->search) {
            $searchInfo = __('Résultats pour') . ' : ' . $this->search;
        }
        
        // Retourner la vue avec TOUTES les variables nécessaires
        return view('livewire.liste-articles', [
            'articles' => $articles,
            'stats' => $stats,
            'searchInfo' => $searchInfo,
            'search' => $this->search, // ← VARIABLE AJOUTÉE ICI
        ]);
    }
}