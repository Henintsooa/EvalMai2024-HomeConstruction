<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'Client';
    protected $primaryKey = 'idClient';
    protected $fillable = ['numero'];


}
