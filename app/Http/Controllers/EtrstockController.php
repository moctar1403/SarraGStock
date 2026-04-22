<?php

namespace App\Http\Controllers;

use App\Models\Etrstock;
use Illuminate\Http\Request;
use App\helpers;

class EtrstockController extends Controller
{
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
        //
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
    public function show(Etrstock $etrstock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Etrstock $etrstock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Etrstock $etrstock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Etrstock $etrstock)
    {
        //
    }
}
