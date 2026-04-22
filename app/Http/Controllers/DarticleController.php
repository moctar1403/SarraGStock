<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\helpers;

class DarticleController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view listedetails', ['only' =>['index',]]); 
        $this->middleware('permission:create details', ['only' =>['create',]]); 
    }
    public $model="App\Models\Darticle";
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data="Liste des darticles";
        trace($data,$this->model);
        return view('darticles.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data="Création de darticle";
        trace($data,$this->model);
        return view('darticles.create');
    }

}
