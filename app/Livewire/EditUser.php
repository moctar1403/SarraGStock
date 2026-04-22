<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

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
        $this->roles=Role::pluck('name','name')->all();
        
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->userRoles=$this->user->roles()->pluck('name','name')->all();
    }
    public function rules()
    {
        $rules = [];
        $rules["name"] = 'required|string|min:3|max:20|unique:users,name,'.$this->user->id;
        $rules["email"] = 'required|email|unique:users,email,'.$this->user->id;
        $rules["password"] = 'required|string|min:4|max:20|confirmed';
        $rules["roles2"] = 'required';
        return $rules;
    }
    public function store(User $user,Request $request)
    {
        $user=User::find($this->user->id);
        $this->validate();
        try {
                $user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                ]);
                //trace
                $data="update user ".$user->name." ".$user->email;
                $model="App\Models\User";
                trace($data,$model);   
                $user->syncRoles($this->roles2);
                return redirect('users')->with('succes',__("Utilisateur mis à jour avec succès avec les rôles"));
                // return redirect()->route('users.index')->with('succes', 'User mis à jour');
        } catch (Exception $e) {
            //Sera pris en compte si on a un problème
            return redirect()->route('users.index')->with('danger', 'Un problème est rencontré');
        }
    }  
    public function render()
    {
        return view('livewire.edit-user');
    }
}
