<?php

namespace App\Http\Controllers;

use App\helpers;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view fournisseur', ['only' =>['index']]);
        $this->middleware('permission:view paiement', ['only' =>['pindex']]);
        $this->middleware('permission:create fournisseur', ['only' =>['create','store']]);
        $this->middleware('permission:create paiement', ['only' =>['pcreate']]);
        $this->middleware('permission:update fournisseur', ['only'=> ['update','edit']]);
        $this->middleware('permission:delete fournisseur', ['only' =>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data="Liste des fournisseurs";
        $model="App\Models\Fournisseur";
        trace($data,$model);
       
        // $post->visit()->withIp()->withSession()->withUser()->withData(['region' => 'USA']);
        // dump($post->visit()->withSession());
        // dd($post->visit()->withIp()->withSession()->withUser()->withData(['region' => 'USA']));
        // dd($ip);
        // $post=Poste::find(1);
        // if ($post) {
        //     $user_id=$post->visits->first()->present()->user->id;
        //     $user_name=$post->visits->first()->present()->user->name;
        //     $ip=$post->visits->first()->present()->ip;
        //     $session=$request->session()->getId();
        //     $model="App\Models\Fournisseur";
        //     $data="Liste des fournisseurs";
        //     //creation de la trace
        //     $trace=Trace::create([
        //         'user_id'=>$user_id,
        //         'user_name'=>$user_name,
        //         'ip'=>$ip,
        //         'session'=>$session,
        //         'model'=>$model,
        //         'data'=>$data,
        //     ]);
        //     $trace->save();
        // }
        return view('fournisseurs.index');
    }
    public function pindex()
    {
        $data="Liste des fournisseurs";
        $model="App\Models\Fournisseur";
        trace($data,$model);
        return view('fournisseurs.pindex');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data="creation de fournisseur";
        $model="App\Models\Fournisseur";
        trace($data,$model);
        return view('fournisseurs.create');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function pcreate()
    {
        $data="creation de fournisseur";
        $model="App\Models\Fournisseur";
        trace($data,$model);
        return view('fournisseurs.pcreate');
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
    public function show(Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fournisseur $fournisseur)
    {
        $data="edition du fournisseur id ".$fournisseur->id." nom ".$fournisseur->four_nom. " ";
        $model="App\Models\Fournisseur";
        trace($data,$model);
        return view('fournisseurs.edit',compact('fournisseur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fournisseur $fournisseur)
    {
        //
    }
}
