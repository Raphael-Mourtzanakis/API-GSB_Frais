<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visiteur extends Model
{
    protected $table = 'visiteur';
    protected $primaryKey = 'id_visiteur';
    public $timestamps = false;
}
