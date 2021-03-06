<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    //
    protected $guarded = ['id'];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }
}
