<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescrire extends Model
{
    protected $table = "prescrire";
    protected $primaryKey = "id_famille";
    public $timestamps = false;
}
