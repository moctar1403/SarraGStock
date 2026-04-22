<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\helpers;

class PaiementController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view paiement', ['only' =>['index']]);
        $this->middleware('permission:create paiement', ['only' =>['create']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('paiements.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('paiements.create');
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
        return view('paiements.edit', compact('paiement'));
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
