<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Patient;

class PatientsController extends Controller
{
    public function index(){
        return view('patients.patients');
    }

    public function save(Request $request){
    
        $this->validate($request,[
            'patientName'=>'required',
            'patientDateOfBirth'=>'required'
        ]);
       
        $patient = new Patient;
        $patient ->patientName = $request->patientName;
        $patient->patientDateOfBirth =  $request->patientDateOfBirth;
        $patient->save();
   
    }

    public function update(Request $request){
        $patientId = $request->patientId;
        $patient = Patient::findOrFail($patientId);
        $patient->patientName = $request->patientName;
        $patient->patientDateOfBirth = $request->patientDateOfBirth;
        $patient->save();
    }
    public function get(){
        $patient = Patient::all();
        echo $patient;
    }
    public function delete($patientId){
        $patient = Patient::find($patientId);
        $patient->delete();
        echo $patient;
    }
    public function getSingle($patientId){
       
        $patient = Patient::find($patientId);
        echo json_encode ($patient);
    }
}