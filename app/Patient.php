<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Visit;


class Patient extends Model
{
    //
    protected $primaryKey = 'patientId';
    public $full_name;

    public function visit()
    {
        return $this->hasMany('App\Visit');
    }
    //db testing
    
    public function setFirstName($firstName){
        $this->full_name = $firstName;
        }
        public function getFirstName(){
        return 'Mary';
        }
}
