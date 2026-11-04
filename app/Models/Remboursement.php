<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remboursement extends Model
{
    use HasFactory;
    protected $guarded = [''];
        public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function methode()
    {
        return $this->belongsTo(Methode::class, 'rem_type_p');
    }
}
