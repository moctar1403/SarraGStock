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
    public $search_origine=''; // <-- NOUVEAU
    public $date1 = '';
    public $date2 = '';

    public function mount(){
        $this->date1=now()->format('Y-m-d');
        $this->date2=now()->format('Y-m-d');
    }

    public function render()
    {
        // Requête de base
        $query = Facture::leftJoin('clients','factures.fa_client','=','clients.id')
                        ->leftJoin('methodes','factures.fa_type_p','=','methodes.id')
                        ->whereDate('factures.updated_at','>=', $this->date1)
                        ->whereDate('factures.updated_at','<=', $this->date2)
                        ->where('methodes.id','>=','0')
                        ->select('factures.*','clients.cli_nom','methodes.meth_nom');

        // Filtre par origine (Resto / Classique)
        if (!empty($this->search_origine)) {
            $query->where('factures.fa_origine', $this->search_origine);
        }

        // Filtre par méthode
        if (!empty($this->search_methode)) {
            $query->where('methodes.meth_nom','like','%'.$this->search_methode.'%');
        }

        // Filtre par client
        if (!empty($this->search_client)) {
            $query->where(function($q) {
                $q->where('clients.cli_nom','like','%'.$this->search_client.'%')
                  ->orWhere('clients.cli_tel','like','%'.$this->search_client.'%');
            });
        }

        $factures = $query->orderByDesc('factures.updated_at')->paginate(8);
        $total = $factures->sum('fa_tot_apres_remise'); 

        return view('livewire.homs4', compact('factures','total'));
    }
}