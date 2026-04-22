<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Vente;
use App\Models\Unite;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Methode;
use App\Models\Societe;
use Illuminate\Http\Request;
use App\helpers;

class RemiseController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view remise', ['only' =>['index']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('remises.index');
    }
}
