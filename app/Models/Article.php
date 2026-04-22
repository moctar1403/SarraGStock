<?php

namespace App\Models;

use App\Models\Unite;
use App\Models\Vente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;
    protected $guarded = [''];
    public function ventes(): HasMany
    {
        return $this->hasMany(Vente::class);
    }
}
