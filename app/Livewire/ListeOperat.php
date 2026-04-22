<?php

namespace App\Livewire;

use App\Models\Vente;
use App\Models\Operat;
use App\Models\Methode;
use Livewire\Component;
use Livewire\WithPagination;

class ListeOperat extends Component
{
    use WithPagination;
    public $search = '';
    public $search2='';
    public $search3='';
    public $date1 = '';
    public $date2 = '';
    public $message = '';
    public $total = 0;
    public $total2 = 0;
    public function mount(){
        $first_vente=Vente::orderBy('id','asc')->first();
        if ($first_vente) {
            $this->date1=$first_vente->created_at->format('Y-m-d');
        } else {
            $this->date1=now()->format('Y-m-d');
        }
        // $this->date1=now()->format('Y-m-d');
        $this->date2=now()->format('Y-m-d');
    }
    public function render()
    {
        $operats = Operat::leftJoin('methodes','operats.operat_meth_id','=','methodes.id')
                            ->select('operats.*','methodes.meth_nom')
                            ->where('operats.id','>','0')
                            ->where('methodes.id','>','0')
                            ->whereDate('operats.created_at','>=', $this->date1)
                            ->whereDate('operats.created_at','<=', $this->date2)
                            ->paginate(10);
        $this->total = Operat::whereDate('operats.created_at','>=', $this->date1)
                            ->whereDate('operats.created_at','<=', $this->date2)
                            ->sum('operat_montant')
                            ;
        if ($this->total) {
                $this->total2 =$this->total; 
            }                       
        if (!empty($this->search)) {
            //recherches des ventes
            if (str_contains($this->search, 'vente') or str_contains($this->search, 'Vente')) {
                $operats = Operat::leftJoin('methodes','operats.operat_meth_id','=','methodes.id')
                            ->select('operats.*','methodes.meth_nom')
                            ->where('operat_vent_id','>','0')
                            ->where('methodes.id','>','0')
                            ->whereDate('operats.created_at','>=', $this->date1)
                            ->whereDate('operats.created_at','<=', $this->date2)
                            ->paginate(10);
            }
            //recherches des transferts
            if (str_contains($this->search, 'transfert') or str_contains($this->search, 'Transfert')) {
                $operats = Operat::leftJoin('methodes','operats.operat_meth_id','=','methodes.id')
                            ->select('operats.*','methodes.meth_nom')
                            ->where('operat_tr_id','>','0')
                            ->where('methodes.id','>','0')
                            ->whereDate('operats.created_at','>=', $this->date1)
                            ->whereDate('operats.created_at','<=', $this->date2)
                            ->paginate(10);
            }
            $this->search2=Methode::where('meth_nom','like','%'.$this->search.'%')->first();
            //$this->search3=Methode::where('meth_nom','like','%'.$this->search.'%')->first();
            if ($this->search2) {
                $operats = Operat::leftJoin('methodes','operats.operat_meth_id','=','methodes.id')
                            ->select('operats.*','methodes.meth_nom')
                            ->where('operats.id','>','0')
                            ->whereDate('operats.created_at','>=', $this->date1)
                            ->whereDate('operats.created_at','<=', $this->date2)
                            ->where('operats.operat_meth_id',$this->search2->id)
                            ->paginate(10);

                $this->total = Operat::whereDate('operats.created_at','>=', $this->date1)
                            ->whereDate('operats.created_at','<=', $this->date2)
                            ->where('operats.operat_meth_id',$this->search2->id)
                            ->sum('operat_montant')
                            ;  
                            if ($this->total) {
                                $this->total2 =$this->total; 
                            }            
            }

            
        } 
        return view('livewire.liste-operat',compact('operats'));
    }
}
