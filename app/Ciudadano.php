<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudadano extends Model
{
    protected $table = 'ciudadanos';
    protected $primaryKey = 'IdCiudadanos';
    public $timestamps = false;
}
