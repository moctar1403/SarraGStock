<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\helpers;

class OperatController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view operations methodes', ['only' =>['index']]);
    }
    public function index()
    {
        //trace
        $data="liste des opérations sur les methodes";
        $model="App\Models\Operat";
        trace($data,$model);     
        return view('operat.index');
    }
}
