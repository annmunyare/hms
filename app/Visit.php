<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Patient;
use App\Bill;

class Visit extends Model
{
    //
    protected $primaryKey = 'visitId';

    public function patient()
    {
        return $this->belongsTo(
        'App\Patient'
        );
    }

    public function bill()
    {
        return $this->hasMany('App\Bill');
    }
}
