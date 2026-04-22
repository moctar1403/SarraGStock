<?php

namespace App\Http\Controllers;

use App\Models\Methode;
use Illuminate\Http\Request;
use App\helpers;

class OperationController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view operations', ['only' =>['index']]);
        $this->middleware('permission:sauvegarde', ['only' =>['sauvegarde_restauration']]);
        $this->middleware('permission:restauration', ['only' =>['restauration']]);
        // $this->middleware('permission:create societe', ['only' =>['create','store']]);
        // $this->middleware('permission:update societe', ['only'=> ['update','edit']]);
        // $this->middleware('permission:delete societe', ['only' =>['destroy']]);
    }
    public function methodes()
    {
        //trace
        $data="transfert";
        $model="";
        trace($data,$model);     
        return view('operation.methodes');
    }
    public function ltransfert()
    {
        //trace
        $data="liste des transferts";
        $model="";
        trace($data,$model);     
        return view('operation.ltransfert');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //trace
        $data="menue operation";
        $model="";
        trace($data,$model);     
        return view('operation.index');
    }
    public function sauvegarde_restauration()
    {
        //trace
        $data="sauvegarde_restauration";
        $model="";
        trace($data,$model);     
        return view('operation.sauvegarde_restauration');
    }
    public function restauration()
    {
        //trace
        $data="sauvegarde_restauration";
        $model="";
        trace($data,$model);     
        return view('operation.restauration');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        $operation=Methode::where('id',$id)->first();
        return view('operation.edit',compact('operation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
