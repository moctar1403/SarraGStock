<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\helpers;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view user', ['only' =>['index']]);
        $this->middleware('permission:create user', ['only' =>['create','store']]);
        $this->middleware('permission:update user', ['only'=> ['update','edit']]);
        $this->middleware('permission:delete user', ['only' =>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         //trace
         $data="Liste des users";
         $model="App\Models\User";
         trace($data,$model);   
        $users=User::get();
        // return view('role-permission.user.index',compact('users'));
        return view('role-permission.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // dd('je suis');
         //trace
         $data="création de user";
         $model="App\Models\User";
         trace($data,$model);   
        $roles=Role::get();
        // return view('role-permission.user.create',compact('roles'));
        return view('role-permission.user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|min:3|max:20|unique:users,name',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|min:4|max:20|confirmed',
            'roles'=>'required',
        ]);
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
         //trace
         $data="création user ".$request->name." ".$request->email;
         $model="App\Models\User";
         trace($data,$model);   
        $user->syncRoles($request->roles);
        return redirect('users')->with('succes',__('Utilisateur créé avec succès avec les rôles'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
         //trace
         $data="edition de user ".$user->email;
         $model="App\Models\User";
         trace($data,$model);   
        $roles=Role::pluck('name','name')->all();
        $userRoles=$user->roles()->pluck('name','name')->all();
        // return view('role-permission.user.edit',compact('user','roles','userRoles'));
        return view('role-permission.user.edit',compact('user','roles','userRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // dd($request->roles);
        if ($user->name=="super-admin") {
            $request->validate([
            'name'=>'required|string|min:3|max:20|unique:users,name,'.$user->id,
            'email'=>'required|email|unique:users,email,'.$user->id,
            'password'=>'required|string|min:4|max:20|confirmed',
            // 'roles'=>'required',
            ]);
        }
        else {
            $request->validate([
            'name'=>'required|string|min:3|max:20|unique:users,name,'.$user->id,
            'email'=>'required|email|unique:users,email,'.$user->id,
            'password'=>'required|string|min:4|max:20|confirmed',
            'roles'=>'required',
            ]);
        }
        
        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        //trace
        $data="update user ".$user->name." ".$user->email;
        $model="App\Models\User";
        trace($data,$model);
        if ($user->name=="super-admin") {
        }
        else {
            $user->syncRoles($request->roles);
        }   
        return redirect('users')->with('succes',__("Utilisateur mis à jour avec succès avec les rôles"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId)
    {
        $user=User::findOrFail($userId);
        //trace
        $data="delete user ".$user->name." ".$user->email;
        $model="App\Models\User";
        trace($data,$model);   
        $user->delete();
        return redirect('users')->with('succes',__('Utilisateur supprimé avec succès'));
    }
}
