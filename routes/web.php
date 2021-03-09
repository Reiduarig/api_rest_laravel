<?php

use Illuminate\Support\Facades\Route;

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
/*Route::get('/', function () {
    return view('welcome');
});
/*Route::get('/pruebas/{id}', function ($id) {
    $texto = '<h2>Texto desde una ruta</h2>';
    $texto .= 'Id: ' .$id;
    return $texto;
});*/
//asociar vista

//Rutas de prueba
/*Route::get('/pruebas/{id}', function ($id) {
    $texto = '<h2>Texto desde una ruta</h2>';
    $texto .= 'Id: ' .$id;
    return view('pruebas', array('texto'=>$texto));
});

Route::get('/animales', 'PruebasController@index');
*/
Route::get('/test', 'PruebasController@testOrm');


