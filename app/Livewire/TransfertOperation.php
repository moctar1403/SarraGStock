<?php

namespace App\Livewire;

use App\Models\Operat;
use App\Models\Methode;
use Livewire\Component;
use App\Models\Transfert;

class TransfertOperation extends Component
{
    public $operation;
    public $meth_nom;
    public $meth_solder;
    public $montant;
    public $montant_global;
    public $frais;
    public $methodesList;
    public $meth_selected;
    public $meth_selected2;
    public function mount()
    {
        $this->methodesList=Methode::where('meth_active','>',0)
                                    ->where('meth_nom','not like','credit')
                                    ->where('id','!=',$this->operation->id)
                                    ->get();
        //$this->meth_selected=Methode::where('id','!=',$this->operation->id)->get();
        $this->meth_nom = $this->operation->meth_nom;
        $this->meth_solder = $this->operation->meth_solder;
        $this->frais = 0;
    }
    public function store(Methode $operation)
    {
        $this->montant_global=$this->meth_solder-$this->frais;
        //dd($this->montant_global);
        $this->validate([
            // 'meth_nom' => 'string|required',
            'meth_solder' => 'string|required|min:1',
            'meth_selected' => 'string|required',
            'montant' => "numeric|required|min:1|lte:{$this->montant_global}",
            'frais' => 'numeric|required|gte:0|lte:montant',
        ]);
        try {
            $this->meth_selected2=Methode::where('id',$this->meth_selected)
                                    ->first();
            $this->meth_selected2->update([
                'meth_solder'=>$this->meth_selected2->meth_solder+$this->montant,
            ]);
            $this->operation->update([
                'meth_solder'=>$this->operation->meth_solder-$this->montant-$this->frais,
            ]);
            //actualisation de la table transferts
            $transert=Transfert::create([
                'tr_meth_env_id'=>$this->operation->id,
                'tr_meth_env_nom'=>$this->operation->meth_nom,
                'tr_meth_ben_id'=>$this->meth_selected2->id,
                'tr_meth_ben_nom'=>$this->meth_selected2->meth_nom,
                'tr_montant'=>$this->montant,
                'tr_frais'=>$this->frais,
            ]);
            $transert->save();
            //Mise a jour de la table Operate
            $operat1=Operat::create([
                'operat_meth_id'=>$transert->tr_meth_env_id,
                'operat_vent_id'=>0,
                'operat_tr_id'=>$transert->id,
                'operat_montant'=>($transert->tr_montant+$transert->tr_frais)*-1,
            ]);
            $operat1->save();
            $operat2=Operat::create([
                'operat_meth_id'=>$transert->tr_meth_ben_id,
                'operat_vent_id'=>0,
                'operat_tr_id'=>$transert->id,
                'operat_montant'=>($transert->tr_montant),
            ]);
            $operat2->save();
        return redirect()->route('operation.ltransfert')->with('success', 'Transfert effectué avec succès');
        } catch (Exception $e) {
            //Sera pris en compte si on a un problème
        }
    }

    public function render()
    {
        return view('livewire.transfert-operation');
    }
}
