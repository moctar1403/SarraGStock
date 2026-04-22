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
        $user=User::where('id','=',$this->deleteId)->first();
         
        // Test si user est super-admin
        if ($user->name=="super-admin") {
            $data="tenter de supprimer super-admin".$user->name." ".$user->email;
            $model="App\Models\User";
            trace($data,$model); 
            return redirect('users')->with('danger',$user->name.' ne peut pas être supprimé');
        }
        $data="delete user ".$user->name." ".$user->email;
        $model="App\Models\User";
        trace($data,$model);   
        $user->delete();
        return redirect('users')->with('succes',__('Utilisateur supprimé avec succès'));
    }
    public function render()
    {
        $users=User::get();
        return view('livewire.liste-user',compact('users'));
    }
}
