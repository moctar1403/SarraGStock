<?php

namespace App\Http\Controllers;

use App\helpers;
use Illuminate\Http\Request;
use App\Models\RoleHasPermission;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct(){
        //$this->middleware(['role:super-admin','permission:publish articles|edit articles']);
        $this->middleware('permission:view role', ['only' =>['index']]);
        $this->middleware('permission:create role', ['only' =>['create','store','addPermissionToRole','givePermissionToRole']]);
        $this->middleware('permission:update role', ['only'=> ['update','edit']]);
        $this->middleware('permission:delete role', ['only' =>['destroy']]);
    }
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //trace
        $data="liste des roles";
        $model="Spatie\Permission\Models\Role";
        trace($data,$model);  
        //end trace   
        $roles=Role::get();
        //return view('role-permission.role.index',compact('roles'));
        return view('role-permission.role.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //trace
        $data="creation de role";
        $model="Spatie\Permission\Models\Role";
        trace($data,$model);  
        //end trace   
        //return view('role-permission.role.create');
        return view('role-permission.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|min:4|unique:roles,name',
        ]);
        Role::create([
            'name'=>$request->name,
        ]);
        //trace
        $data="enregistrement du role ".$request->name." ";
        $model="Spatie\Permission\Models\Role";
        trace($data,$model);  
        //end trace   
        return redirect('roles')->with('succes',__('Rôle créé avec succès'));
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
    public function edit(Role $role)
    {
        //Trace
        $data="edition de role ".$role->name." ";
        $model="Spatie\Permission\Models\Role";
        trace($data,$model);  
        //end Trace  
        //return view('role-permission.role.edit',compact('role'));
        return view('role-permission.role.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //dd($request->name);
        $request->validate([
            'name'=>[
                'required',
                'string',
                'min:4',
                'unique:roles,name,'.$role->id
            ]
        ]);
        $role->update([
            'name'=>$request->name,
        ]);
        //Trace
        $data="mis a jour role ".$role->name." ";
        $model="Spatie\Permission\Models\Role";
        trace($data,$model);  
        //end Trace  
        return redirect('roles')->with('succes',__('Rôle mis à jour avec succès'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($roleId)
    {
        $role=Role::find($roleId);
        //Trace
        $data="suppression du role ".$role->name." ";
        $model="Spatie\Permission\Models\Role";
        trace($data,$model);  
        //end Trace  
        $role->delete();
        return redirect('roles')->with('succes',__('Rôle supprimé avec succès'));
    }
    public function addPermissionToRole($roleId)
    {
        $permissions=Permission::get();
        $role=Role::findOrFail($roleId);
        $rolePermissions=DB::table('role_has_permissions')
                            ->where('role_has_permissions.role_id',$roleId)
                            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                            ->all();
        // dd($rolePermissions);      
        //Trace
        $data="add permission to role ".$role->name." ";
        $model="Spatie\Permission\Models\Role";
        trace($data,$model);  
        //end Trace                
        // return view('role-permission.role.add-permissions',compact('role','permissions','rolePermissions'));
        return view('role-permission.role.add-permissions2',compact('roleId'));
    }
    public function givePermissionToRole(Request $request, $roleId)
    {
        // dd($request->permission);
        $request->validate([
            'permission'=>[
                'required',
            ]
        ]);
        $role=Role::findOrFail($roleId);
        // if ($role->name=='super-admin') {
        //     $rh1s=RoleHasPermission::where('role_id',$role->id)->select('permission_id')->get();
        //     // $rhs2=RoleHasPermission::select('permission_id')->get();
        //     // $rh=RoleHasPermission::where('role_id',$role->id)->groupBy('role_id ')->get();
        //     foreach ($rh1s as $key => $value) {
        //             dd($value); 
        //         }
        // }
        $role->syncPermissions($request->permission);
        // dd($request->permission);
        //Trace
        $data="give permission to role ".$role->name." ";
        $model="Spatie\Permission\Models\Role";
        trace($data,$model);  
        //end Trace    
        // return redirect()->back()->with('succes','Permissions ajoutées au rôle');
        return redirect('roles')->with('succes','Permissions ajoutées au rôle');
    }
}
