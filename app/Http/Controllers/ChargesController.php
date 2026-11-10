<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use Illuminate\Http\Request;
use App\helpers;

class ChargesController extends Controller
{
    public $model="App\Models\Charge";
    public function __construct(){
        $this->middleware('permission:view charges', ['only' =>['index']]); 
        // $this->middleware('permission:create charge', ['only' =>['create']]);
    }
    public function index()
    {
        $data="Liste des charges";
        // $model="App\Models\Article";
        trace($data,$this->model);
        return view('charges.index');
    }
}
