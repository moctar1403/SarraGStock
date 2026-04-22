<?php

namespace App\Livewire;

use App\helpers;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $roles;
    public function store()
    {
        $this->validate([
            'name'=>'required|string|min:3|max:20|unique:users,name',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|min:4|max:20|confirmed',
            'roles'=>'required',
        ]);
        $user=User::create([
            'name'=>$this->name,
            'email'=>$this->email,
            'password'=>Hash::make($this->password),
        ]);
         //trace
         $data="création user ".$this->name." ".$this->email;
         $model="App\Models\User";
         trace($data,$model);   
        $user->syncRoles($this->roles);
        return redirect('users')->with('succes',__('Utilisateur créé avec succès avec les rôles'));
    }
    public function render()
    {
        $roles1=Role::get();
        return view('livewire.create-user',compact('roles1'));
    }
}
