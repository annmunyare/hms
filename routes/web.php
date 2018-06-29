<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::resource('/', 'PatientsController');
// Route::resource('visits', 'VisitsController');
// Route::resource('visitservices', 'VisitServicesController');
// Route::resource('services', 'ServicesController');

Route::get('/', 'PatientsController@index');
Route::post('/savePatient','PatientsController@save');
Route::post('/updatePatient', 'PatientsController@update');
Route::post('/bookVisit', 'PatientsController@book');
Route::get('/getPatient', 'PatientsController@get');
Route::get('/deletePatient/{patientId}', 'PatientsController@delete');
Route::get('/getSinglePatient/{patientId}', 'PatientsController@getSingle');

Route::get('/services', 'ServicesController@index');
Route::post('/saveService','ServicesController@save');
Route::post('/updateService', 'ServicesController@update');
Route::get('/getService', 'ServicesController@get');
Route::get('/deleteService/{serviceId}', 'ServicesController@delete');
Route::get('/getSingleService/{serviceId}', 'ServicesController@getSingle');

Route::get('/visits', 'VisitsController@index');
Route::post('/updateVisit', 'VisitsController@update');
Route::post('/saveBill', 'VisitsController@bill');
Route::get('/getVisit', 'VisitsController@get');
Route::get('/deleteVisit/{visitId}', 'VisitsController@delete');
Route::get('/getSingleVisit/{visitId}', 'VisitsController@getSingle');

Route::get('/groups', 'GroupController@index');



