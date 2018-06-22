<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('services.services');
    }

    public function save(Request $request){
    
        $this->validate($request,[
            'serviceName'=>'required',
            'serviceAmount'=>'required'
        ]);
       
        $service = new Service;
        $service ->serviceName = $request->serviceName;
        $service->serviceAmount =  $request->serviceAmount;
        $service->save();
   
    }

    public function update(Request $request){
        $serviceId = $request->serviceId;
        $service = Service::findOrFail($serviceId);
        $service->serviceName = $request->serviceName;
        $service->serviceAmount = $request->serviceAmount;
        $service->save();
    }
    public function get(){
        $service = Service::all();
        echo $service;
    }
    public function delete($serviceId){
        $service = Service::find($serviceId);
        $service->delete();
        echo $service;
    }
    public function getSingle($serviceId){
       
        $service = Service::find($serviceId);
        echo json_encode ($service);
    }
}
