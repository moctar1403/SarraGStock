<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TierController extends Controller
{
    public $model="";
    public function __construct(){
        $this->middleware('permission:view tiers', ['only' =>['index']]);
    }

     /**
     * Display a listing of the resource.
     */
    public function index()
    {
         //trace
        $data="menue tiers";
        $model="";
        trace($data,$model);     
        return view('tiers');
    }
}
