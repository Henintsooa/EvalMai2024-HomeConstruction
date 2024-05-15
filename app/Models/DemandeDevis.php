<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeDevis extends Model
{
    use HasFactory;
    protected $table = 'demandeDevis';
    protected $primaryKey = 'idDemandeDevis';
    protected $fillable = ['idTypeMaison','idClient','idFinition','dateDebut','dateFin','dateCreation','lieu'];


}
