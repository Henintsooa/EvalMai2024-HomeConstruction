<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeMaison extends Model
{
    use HasFactory;
    protected $table = 'TypeMaison';
    protected $primaryKey = 'idTypeMaison';
    protected $fillable = ['nomMaison','duree'];


}
