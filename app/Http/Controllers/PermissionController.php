<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\helpers;

class PermissionController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view permission', ['only' =>['index']]);
        $this->middleware('permission:create permission', ['only' =>['create','store']]);
        $this->middleware('permission:update permission', ['only'=> ['update','edit']]);
        $this->middleware('permission:delete permission', ['only' =>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $permissions=Permission::get();
    //     return view('role-permission.permission.index',compact('permissions'));
    // }
    public function index()
    {
        //trace
        $data="liste des permissions";
        $model="Spatie\Permission\Models\Permission";
        trace($data,$model);  
        //end trace   
        $permissions=Permission::get();
        return view('role-permission.permission.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('role-permission.permission.create');
    // }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //trace
        $data="créer une permission";
        $model="Spatie\Permission\Models\Permission";
        trace($data,$model);  
        //end trace   
        return view('role-permission.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|min:4|unique:permissions,name',
        ]);
        Permission::create([
            'name'=>$request->name,
        ]);
        //trace
        $data="création de permission ".$request->name;
        $model="Spatie\Permission\Models\Permission";
        trace($data,$model);  
        //end trace   
        return redirect('permissions')->with('succes',__('Permission créée avec succès'));
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
    // public function edit(Permission $permission)
    // {
    //     return view('role-permission.permission.edit',compact('permission'));
    // }
    public function edit(Permission $permission)
    {
         //trace
         $data="edition de permission ".$permission->name;
         $model="Spatie\Permission\Models\Permission";
         trace($data,$model);  
         //end trace   
        return view('role-permission.permission.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        //dd($request->name);
        $request->validate([
            'name'=>[
                'required',
                'string',
                'min:4',
                'unique:permissions,name,'.$permission->id
            ]
        ]);
        $permission->update([
            'name'=>$request->name,
        ]);
        //trace
        $data="mis à jour permission ".$permission->name;
        $model="Spatie\Permission\Models\Permission";
        trace($data,$model);  
        //end trace   
        return redirect('permissions')->with('succes',__('Permission mise à jour avec succès'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($permissionId)
    {
        $permission=Permission::find($permissionId);
        //trace
        $data="suppression de permission ".$permission->name;
        $model="Spatie\Permission\Models\Permission";
        trace($data,$model);  
        //end trace   
        $permission->delete();
        return redirect('permissions')->with('succes','Permission supprimée avec succès');
    }
}
