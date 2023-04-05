<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/prueba', 'UsuarioApiController@actionPrueba');

Route::get('/lista-actores', 'UsuarioApiController@actionListarActores')->middleware('auth:api');
Route::get('/lista-actores/tipodocumento/{dniruc}', 'UsuarioApiController@actionListarActoresxDniRuc')->middleware('auth:api');



Route::get('/lista-actores/dni/{dni}', 'UsuarioApiController@actionListarActoresDni')->middleware('auth:api');
Route::get('/lista-actores/tipo-actor/{tipoactor}', 'UsuarioApiController@actionListarActoresTipoActor');
Route::get('/lista-compradores/{fecha_desde}/{fecha_hasta}', 'UsuarioApiController@actionListarCompradores')->middleware('auth:api');
Route::get('/lista-vendedores/{fecha_desde}/{fecha_hasta}', 'UsuarioApiController@actionListarVendedores')->middleware('auth:api');
Route::post('/login', 'UserApiController@actionLogin');


