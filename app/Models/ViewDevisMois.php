<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewDevisMois extends Model
{
    use HasFactory;
    protected $table = 'ViewDevisAnneeMois';
    // protected $fillable = ['mois','montantDevis'];
    protected $fillable = ['annee','mois','montantDevis'];


}
