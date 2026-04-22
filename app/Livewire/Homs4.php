<?php

namespace App\Livewire;

use App\Models\Facture;
use App\Models\Client;
use App\Models\Operat;
use App\Models\Methode;
use Livewire\Component;
use Livewire\WithPagination;

class Homs4 extends Component
{
    use WithPagination;
    public $search_methode = '';
    public $search_client='';
    public $search_article='';
    public $date1 = '';
    public $date2 = '';
    public $message = '';
    public function mount(){
        $first_vente=Facture::orderBy('created_at','asc')->first();
        if ($first_vente) {
            // $this->date1=$first_vente->created_at->format('Y-m-d');
            $this->date1=now()->format('Y-m-d');
        } else {
            $this->date1=now()->format('Y-m-d');
        }
        $this->date2=now()->format('Y-m-d');
    }
    public function render()
    {
        $factures = Facture::leftJoin('clients','factures.fa_client','=','clients.id')
                                    ->leftJoin('methodes','factures.fa_type_p','=','methodes.id')
                                    ->whereDate('factures.updated_at','>=', $this->date1)
                                    ->whereDate('factures.updated_at','<=', $this->date2)
                                    ->where('methodes.id','>=','0')
                                    ->select('factures.fa_tot_apres_remise','factures.fa_type_p','factures.updated_at','clients.cli_nom','methodes.meth_nom')
                                    ->orderByDesc('factures.updated_at')
                                    ->paginate(8);                           
        if (!empty($this->search_methode)) {
            if (empty($this->search_client)) {
                $factures = Facture::leftJoin('clients','factures.fa_client','=','clients.id')
                                    ->leftJoin('methodes','factures.fa_type_p','=','methodes.id')
                                    ->whereDate('factures.updated_at','>=', $this->date1)
                                    ->whereDate('factures.updated_at','<=', $this->date2)
                                    ->where('methodes.meth_nom','like','%'.$this->search_methode.'%')
                                    ->select('factures.fa_tot_apres_remise','factures.fa_type_p','factures.updated_at','clients.cli_nom','methodes.meth_nom')
                                    ->orderByDesc('factures.updated_at')
                                    ->paginate(8);
            }
            else{
                $factures = Facture::leftJoin('clients','factures.fa_client','=','clients.id')
                                    ->leftJoin('methodes','factures.fa_type_p','=','methodes.id')
                                    ->whereDate('factures.updated_at','>=', $this->date1)
                                    ->whereDate('factures.updated_at','<=', $this->date2)
                                    ->where('methodes.meth_nom','like','%'.$this->search_methode.'%')
                                    ->where('clients.cli_nom','like','%'.$this->search_client.'%')
                                    ->select('factures.fa_tot_apres_remise','factures.fa_type_p','factures.updated_at','clients.cli_nom','methodes.meth_nom')
                                    ->orderByDesc('factures.updated_at')
                                    ->paginate(8);
            }
                
        } 
        if (!empty($this->search_client)) {
            if (empty($this->search_methode)) {
                $factures = Facture::leftJoin('clients','factures.fa_client','=','clients.id')
                                    ->leftJoin('methodes','factures.fa_type_p','=','methodes.id')
                                    ->whereDate('factures.updated_at','>=', $this->date1)
                                    ->whereDate('factures.updated_at','<=', $this->date2)
                                    ->where('methodes.id','>=','0')
                                    ->where('clients.cli_nom','like','%'.$this->search_client.'%')
                                    ->OrWhere('clients.cli_tel','like','%'.$this->search_client.'%')
                                    ->select('factures.fa_tot_apres_remise','factures.fa_type_p','factures.updated_at','clients.cli_nom','methodes.meth_nom')
                                    ->orderByDesc('factures.updated_at')
                                    ->paginate(8);   
            }
            else {
                $factures = Facture::leftJoin('clients','factures.fa_client','=','clients.id')
                                    ->leftJoin('methodes','factures.fa_type_p','=','methodes.id')
                                    ->whereDate('factures.updated_at','>=', $this->date1)
                                    ->whereDate('factures.updated_at','<=', $this->date2)
                                    ->where('methodes.meth_nom','like','%'.$this->search_methode.'%')
                                    ->where('clients.cli_nom','like','%'.$this->search_client.'%')
                                    ->OrWhere('clients.cli_tel','like','%'.$this->search_client.'%')
                                    ->select('factures.fa_tot_apres_remise','factures.fa_type_p','factures.updated_at','clients.cli_nom','methodes.meth_nom')
                                    ->orderByDesc('factures.updated_at')
                                    ->paginate(8);   
            }
                
        } 
        if (!empty($this->search_article)) {
                $factures = Facture::leftJoin('clients','factures.fa_client','=','clients.id')
                                    ->leftJoin('methodes','factures.fa_type_p','=','methodes.id')
                                    ->whereDate('factures.updated_at','>=', $this->date1)
                                    ->whereDate('factures.updated_at','<=', $this->date2)
                                    ->where('methodes.id','>=','0')
                                    ->select('factures.fa_tot_apres_remise','factures.fa_type_p','factures.updated_at','clients.cli_nom','methodes.meth_nom')
                                    ->orderByDesc('factures.updated_at')
                                    ->paginate(8);   
        }
        $total= $factures->sum('fa_tot_apres_remise'); 
        return view('livewire.homs4',compact('factures','total'));
    }
}
