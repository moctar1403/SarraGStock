<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;
use App\Models\Entrstock;
use App\Models\Methodevs;
use App\Models\Sortstock;
use Livewire\WithPagination;

class ClisteStock extends Component
{
    use WithPagination;
    public function Actualiserstck(){
        $articles=Article::where('ar_qte','>','0')
                        ->orderBy('id')
                        ->get();
            
        $mvsck1=Methodevs::where('mvs_active','1')->first();                
        if ($mvsck1->mvs_sym=="CUMP") {
            // dd('je suis CUMP');
            if ($articles) {
                foreach ($articles as $key => $value) {
                    $entr[$value->id]=Entrstock::where('article_id','=',$value->id)
                            ->get();
                    $sort[$value->id]=Sortstock::where('article_id','=',$value->id)
                            ->get();
                            // dd($sort);
                }
            }
            //reinitialisation des var
            if ($entr) {
                //reinitialisation des var
                foreach ($entr as $key => $value) {
                    $sum_entr[$key]=0;
                    $sum_sort[$key]=0;
                    $tot_prix_achat_entr[$key]=0;
                    $tot_prix_achat_sort[$key]=0;
                }
                // dd($sum_sort);
                //calcul des sommes des var
                foreach ($entr as $key => $value) {
                    foreach ($value as $k => $v) {
                        $sum_entr[$v->article_id]+=$v->ent_qte;
                        $tot_prix_achat_entr[$v->article_id]+=($v->ent_prix_achat*$v->ent_qte);
                    }
                }
            }
            if ($sort) {
                //calcul des sommes des sorties
                foreach ($sort as $key => $value) {
                    foreach ($value as $k => $v) {
                        $sum_sort[$v->article_id]+=$v->sor_qte;
                        $tot_prix_achat_sort[$v->article_id]+=($v->sor_prix_achat*$v->sor_qte);
                    }
                }
            }
            if ($entr) {
                //calcul avg
                foreach ($tot_prix_achat_entr as $key => $value) {
                    $avg_prix_achat[$key]=($tot_prix_achat_entr[$key]-$tot_prix_achat_sort[$key])/($sum_entr[$key]-$sum_sort[$key]);
                }
                // dd($avg_prix_achat);
            }
            //actualisation des prix d'achats
            foreach ($articles as $key => $value) {
                if($avg_prix_achat[$value->id]){
                    $quer=Article::where('id',$value->id)->update(['ar_prix_achat'=> $avg_prix_achat[$value->id]]);
                }
            }
        }
        if (($mvsck1->mvs_sym)=="DEPS") {
            // dd('je suis deps');
            if ($articles) {
                //selectionner les anciens prix achat
                foreach ($articles as $key => $value) {
                    $entr[$key]=Entrstock::where('article_id','=',$value->id)
                                            ->where('ent_qte','>','0')
                                            ->orderBy('id','ASC')
                                            ->first();
                }
                // dd($entr);
                //actualisation des prix
                foreach ($articles as $key => $value) {
                    foreach ($entr as $k => $v) {
                        if($v->article_id==$value->id){
                            $quer=Article::where('id',$value->id)->update(['ar_prix_achat'=>$v->ent_prix_achat]);
                        }
                    }
                }   
            }
        }
        if (($mvsck1->mvs_sym)=="PEPS") {
            // dd('je suis peps');
            if ($articles) {
                foreach ($articles as $key => $value) {
                    $entr[$key]=Entrstock::where('article_id','=',$value->id)
                                            ->where('ent_qte','>','0')
                                            ->orderBy('id','DESC')
                                            ->first();
                }
                //actualisation des prix
                foreach ($articles as $key => $value) {
                    foreach ($entr as $k => $v) {
                        if($v->article_id==$value->id){
                            $quer=Article::where('id',$value->id)->update(['ar_prix_achat'=>$v->ent_prix_achat]);
                        }
                    }
                }   
            }    
        }
    }
    public function toggleStatus(Methodevs $mvsck){
        $query=Methodevs::where('mvs_active','1')->update(['mvs_active'=>'0']);
        $mvsck->mvs_active='1';
        $mvsck->save();
        $this->Actualiserstck();
        $this->render();
    }
    public function render()
    {
        $mvs = Methodevs::paginate(8);
        return view('livewire.cliste-stock',compact('mvs'));
    }
}