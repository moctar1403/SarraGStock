<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vente;
use App\Models\Article;
use App\Models\Client;
use App\Models\Sortstock;
use Illuminate\Support\Facades\Auth;

class CreateVentegg extends Component
{
    public $article_id;
    public $quantite_dispo;
    public $client_id=0;
    public $ve_quantite;
    public $ve_prix;
    public $ve_prix_tot;
    public $art;
    public $orderArticles=[];
    public $allArticles=[];
    public $articlesList=[];
    public $clientsList=[];
    public function mount(){
        $this->articlesList=Article::all();
        $this->clientsList=Client::all();
        $this->allArticles=Article::all();
        $this->orderArticles=[
            ['article_id'=>'','ve_client'=>'','ve_quantite'=>1]
        ];
    }
    public function addProduct(){
        dd("je suis la");
    }
    public function store(Vente $vente)
    {
        $this->validate([
            'article_id' => 'required',
            've_quantite' => 'integer|required|lte:quantite_dispo|min:1',
            've_prix' => 'numeric|required',
            've_prix_tot' => 'numeric|required',
        ]);
        try {
            $vente->article_id = $this->article_id;
            $vente->ve_client = $this->client_id;
            $vente->ve_quantite = $this->ve_quantite;
            $vente->ve_prix_achat = $this->art->ar_prix_achat;
            $vente->ve_prix_vente = $this->ve_prix;
            $vente->ve_prix_tot = $this->ve_prix_tot;
            $vente->ve_saisi_par = Auth::user()->id;
            
            //mise à jour de la quantité dans la table article
            $this->art->ar_qte-=$this->ve_quantite;
            $this->art->save();
            $vente->save();
            //mise à jour de la sortie dans la table sortstocks
            $sorti=Sortstock::create([
                'article_id'=>$vente->article_id,
                'sor_vente'=>$vente->id,
                'sor_qte'=>$vente->ve_quantite,
                'sor_prix_achat'=>$vente->ve_prix_achat,
                'sor_prix_vente'=>$vente->ve_prix_vente,
                'sor_date'=>$vente->created_at,
                'sor_motif'=>'vente',
                'sor_observations'=>'vente',
                'sor_saisi_par'=>$vente->ve_saisi_par,
            ]);
            return redirect()->route('ventes.index')->with('success', 'La vente est enregistrée');
        } catch (Exception $e) {
            //Sera pris en compte si on a un problème
        }
    }

    public function render()
    {
        $this->art=Article::where('id',$this->article_id)->first();
        if($this->art){
            $this->quantite_dispo=$this->art->ar_qte;
            $this->ve_prix=$this->art->ar_prix_vente;
            $this->ve_prix_tot=(float)$this->ve_prix*(float)$this->ve_quantite;
        }else{
            $this->quantite_dispo=0;
            $this->ve_prix=0;
            $this->ve_prix_tot=(float)$this->ve_prix*(float)$this->ve_quantite;
        }
        
        return view('livewire.create-ventegg');
    }
}
