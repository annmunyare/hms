<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupController extends Controller
{
    //
    public function index(){
        $config = array(
           'applicationId' =>env("KAIZALA_CONNECTOR_ID"),
            'applicationSecret' => env("KAIZALA_CONNECTOR_SECRET"),
           'mobileNumber' =>env("KAIZALA_MOBILE_NO")
        );
        return view('group.group', $config);
        //return  $config;
    }
}
