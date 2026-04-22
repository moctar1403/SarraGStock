<?php

namespace App\Http\Controllers;

use App\Models\EntrStock;
use Illuminate\Http\Request;
use App\helpers;

class EntreeController extends Controller
{
    public $model="App\Models\EntrStock";
    public function __construct(){
        $this->middleware('permission:view entree', ['only' =>['index']]);
        $this->middleware('permission:create entree', ['only' =>['create','store']]);
        $this->middleware('permission:update entree', ['only'=> ['update','edit']]);
        $this->middleware('permission:delete entree', ['only' =>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //trace begin
        $data="Liste des entrees en stock";
        trace($data,$this->model);
        //trace end
        return view ('entrees.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //trace begin
        $data="creer une entree";
        trace($data,$this->model);
        //trace end
        return view ('entrees.create');
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
    public function show(Entree $entree)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EntrStock $entree)
    {
        return view ('entrees.edit',compact('entree'));
    }

    public function print(EntrStock $entree)
    {
        return view ('entrees.index');
        // return view ('entrees.print',compact('entree'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EntrStock $entree)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EntrStock $entree)
    {
        //
    }
}
