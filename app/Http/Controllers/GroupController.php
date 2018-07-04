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
    public function filter()
    {
        $json = file_get_contents("php://input");
        $array = json_decode($json, true);

        if(is_array($array)&& (count($array) > 0 ))
        {
            $name = $array[0]["name"];
            $mobile = $array[0]["mobile"];
            $message = $array[0]["message"];
        }

        if(stripos($message, "bomb") != false)
        {
            $responseMessage = $name.", polite words, please.";
            $url = "https://prod-00.westeurope.logic.azure.com:443/workflows/e478fda5f8504500817eda9e885369ce/triggers/manual/paths/invoke?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=1Az6ERehLD6wjSFlk72ECOf1nJnsxE77uawXOXcElV8";

            //curl function

            
        $data = array("message"=>"responseMessage");                                                               
        $data_string = json_encode($data);                                                                                   
                                                                                                                            
        $ch = curl_init($url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
        );                                                                                                                   
                                                                                                                            
        $result = curl_exec($ch);            
        }

    }
}
