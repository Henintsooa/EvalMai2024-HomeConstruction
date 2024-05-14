<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriquePaiement extends Model
{
    use HasFactory;
    protected $table = 'HistoriquePaiement';
    protected $primaryKey = 'idHistorique';
    protected $fillable = ['datePaiement','payer','idDemandeDevis'];


}
