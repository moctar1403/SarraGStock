<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class EditUser extends Component
{
    public $user;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $roles;
    public $roles2;
    public $userRoles;

    public function mount()
    {
        $this->roles = Role::pluck('name','name')->all();
        
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->userRoles = $this->user->roles()->pluck('name','name')->all();
        $this->roles2 = $this->userRoles; // On pré-remplit les rôles actuels
    }

    public function rules()
    {
        $rules = [];
        
        // Si c'est un admin ou super-admin, on ne valide QUE le mot de passe
        if ($this->user->hasRole('super-admin') || $this->user->hasRole('admin')) {
            $rules["password"] = 'nullable|string|min:4|max:20|confirmed';
        } else {
            // Sinon, validation complète
            $rules["name"] = 'required|string|min:3|max:20|unique:users,name,'.$this->user->id;
            $rules["email"] = 'required|email|unique:users,email,'.$this->user->id;
            $rules["password"] = 'nullable|string|min:4|max:20|confirmed';
            $rules["roles2"] = 'required';
        }
        
        return $rules;
    }

    public function store(User $user)
    {
        $this->validate();
        
        try {
            // Si c'est un admin/super-admin
            if ($this->user->hasRole('super-admin') || $this->user->hasRole('admin')) {
                
                // On met à jour le mot de passe SEULEMENT s'il a été saisi
                if (!empty($this->password)) {
                    $this->user->update([
                        'password' => Hash::make($this->password),
                    ]);
                }
                
                $data = "update password admin " . $this->user->name;
                
            } else {
                // Pour les autres, mise à jour complète
                $this->user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                ]);
                
                if (!empty($this->password)) {
                    $this->user->update(['password' => Hash::make($this->password)]);
                }
                
                $this->user->syncRoles($this->roles2);
                $data = "update user " . $this->user->name . " " . $this->user->email;
            }
            
            // Tracing
            $model = "App\Models\User";
            trace($data, $model);   
            
            return redirect('users')->with('success', __("Utilisateur mis à jour avec succès"));
            
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('danger', 'Un problème est rencontré');
        }
    }  

    public function render()
    {
        return view('livewire.edit-user');
    }
}