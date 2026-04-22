<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\Methode;
use Illuminate\Http\Request;
use App\helpers;

class MethodesController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view methode', ['only' =>['index']]);
        $this->middleware('permission:create methode', ['only' =>['create','store']]);
        $this->middleware('permission:update methode', ['only'=> ['update','edit']]);
        $this->middleware('permission:delete methode', ['only' =>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('methodes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('methodes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        Request::macro('checkbox', function ($key, $checked = 1, $notChecked = 0) {
            return $this->input($key) ? $checked : $notChecked;
       });
        $request->validate([
            'meth_nom'=>[
                'required',
                'string',
                'min:4',
                'unique:methodes,meth_nom'
            ],
            'meth_tel'=>'required|string|min:8|max:8',
        ]);
        Methode::create([
            'meth_nom'=>$request->meth_nom,
            'meth_tel'=>$request->meth_tel,
            'meth_active'=>$request->checkbox('meth_active', '1', '0'),
        ]);
        return redirect('methodes')->with('succes',__('Méthode de paiement créée avec succès'));
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
    public function edit(Methode $methode)
    {
        return view('methodes.edit',compact('methode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Methode $methode)
    {
        //verification si la methode active a une vente enregistrée
        if ($methode->meth_active=='1') {
            if ($request->meth_active=='0') {
                $test_vente=Vente::where('type_p','=',$methode->id)->first();
                if ($test_vente) {
                    return redirect('methodes')->with('danger','Modification annulée,Méthode ne peut pas être désactivée car elle a une vente');
                }
            }
            
        }
        
    //     Request::macro('checkbox', function ($key, $checked = 1, $notChecked = 0) {
    //         return $this->input($key) ? $checked : $notChecked;
    //    });
        //dd($request->checkbox('meth_active', '1', '0'));
        $request->validate([
            'meth_nom'=>[
                'required',
                'string',
                'min:4',
                'unique:methodes,meth_nom,'.$methode->id
            ],
            'meth_tel'=>'required|string|min:8|max:8',
        ]);
        $methode->update([
                'meth_nom'=>$request->meth_nom,
                'meth_tel'=>$request->meth_tel,
                'meth_active'=>$request->meth_active,
        ]);
            
        return redirect('methodes')->with('succes','Méthode de paiement mise à jour avec succès');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
