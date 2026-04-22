<?php

namespace App\Http\Controllers;

use App\Models\Sortstock;
use Illuminate\Http\Request;
use App\helpers;

class SortstockController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view sortie', ['only' =>['index']]);
        $this->middleware('permission:create sortie', ['only' =>['create','store']]);
        $this->middleware('permission:update sortie', ['only'=> ['update','edit']]);
        $this->middleware('permission:delete sortie', ['only' =>['destroy']]);
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
    public function show(Sortstock $sortstock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sortstock $sortstock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sortstock $sortstock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sortstock $sortstock)
    {
        //
    }
}
