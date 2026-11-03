<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
        protected $fillable = [
        'fa_num',
        'fa_client',
        'fa_type_p',
        'fa_origine', // <-- NOUVEAU
        'fa_tot',
        'fa_t_remise',
        'fa_m_remise',
        'fa_tot_apres_remise',
    ];
    use HasFactory;
}
