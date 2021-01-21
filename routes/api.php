<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
   
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/solicitudes','SolicitudController@store');

Route::middleware('auth:api')->post('/user', function (Request $request) {
    return $request->user();
});
Route::post('prueba',"SolicitudController@prueba");
Route::group(["middleware" => "apikey.validate"], function () {
    
});

Route::post('/ciudadanos/xml',"XMLController@xml");

Route::get('/pdf','PDFController@PDF')->name('PDF');

Route::post('/ciudadanos','CiudanoController@store');

