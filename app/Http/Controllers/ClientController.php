<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\Validator;
use App\helpers;

class ClientController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view client', ['only' =>['index']]);
        $this->middleware('permission:create client', ['only' =>['create','store']]);
        $this->middleware('permission:update client', ['only'=> ['update','edit']]);
        $this->middleware('permission:delete client', ['only' =>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('clients.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $request->validate([
                'orderClients.*.cli_nom' => 'required|string|min:2',
                'orderClients.*.cli_societe' => 'required|string',
                'orderClients.*.cli_civilite' => 'required|string',
                'orderClients.*.cli_tel' => 'required|numeric|digits:8',
                'orderClients.*.cli_adresse' => 'required|string',
                'orderClients.*.cli_email' => 'required|email',
                'orderClients.*.cli_observations' => 'required|string',
            ]);
        
            
        // dd("je suis la");
                
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
