<?php
namespace App\Http\Controllers;
use App\Models\Trace;
use App\Models\Monnaie;
use App\Models\Societe;
use Illuminate\Http\Request;
class ConfigController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view societe', ['only' =>['societe']]);
        $this->middleware('permission:view configurations', ['only' =>['index']]);
        $this->middleware('permission:view monnaie', ['only' =>['monnaie']]);
        $this->middleware('permission:view unite', ['only' =>['unite']]);
        $this->middleware('permission:view traces', ['only' =>['traces']]);
        $this->middleware('permission:config stock', ['only' =>['stock']]);
        $this->middleware('permission:create societe', ['only' =>['createsoc']]);
        $this->middleware('permission:create monnaie', ['only' =>['createmonnaie']]);
        $this->middleware('permission:update societe', ['only'=> ['editsoc']]);
        $this->middleware('permission:delete societe', ['only' =>['destroy']]);
        $this->middleware('permission:delete traces', ['only' =>['destroytraces']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd('je suis ici nnn');
         //trace
         $data="menue configuration";
         $model="";
         trace($data,$model);     
        return view('configs.index');
    }
    public function societe()
    {
        //trace
        $data="info societe";
        $model="App\Models\Societe";
        trace($data,$model);     
        return view('configs.societe.societe');
    }
    public function monnaie()
    {
         //trace
         $data="info monnaie";
         $model="App\Models\Monnaie";
         trace($data,$model);     
        return view('configs.monnaie.index');
    }
    public function unite()
    {
         //trace
         $data="info unite";
         $model="App\Models\Unite";
         trace($data,$model);     
        return view('configs.unite.index');
    }
    public function langue()
    {
         //trace
         $data="info langue";
         $model="App\Models\Unite";
         trace($data,$model);     
        return view('configs.langue');
    }
    public function stock()
    {
         //trace
         $data="info stock";
         $model="App\Models\Unite";
         trace($data,$model);     
        return view('configs.stock');
    }
    public function traces()
    {
         //trace
         $data="voir les traces";
         $model="App\Models\Trace";
         trace($data,$model);     
        return view('configs.traces.index');
    }
    public function destroytraces()
    {
        $traces=Trace::all();
        foreach ($traces as $key => $value) {
            $value->delete();
        }
         //trace
         $data="suppression des traces";
         $model="App\Models\Trace";
         trace($data,$model);     
        return redirect(route('configs.traces'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function createsoc()
    {
         //trace
         $data="création des infos de la societe";
         $model="App\Models\Societe";
         trace($data,$model);     
        return view('configs.societe.create');
    }
    public function createmonnaie()
    {
         //trace
         $data="création infos monnaie";
         $model="App\Models\Monnaie";
         trace($data,$model);     
        return view('configs.monnaie.create');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function editsoc(Societe $societe)
    {
         //trace
         $data="editer societe";
         $model="App\Models\Societe";
         trace($data,$model);     
        return view('configs.societe.edit',compact('societe'));
    }
    /**
     * Display a listing of the resource.
     */
    public function lrole()
    {
        return view('configs.lrole');
    }
    /**
     * Display a listing of the resource.
     */
    public function lpermission()
    {
        return view('configs.lpermission');
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
    public function editmonnaie(Monnaie $monnaie)
    {
         //trace
         $data="editer monnaie";
         $model="App\Models\Monaie";
         trace($data,$model);     
        return view('configs.monnaie.edit',compact('monnaie'));
        // dd($monnaie);
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
