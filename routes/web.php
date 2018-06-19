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
Route::get('/getPatient', 'PatientsController@get');
Route::get('/deletePatient/{lesson}', 'PatientsController@delete');
Route::get('/getSinglePatient/{lesson}', 'PatientsController@getSingle');