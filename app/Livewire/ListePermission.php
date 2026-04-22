<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Traits\WithDelete;
use Spatie\Permission\Models\Permission;

class ListePermission extends Component
{
    public $search = '';
    public $selectedPermissions = [];
    public $selectAll = false;
    
    use WithPagination;
    use WithDelete {
        delete as protected traitDelete;
    }
    
    // Réinitialiser la pagination lors de la recherche
    public function updatingSearch()
    {
        $this->resetPage();
        $this->reset(['selectedPermissions', 'selectAll']);
    }
    
    // Gérer la sélection/désélection de toutes les permissions
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedPermissions = $this->getFilteredPermissions()
                ->pluck('id')
                ->toArray();
        } else {
            $this->selectedPermissions = [];
        }
    }
    
    // Mettre à jour selectAll quand on modifie la sélection manuelle
    public function updatedSelectedPermissions()
    {
        $filteredCount = $this->getFilteredPermissions()->count();
        $this->selectAll = count($this->selectedPermissions) === $filteredCount && $filteredCount > 0;
    }
    
    // Actions groupées
    public function deleteSelected()
    {
        if (empty($this->selectedPermissions)) {
            session()->flash('danger', __('Veuillez sélectionner au moins une permission'));
            return;
        }
        
        $permissions = Permission::whereIn('id', $this->selectedPermissions)->get();
        
        foreach ($permissions as $permission) {
            // Trace
            $data = __('suppression de permission :name', ['name' => $permission->name]);
            $model = "Spatie\Permission\Models\Permission";
            trace($data, $model);
            
            $permission->delete();
        }
        
        $this->reset(['selectedPermissions', 'selectAll']);
        session()->flash('succes', trans_choice(':count permission(s) supprimée(s) avec succès', count($permissions), ['count' => count($permissions)]));
    }
    
    public function delete()
    {
        $permission = Permission::find($this->deleteId);
        
        if ($permission) {
            // Trace
            $data = __('suppression de permission :name', ['name' => $permission->name]);
            $model = "Spatie\Permission\Models\Permission";
            trace($data, $model);
            
            $permission->delete();
            // Dispatch pour fermer le modal (sera exécuté)
            $this->dispatch('close-delete-modal');
            // Redirection
            return redirect('/permissions')->with('succes', __('Permission supprimée avec succès'));
        }
        
    }
    
    // Obtenir les permissions filtrées
    private function getFilteredPermissions()
    {
        return Permission::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })->get();
    }
    
    public function render()
    {
        $permissions = Permission::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
        ->orderBy('name')
        ->paginate(10);
        
        return view('livewire.liste-permission', compact('permissions'));
    }
}