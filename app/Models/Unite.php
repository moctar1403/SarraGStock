<?php

namespace App\Models;

use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unite extends Model
{
    use HasFactory;
    protected $guarded = [''];
    // public function articles(): HasMany
    // {
    //     return $this->hasMany(Article::class,'foreign_key', 'ar_unite');
    // }
   
}
