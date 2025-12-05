<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frais extends Model
{
    protected $table = "frais";
    protected $primaryKey = "id_frais";
    public $timestamps = false;
}
