<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finition extends Model
{
    use HasFactory;
    protected $table = 'Finition';
    protected $primaryKey = 'idFinition';
    protected $fillable = ['nomFinition','pourcentage'];


}
