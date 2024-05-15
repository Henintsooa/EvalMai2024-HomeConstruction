<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travaux extends Model
{
    use HasFactory;
    protected $table = 'Travaux';
    protected $primaryKey = 'idTravaux';
    protected $fillable = ['designation','numero','pu','unite'];


}
