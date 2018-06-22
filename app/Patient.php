<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Visit;


class Patient extends Model
{
    //
    protected $primaryKey = 'patientId';

    public function visit()
    {
        return $this->hasMany('App\Visit');
    }
}
