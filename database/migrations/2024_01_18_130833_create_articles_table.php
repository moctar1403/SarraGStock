<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Article;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('ar_reference',50);
            $table->string('ar_lib',50);
            $table->string('ar_description',50);
            $table->string('ar_codebarre',50);
            $table->integer('ar_qte')->default('0');
            $table->integer('ar_qte_mini')->default('0');
            $table->decimal('ar_prix_achat',10,2);
            $table->decimal('ar_prix_vente',10,2);
            $table->string('ar_saisi_par',50);
            $table->timestamps();
        });
        $data =  array(
            [
                'ar_reference' => 'rn',
                'ar_lib' => 'Anonyme',
                'ar_description' => 'Anonyme',
                'ar_codebarre' => 'cbn',
                'ar_qte' => '0',
                'ar_qte_mini' => '0',
                'ar_prix_achat' => '0',
                'ar_prix_vente' => '0',
                'ar_saisi_par' => '0',
            ],
        );
        foreach ($data as $datum){
            $article = new Article(); //
            $article->ar_reference =$datum['ar_reference'];
            $article->ar_lib =$datum['ar_lib'];
            $article->ar_description =$datum['ar_description'];
            $article->ar_codebarre =$datum['ar_codebarre'];
            $article->ar_qte =$datum['ar_qte'];
            $article->ar_qte_mini =$datum['ar_qte_mini'];
            $article->ar_prix_achat =$datum['ar_prix_achat'];
            $article->ar_prix_vente =$datum['ar_prix_vente'];
            $article->ar_saisi_par =$datum['ar_saisi_par'];
            $article->save();
        }
        $art=Article::where('id','=','1')->first();
        $art->id ='0';
        $art->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
