<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\helpers;

class StatController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view statistiques', ['only' =>['index','methodes']]);
    }
    public function methodes()
    {
        //trace
        $data="statistique methodes de paiements";
        $model="";
        trace($data,$model);     
        return view('stats.methodes');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //trace
        $data="menue statistiques";
        $model="";
        trace($data,$model);     
        return view('stats.index');
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
        //
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
