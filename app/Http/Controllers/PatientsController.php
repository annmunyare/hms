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
            'name'=>'required',
            'description'=>'required'
        ]);
       
        $patient = new Patient;
        $patient ->name = $request->name;
        $patient->description =  $request->description;
        $patient->save();
   
    }

    public function update(Request $request){
        $id = $request->id;
        $patient = Patient::findOrFail($id);
        $patient->name = $request->name;
        $patient->description = $request->description;
        $patient->save();
    }
    public function get(){
        $patient = Patient::all();
        echo $patient;
    }
    public function delete(Patient $patient){
      
        $patient->delete();
        echo $patient;
    }
    public function getSingle(Patient $patient){
       
        echo json_encode ($patient);
    }
}