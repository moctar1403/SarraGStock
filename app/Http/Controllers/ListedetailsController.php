<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListedetailsController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view listedetails', ['only' =>['index']]); 
    }
    public $model="App\Models\Listedetails";
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data="Liste des details articles";
        trace($data,$this->model);
        return view('listedetails.index');
    }
    public function operation()
    {
        $data="Liste des opérations de details articles";
        trace($data,$this->model);
        return view('listedetails.operation');
    }
}
