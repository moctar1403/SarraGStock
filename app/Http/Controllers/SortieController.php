<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sortstock;
use App\helpers;

class SortieController extends Controller
{
    public $model="App\Models\Sortstock";
    public function __construct(){
        $this->middleware('permission:view sortie', ['only' =>['index']]);
        $this->middleware('permission:create sortie', ['only' =>['create','store']]);
        $this->middleware('permission:update sortie', ['only'=> ['update','edit']]);
        $this->middleware('permission:delete sortie', ['only' =>['destroy']]);
        $this->middleware('permission:create details', ['only' =>['detail']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //trace begin
        $data="Liste des sorties en stock";
        trace($data,$this->model);
        //trace end
        return view ('sorties.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //trace begin
        $data="creeation une entree en stock";
        trace($data,$this->model);
        //trace end
        return view ('sorties.create');
    }
    public function detail()
    {
        //trace begin
        $data="creeation une entree en detail en stock";
        trace($data,$this->model);
        //trace end
        return view ('sorties.detail');
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
    public function edit(Sortstock $sortie)
    {
        return view ('sorties.edit',compact('sortie'));
    }

    /**
     * Print the specified resource.
     */
    public function print(Sortstock $sortie)
    {
        return view ('sorties.index');
        // return view ('sorties.print',compact('sortie'));
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
