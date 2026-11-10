<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory;

    protected $fillable = [
        'ch_libelle',
        'ch_montant',
        'ch_date',
        'user_id',
        'ch_observations',
        // ❌ 'methode_id' a été retiré
    ];

    // Relation avec l'utilisateur qui a saisi la charge
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ❌ La relation methode() a été supprimée
}