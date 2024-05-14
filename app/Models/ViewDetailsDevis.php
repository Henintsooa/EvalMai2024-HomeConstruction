<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewDetailsDevis extends Model
{
    use HasFactory;
    protected $table = 'ViewDetailsDevis';
    protected $fillable = ['idDevis','idClient','numero','designation','unite','quantite','pu','prixTotal','prixPourcentage','dateDevis'];

}
