<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\helpers;

class ArticleController extends Controller
{
    public $model="App\Models\Article";
    public function __construct(){
        $this->middleware('permission:view article', ['only' =>['index','index0']]); 
        $this->middleware('permission:view inventaire', ['only' =>['inventaire']]); 
        $this->middleware('permission:create article', ['only' =>['create','store']]);
        $this->middleware('permission:update article', ['only'=> ['update','edit']]);
        $this->middleware('permission:delete article', ['only' =>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data="Liste des articles";
        // $model="App\Models\Article";
        trace($data,$this->model);
        return view('articles.index');
    }
    public function index0()
    {
        //trace
        $data="menue navigation articles";
        $model="App\Models\Article";
        trace($data,$model);     
        return view('articles.index0');
    }
    public function inventaire()
    {
        $data="Inventaire des articles";
        // $model="App\Models\Article";
        trace($data,$this->model);
        return view('articles.inventaire');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data="Création de article";
        // $model="Article";
        trace($data,$this->model);
        return view('articles.create');
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
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $data="Edition article ".$article->id;
        // $model="Article";
        trace($data,$this->model);
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
