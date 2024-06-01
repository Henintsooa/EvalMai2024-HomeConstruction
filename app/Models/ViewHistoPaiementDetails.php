<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewHistoPaiementDetails extends Model
{
    use HasFactory;
    protected $table = 'ViewHistoPaiementDetails';
    protected $fillable = ['idDemandeDevis','datePaiement','payer','idDemandeDevis','refDevis','refPaiement'];


}
