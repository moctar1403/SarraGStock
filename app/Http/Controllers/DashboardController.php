<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view dashboard3', ['only' =>['dashboard3']]);
        $this->middleware('permission:view dashboard4', ['only' =>['dashboard4']]);
        $this->middleware('permission:view dashboard5', ['only' =>['dashboard5']]);
        $this->middleware('permission:view dashboard6', ['only' =>['dashboard6']]);
    }
    public function dashboard()
    {
        //trace
        $data="page dashboard";
        $model="App\Models\Homs3";
        trace($data,$model);
        $permissns=Permission::select('name')->get();
        //get currant user
        $user_id=Auth::user()->id;
        // dd($user_id);
        //get currant roles
        $roles=Role::leftJoin('model_has_roles','roles.id','=','model_has_roles.role_id')
                    ->leftJoin('users','users.id','=','model_has_roles.model_id')
                    ->where('users.id','=',$user_id)
                    ->select('roles.id','roles.name')
                    ->get();
        // dd($roles);

        if ($roles) {
            $counter=0;
            foreach ($roles as $key => $value) {
                if (($value->name=='super-admin') or ($value->name=='admin')) {
                    $counter++;
                    break;
                }
            }
            if ($counter>0) {
                return view('dashboard3');
            }
            return view('dashboard');
        }
        else{
            return view('dashboard');
        }
    }
    public function dashboard1()
    {
        return view('dashboard1');
    }
    public function dashboard2()
    {
        return view('dashboard2');
    }
    public function dashboard3()
    {
         //trace
        $data="page dashboard vente 1";
        $model="App\Models\Homs3";
        trace($data,$model);  
        return view('dashboard3');
    }
    public function dashboard4()
    {
         //trace
        $data="page dashboard vente 2";
        $model="App\Models\Homs4";
        trace($data,$model);  
        return view('dashboard4');
    }
    public function dashboard5()
    {
        //trace
         $data="page dashboard articles";
         $model="App\Models\Homs5";
         trace($data,$model);     
        return view('dashboard5');
    }
    public function dashboard6()
    {
         //trace
         $data="page dashboard articles";
         $model="App\Models\Homs3";
         trace($data,$model);     
        return view('dashboard6');
    }
}
