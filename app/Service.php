<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bill;


class Service extends Model
{
    //
    protected $primaryKey = 'serviceId';

    public function bill()
    {
        return $this->hasMany('App\Bill');
    }
}
