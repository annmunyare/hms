<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visit;
use App\Patient;
use App\Bill;


class VisitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('visits.visits');
    }

    public function save(Request $request){
    
        $this->validate($request,[
            'visitName'=>'required',
            'visitAmount'=>'required'
        ]);
       
        $visit = new Visit;
        $visit ->visitName = $request->visitName;
        $visit->visitAmount =  $request->visitAmount;
        $visit->save();
   
    }

    public function update(Request $request){

        $visitId = $request->visitId;
        $visit = Visit::findOrFail($visitId);

        // $visit->patientId=$request->input('patientId');
        $visit ->patientName = $request->patientName;
        $visit->patientDateOfBirth =  $request->patientDateOfBirth;
        $visit ->visitDate = $request->visitDate;
        $visit ->visitType = $request->visitType;
        $visit ->exitTime = $request->exitTime;
        $visit ->visitStatus = $request->visitStatus;
        $visit->save();
    }

    public function bill(Request $request){




        $bill = new Bill();
       

        $bill->visitId =  $request->visitId;
        $bill ->serviceId = $request->serviceId;
        $bill ->amount = $request->amount;
        $bill ->quantity = $request->quantity;
        $bill ->billTime = $request->billTime;
        $bill->save();
    }
    public function get(){
        $visit = Visit::all();
        echo $visit;
    }
    public function delete($visitId){
        $visit = Visit::find($visitId);
        $visit->delete();
        echo $visit;
    }
    public function getSingle($visitId){
       
        $visit = Visit::find($visitId);
        echo json_encode ($visit);
    }
}
