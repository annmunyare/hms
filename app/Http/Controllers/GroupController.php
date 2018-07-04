<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupController extends Controller
{
    //
    public function index()
    {
        $config = array(
           'applicationId' =>env("KAIZALA_CONNECTOR_ID"),
            'applicationSecret' => env("KAIZALA_CONNECTOR_SECRET"),
           'mobileNumber' =>env("KAIZALA_MOBILE_NO")
        );
        return view('group.group', $config);
        //return  $config;
    }
    public function filter(Request $request)
    {
        $text = file_get_contents("https://nanyukiaf-hospital-ann.azurewebsites.net/getChats");

    }
}
