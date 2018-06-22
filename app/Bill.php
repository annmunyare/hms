<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Visit;
use App\Service;
class Bill extends Model
{
    protected $primaryKey = 'billId';
    //
    public function visit()
    {
        return $this->belongsTo(
        'App\Visit'
        );
    }

    public function service()
    {
        return $this->belongsTo(
        'App\Service'
        );
    }
}
