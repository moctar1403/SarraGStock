<?php

namespace App\Models;

use App\Models\Article;
use App\Models\Client;
use App\Models\Facture;
use Coderflex\Laravisit\Concerns\CanVisit;
use Coderflex\Laravisit\Concerns\HasVisits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vente extends Model implements CanVisit
{
    use HasFactory;
    use HasVisits;
    protected $guarded = [''];
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    } 
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    } 
        public function facture()
    {
        return $this->belongsTo(Facture::class, 'facture_id');
    }
}
