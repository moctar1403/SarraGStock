<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\Facture;
use App\Models\Sortstock;
use Illuminate\Http\Request;
use App\helpers;

class VenteController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view vente', ['only' =>['index']]);
        $this->middleware('permission:create vente', ['only' =>['create','store']]);
        $this->middleware('permission:update vente', ['only'=> ['update','edit']]);
        $this->middleware('permission:delete vente', ['only' =>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         //trace
         $data="Liste des ventes";
         $model="App\Models\Vente";
         trace($data,$model);   
        return view ('ventes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //trace
        $data="creation des ventes";
        $model="App\Models\Vente";
        trace($data,$model);   
        return view ('ventes.create');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function createg()
    {
        //trace
        $data="creation des ventes";
        $model="App\Models\Vente";
        trace($data,$model);  
        return view ('ventes.createg');
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
    public function show(Vente $vente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vente $vente)
    {
        //trace
        $data="edition de vente".$vente->id;
        $model="App\Models\Vente";
        trace($data,$model);  
        return view ('ventes.edit',compact('vente'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vente $vente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vente $vente)
    {
        //
    }
}
