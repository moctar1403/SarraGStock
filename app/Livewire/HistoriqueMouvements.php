<?php

namespace App\Livewire;

use App\Models\Entrstock;
use App\Models\Sortstock;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class HistoriqueMouvements extends Component
{
    use WithPagination;

    public $search = '';
    public $date_debut;
    public $date_fin;

    public function mount()
    {
        // Par défaut, on affiche le mois en cours
        $this->date_debut = now()->startOfMonth()->format('Y-m-d');
        $this->date_fin = now()->format('Y-m-d');
    }

    public function render()
    {
        // On utilise une requête UNION pour fusionner les entrées et les sorties
        // C'est la façon la plus performante de faire un "Grand Livre"
        
        $queryEntrees = DB::table('entrstocks')
            ->join('articles', 'entrstocks.article_id', '=', 'articles.id')
            ->leftJoin('users', 'entrstocks.ent_saisi_par', '=', 'users.id')
            ->select(
                'entrstocks.id as ref_id',
                'entrstocks.created_at',
                'articles.ar_lib as article_nom',
                'entrstocks.ent_qte as quantite',
                'entrstocks.ent_motif as type_mouvement',
                'entrstocks.ent_observations as reference',
                'users.name as utilisateur',
                DB::raw("'entree' as direction")
            )
            ->when($this->search, function($q) {
                $q->where('articles.ar_lib', 'like', '%' . $this->search . '%');
            })
            ->when($this->date_debut, function($q) {
                $q->whereDate('entrstocks.created_at', '>=', $this->date_debut);
            })
            ->when($this->date_fin, function($q) {
                $q->whereDate('entrstocks.created_at', '<=', $this->date_fin);
            });

        $querySorties = DB::table('sortstocks')
            ->join('articles', 'sortstocks.article_id', '=', 'articles.id')
            ->leftJoin('users', 'sortstocks.sor_saisi_par', '=', 'users.id')
            ->select(
                'sortstocks.id as ref_id',
                'sortstocks.created_at',
                'articles.ar_lib as article_nom',
                'sortstocks.sor_qte as quantite',
                'sortstocks.sor_motif as type_mouvement',
                'sortstocks.sor_observations as reference',
                'users.name as utilisateur',
                DB::raw("'sortie' as direction")
            )
            ->when($this->search, function($q) {
                $q->where('articles.ar_lib', 'like', '%' . $this->search . '%');
            })
            ->when($this->date_debut, function($q) {
                $q->whereDate('sortstocks.created_at', '>=', $this->date_debut);
            })
            ->when($this->date_fin, function($q) {
                $q->whereDate('sortstocks.created_at', '<=', $this->date_fin);
            });

        // On fusionne les deux requêtes et on trie par date
        $mouvements = $queryEntrees->unionAll($querySorties)
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('livewire.historique-mouvements', compact('mouvements'));
    }
}