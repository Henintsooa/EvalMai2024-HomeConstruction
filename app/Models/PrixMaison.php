<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrixMaison extends Model
{
    use HasFactory;
    protected $table = 'prixMaison';
    protected $fillable = ['idDevis','idMaison,idTypeMaison','nomMaison','prixDevisTotal','nbrChambre','nbrCuisine','nbrSalon','nbrToilette'];


}
