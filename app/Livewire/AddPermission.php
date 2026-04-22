<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddPermission extends Component
{
    public $roleId;
    public $role;
    public $rolePermissions = [];
    public $permission = [];
    public $isSuperAdmin = false;
    public $search = '';
    
    public function store()
    {
        // Si c'est super-admin, on force toutes les permissions
        if ($this->isSuperAdmin) {
            $allPermissions = Permission::pluck('name')->toArray();
            $this->permission = $allPermissions;
        }
        
        $this->validate([
            'permission' => 'required|array'
        ]);
        
        $role = Role::findOrFail($this->roleId);
        $role->syncPermissions($this->permission);
        
        // Trace - CORRECTION
        $data = __('give permission to role :role', ['role' => $role->name]);
        $model = "Spatie\Permission\Models\Role";
        trace($data, $model);
        
        // CORRECTION
        session()->flash('succes', __('Permissions ajoutées au rôle'));
        return redirect()->route('roles.index');
    }
    
    public function mount($roleId)
    {
        $this->roleId = $roleId;
        $this->role = Role::findOrFail($this->roleId);
        
        // Vérifier si c'est super-admin
        $this->isSuperAdmin = ($this->role->name === 'super-admin');
        
        // Récupérer les permissions du rôle
        $this->rolePermissions = $this->role->permissions
            ->pluck('name')
            ->toArray();
            
        // Si super-admin, on prend toutes les permissions
        if ($this->isSuperAdmin) {
            $allPermissions = Permission::pluck('name')->toArray();
            $this->permission = $allPermissions;
            $this->rolePermissions = $allPermissions;
        } else {
            $this->permission = $this->rolePermissions;
        }
    }
    
    // Méthode pour activer/désactiver toutes les permissions filtrées
    public function toggleFilteredPermissions($activate = true)
    {
        if ($this->isSuperAdmin) {
            return;
        }
        
        $filteredPermissions = $this->getFilteredPermissions();
        
        if ($activate) {
            // Ajouter les permissions filtrées
            foreach ($filteredPermissions as $perm) {
                if (!in_array($perm->name, $this->permission)) {
                    $this->permission[] = $perm->name;
                }
            }
        } else {
            // Retirer les permissions filtrées
            foreach ($filteredPermissions as $perm) {
                $key = array_search($perm->name, $this->permission);
                if ($key !== false) {
                    unset($this->permission[$key]);
                }
            }
            // Réindexer le tableau
            $this->permission = array_values($this->permission);
        }
    }
    
    // Méthode pour obtenir les permissions filtrées
    private function getFilteredPermissions()
    {
        return Permission::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })->get();
    }
    
    public function updatedPermission()
    {
        // Si c'est super-admin et qu'on décoche une permission, on la recoche automatiquement
        if ($this->isSuperAdmin) {
            $allPermissions = Permission::pluck('name')->toArray();
            $this->permission = $allPermissions;
            
            // Message d'info pour l'utilisateur - CORRECTION
            $this->dispatch('show-toast', [
                'message' => __('Le super-admin conserve toujours toutes les permissions'),
                'type' => 'info'
            ]);
        }
    }
    
    // Réinitialiser la recherche
    public function resetSearch()
    {
        $this->reset('search');
    }
    
    public function render()
    {
        // Récupérer les permissions avec filtre de recherche
        $permissions = Permission::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })->orderBy('name')->get();
        
        return view('livewire.add-permission', [
            'permissions' => $permissions,
            'role' => $this->role,
            'isSuperAdmin' => $this->isSuperAdmin
        ]);
    }
}