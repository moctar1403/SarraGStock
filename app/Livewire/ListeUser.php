<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Traits\WithDelete;

class ListeUser extends Component
{
    use WithPagination;
    use WithDelete {
        delete as protected traitDelete;
    }

        public function delete()
    {
        $user = User::where('id', '=', $this->deleteId)->first();
         
        // Protection des comptes ID 1 et 2
        if (in_array($user->id, [1, 2])) {
            $data = "Tentative de suppression d'un compte protégé : " . $user->name;
            $model = "App\Models\User";
            trace($data, $model); 
            
            return redirect('users')->with('danger', __('Impossible de supprimer ce compte administrateur principal.'));
        }

        // Si c'est un autre utilisateur, on supprime
        $data = "Suppression de l'utilisateur " . $user->name;
        $model = "App\Models\User";
        trace($data, $model);   
        
        $user->delete();
        
        return redirect('users')->with('success', __('Utilisateur supprimé avec succès'));
    }

    public function render()
    {
        $users = User::get();
        return view('livewire.liste-user', compact('users'));
    }
}