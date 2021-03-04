<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

//['verify'=>true] dentro de las rutas para verificacion
Auth::routes(['verify'=>true]);

//->middleware('verified') para requerir la verificacion por email
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

Route::group(['middleware'=>['auth','verified']],function(){
    Route::get('/cliente', 'App\Http\Controllers\ClienteController@index');
    Route::post('/cliente/registrar', 'App\Http\Controllers\ClienteController@store');
    Route::put('/cliente/actualizar', 'App\Http\Controllers\ClienteController@update');
    Route::put('/cliente/activar', 'App\Http\Controllers\ClienteController@activar');
    Route::put('/cliente/desactivar', 'App\Http\Controllers\ClienteController@desactivar');
    Route::get('/cliente/excel', 'App\Http\Controllers\ClienteController@excel');
});
