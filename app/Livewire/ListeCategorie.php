<?php

namespace App\Livewire;

use App\Models\Categorie;
use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\WithDelete;

#[Layout('layouts.app')]
class ListeCategorie extends Component
{
    use WithPagination;
    
    use WithDelete {
        delete as protected traitDelete;
    }

    public $search = '';
    public $nom = '';
    public $categorieId = null;
    public $isEditing = false;

    // Liste des catégories qui ne peuvent jamais être modifiées ou supprimées
    protected $categoriesFigees = ['Plats', 'Boissons', 'Desserts', 'Entrées'];

    protected function rules()
    {
        return [
            'nom' => 'required|string|unique:categories,nom,' . $this->categorieId,
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $categorie = Categorie::find($this->categorieId);
            if ($categorie && !in_array($categorie->nom, $this->categoriesFigees)) {
                $categorie->update(['nom' => $this->nom]);
                session()->flash('success', __('Catégorie mise à jour.'));
            } else {
                session()->flash('danger', __('Impossible de modifier une catégorie figée.'));
            }
        } else {
            Categorie::create(['nom' => $this->nom]);
            session()->flash('success', __('Catégorie créée.'));
        }

        $this->reset(['nom', 'categorieId', 'isEditing']);
    }

    public function edit($id)
    {
        $categorie = Categorie::find($id);
        if (in_array($categorie->nom, $this->categoriesFigees)) {
            session()->flash('danger', __('Cette catégorie est figée et ne peut pas être modifiée.'));
            return;
        }

        $this->categorieId = $categorie->id;
        $this->nom = $categorie->nom;
        $this->isEditing = true;
    }

    public function cancelEdit()
    {
        $this->reset(['nom', 'categorieId', 'isEditing']);
    }

    public function delete()
    {
        $categorie = Categorie::find($this->deleteId);

        if (!$categorie) {
            return redirect()->route('configs.categories')->with('danger', __('Catégorie introuvable.'));
        }

        // 1. Vérification : Est-elle figée ?
        if (in_array($categorie->nom, $this->categoriesFigees)) {
            return redirect()->route('configs.categories')->with('danger', __('Cette catégorie est figée et ne peut pas être supprimée.'));
        }

        // 2. Vérification : Contient-elle des articles ?
        $articlesCount = Article::where('categorie_id', $categorie->id)->count();
        if ($articlesCount > 0) {
            return redirect()->route('configs.categories')->with('danger', __('Impossible de supprimer cette catégorie car elle contient des articles.'));
        }

        $categorie->delete();
        return redirect()->route('configs.categories')->with('success', __('Catégorie supprimée.'));
    }

    public function render()
    {
        $categories = Categorie::withCount('articles')
            ->when($this->search, function ($query) {
                $query->where('nom', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.liste-categorie', [
            'categories' => $categories,
            'categoriesFigees' => $this->categoriesFigees
        ]);
    }
}