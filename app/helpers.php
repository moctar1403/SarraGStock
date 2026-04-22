<?php

use App\Models\Poste;
use App\Models\Trace;
use App\Models\Article;
// use App\Models\Societe;
use App\Models\Entrstock;
use App\Models\Methodevs;
use App\Models\Sortstock;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;
if (! function_exists('trace')) {
    function trace($data,$model)
    {
        $request=request();
        // dd($request->session()->getId());
        $session=(string)$request->session()->getId();
        // $session="";
        $user=Auth::user();
        $post=Poste::find(1);
        if ($post) {
            $user_id=$user->id;
            $user_name=$user->name;
            $ip=$post->visits->first()->present()->ip;
            //creation de la trace
            $trace=Trace::create([
                'user_id'=>$user_id,
                'user_name'=>$user_name,
                'ip'=>$ip,
                'session'=>$session,
                'model'=>$model,
                'data'=>$data,
            ]);
            $trace->save();
        }
    }
}
if (! function_exists('afficher_montant')) {
    function afficher_montant($data)
    {
        if (app()->getLocale() == 'ar') {
            return number_format($data, 2, ',', '');
        }
        else {
            return number_format($data, 2, ',', ' ');
        } 
    }
}
if (! function_exists('Actualiser_PAA')) {
    function Actualiser_PAA($art_id)
    {
       //cette fonction va actualiser la valeur du prix achat de l'ensembles des articles
        $avg_prix_achat=0;
        $sum_qte=0;
        $sum_qte_entr=0;
        $sum_qte_sort=0;
        $sum_total=0;
        $sum_total_entr=0;
        $sum_total_sort=0;
        $mvsck=Methodevs::where('mvs_active','1')->first();
        $article=Article::where('ar_qte','>','0')
                        ->where('id',$art_id)
                        ->first();
        if ($mvsck->mvs_sym=="CUMP") {
            //actualisation des prix d'achats
            if ($article) {
                $entr=Entrstock::where('article_id','=',$article->id)
                            ->get();
                $sort=Sortstock::where('article_id','=',$article->id)
                            ->get();
                if ($sort) {
                    foreach ($sort as $key => $value) {
                        $sum_total_sort=$sum_total_sort+($value->sor_qte*$value->sor_prix_achat); 
                        $sum_qte_sort=$sum_qte_sort+$value->sor_qte; 
                    }
                }            
                if ($entr) {
                    foreach ($entr as $key => $value) {
                        $sum_total_entr=$sum_total_entr+($value->ent_qte*$value->ent_prix_achat); 
                        $sum_qte_entr=$sum_qte_entr+$value->ent_qte; 
                    }
                }
                $sum_qte=$sum_qte_entr-$sum_qte_sort;
                $sum_total=$sum_total_entr-$sum_total_sort;
                if ($sum_qte>0) {
                    $avg_prix_achat=$sum_total/$sum_qte;
                    $quer=Article::where('id',$article->id)->update(['ar_prix_achat'=> $avg_prix_achat]);
                }
            }
        }
        if ($mvsck->mvs_sym=="DEPS") {
            if ($article) {
                $entr=Entrstock::where('article_id','=',$article->id)
                                ->where('ent_qte','>','0')
                                ->orderBy('created_at','ASC')
                                ->first();
                if ($entr) {
                    $avg_prix_achat=$entr->ent_prix_achat;
                    $quer=Article::where('id',$article->id)->update(['ar_prix_achat'=> $avg_prix_achat]);
                }
            }
        }
        if ($mvsck->mvs_sym=="PEPS") {
            //actualisation des prix d'achats
            if ($article) {
                $entr=Entrstock::where('article_id','=',$article->id)
                                ->where('ent_qte','>','0')
                                ->orderBy('created_at','DESC')
                                ->first();
                if ($entr) {
                    $avg_prix_achat=$entr->ent_prix_achat;
                    $quer=Article::where('id',$article->id)->update(['ar_prix_achat'=> $avg_prix_achat]);
                }
            }
        }
    }
}
if (! function_exists('Actualiser_PAA2')) {
    function Actualiser_PAA2($art_id,$ent_qte,$ent_prix_achat,$ent_prix_vente)
    {
       //cette fonction va actualiser la valeur du prix achat de l'ensembles des articles
        $avg_prix_achat=0;
        $sum_qte=0;
        $sum_total=0;
        $sum1=0;
        $sum2=0;
        $mvsck=Methodevs::where('mvs_active','1')->first();
        $article=Article::where('id',$art_id)
                        ->first();
        if ($mvsck->mvs_sym=="CUMP") {
            //actualisation des prix d'achats
            if ($article) {
                $sum_qte=$article->ar_qte+$ent_qte;
                $sum1=$article->ar_prix_achat*$article->ar_qte;
                $sum2=$ent_prix_achat*$ent_qte;
                $sum_total=$sum1+$sum2;
                if ($sum_qte>0) {
                    $avg_prix_achat=$sum_total/$sum_qte;
                    $quer=Article::where('id',$article->id)
                                    ->update([
                                        'ar_qte'=> $sum_qte,
                                        'ar_prix_achat'=> $avg_prix_achat,
                                        'ar_prix_vente'=> $ent_prix_vente
                                    ]);
                }
            }
        }
        if ($mvsck->mvs_sym=="DEPS") {
            if ($article) {
                $entr=Entrstock::where('article_id','=',$article->id)
                                ->where('ent_qte','>','0')
                                ->orderBy('created_at','ASC')
                                ->first();
                if ($entr) {
                    $avg_prix_achat=$entr->ent_prix_achat;
                    $quer=Article::where('id',$article->id)->update(['ar_prix_achat'=> $avg_prix_achat]);
                }
            }
        }
        if ($mvsck->mvs_sym=="PEPS") {
            //actualisation des prix d'achats
            if ($article) {
                $entr=Entrstock::where('article_id','=',$article->id)
                                ->where('ent_qte','>','0')
                                ->orderBy('created_at','DESC')
                                ->first();
                if ($entr) {
                    $avg_prix_achat=$entr->ent_prix_achat;
                    $quer=Article::where('id',$article->id)->update(['ar_prix_achat'=> $avg_prix_achat]);
                }
            }
        }
    }
}
if (! function_exists('annuler_entree')) {
    function annuler_entree($art_id,$ent_qte,$ent_prix_achat)
    {
        //cette fonction va annuler l'entree en stock
        $mvsck=Methodevs::where('mvs_active','1')->first();
        $article=Article::where('id',$art_id)
                        ->first();
        $ancien_ar_qte=$article->ar_qte;
        $ancien_ar_prix_achat=$article->ar_prix_achat;
        $somme_ancien=$ancien_ar_qte*$ancien_ar_prix_achat;
        $somme_entree=$ent_qte*$ent_prix_achat;                 
        $nouveau_somme=$somme_ancien-$somme_entree;
        $nouveau_ar_qte=$ancien_ar_qte-$ent_qte;
        if ($mvsck->mvs_sym=="CUMP") {
            $entr=Entrstock::where('article_id','=',$article->id)
                                ->orderBy('created_at','ASC')
                                ->get();
            if (count($entr)>1) {
                if ($nouveau_ar_qte>0) {
                    $nouveau_ar_prix_achat=$nouveau_somme/$nouveau_ar_qte;
                }
                else {
                    $nouveau_ar_prix_achat=$ancien_ar_prix_achat;
                }
            }
            else {
                if (count($entr)==1) {
                    $nouveau_ar_prix_achat=$entr->first()->ent_prix_achat;
                }
                if (count($entr)==0) {
                    $nouveau_ar_prix_achat=0;
                }
                    
            }                    
            
        }
        if ($mvsck->mvs_sym=="DEPS") {
            $entr=Entrstock::where('article_id','=',$article->id)
                                ->orderBy('created_at','ASC')
                                ->first();
            if ($entr) {
                $nouveau_ar_prix_achat=$entr->ent_prix_achat;
            }                    
        }
        if ($mvsck->mvs_sym=="PEPS") {
            $entr=Entrstock::where('article_id','=',$article->id)
                                ->orderBy('created_at','DESC')
                                ->first();
            if ($entr) {
                $nouveau_ar_prix_achat=$entr->ent_prix_achat;
            }      
        }
        $article->ar_qte=$nouveau_ar_qte;
        if ($nouveau_ar_prix_achat) {
            $article->ar_prix_achat=$nouveau_ar_prix_achat;
        }
        $article->save();
        
    }
}
if (! function_exists('test_super_admin_role')) {
    function test_super_admin_role($user)
    {
        //fonction retourne nombre sup ou egal à 1 si user est super-admin et 0 si non
        $couner=0;
        foreach ($user->getRoleNames() as $rolename) {
            if ($rolename=="super-admin")
                     $couner++;
        }
        return $couner;
    }
}
if (! function_exists('test_admin_role')) {
    function test_admin_role($user)
    {
        //fonction retourne nombre sup ou egal à 1 si user est super-admin et 0 si non
        $couner=0;
        foreach ($user->getRoleNames() as $rolename) {
            if ($rolename=="admin")
                     $couner++;
        }
        return $couner;
    }
}
if (! function_exists('delete_item')) {
    function delete_item($item)
    {
        //fonction 
        $couner=0;
        foreach ($user->getRoleNames() as $rolename) {
            if ($rolename=="admin")
                     $couner++;
        }
        return $couner;
    }
}
if (! function_exists('add_image_societe')) {
    function add_image_societe()
    {
        $societe = \App\Models\Societe::first();
        
        if ($societe) {
            // Avec la nouvelle logique, le chemin est directement 'uploads/societes/filename.ext'
            $path = $societe->soc_logo;
            
            // Vérifier si le fichier existe directement dans le dossier public
            $logoExists = $path && file_exists(public_path($path));
            
            $array = [
                1 => $logoExists,  // true/false si le logo existe
                2 => $societe,      // l'objet société complet
            ];
        } else {
            $array = [
                1 => false,
                2 => null,
            ];
        }
        
        return $array;
    }
}
if (! function_exists('image_empty')) {
    function image_empty()
    {
        return asset('images/empty.svg');
    }
}

if (!function_exists('format_number')) {
    /**
     * Formate un nombre avec espace comme séparateur de milliers et virgule pour les décimales
     * Affiche les décimales uniquement si le nombre n'est pas entier
     * 
     * @param float|int $number Le nombre à formater
     * @param int $decimals Nombre de décimales maximum (défaut: 2)
     * @return string Le nombre formaté
     */
    function format_number($number, $decimals = 2)
    {
        // Vérifie si le nombre est entier
        if (is_int($number) || $number == floor($number)) {
            $formatted = number_format($number, 0, ',', ' ');
        } else {
            $formatted = number_format($number, $decimals, ',', ' ');
        }

        if (app()->getLocale() == 'ar') {
            return '<bdi>' . $formatted . '</bdi>';
        }

        return $formatted;
    }
}

