<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_ouverture',
        'montant_initial',
        'date_cloture',
        'montant_final_reel',
        'montant_theorique',
        'ecart',
        'statut',
    ];

    // Relation avec l'utilisateur (le caissier)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}