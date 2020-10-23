<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'InicioController@index')->name('inicio.index');


// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/recetas', 'RecetasController');

Route::resource('/recetas', 'RecetaController');

// Buscador de recetas
Route::get('/buscar', 'RecetaController@search')->name('buscar.show');

// Imprimir PDF
Route::get('/imprimir/{receta}', 'RecetaController@imprimir')->name('recetas.imprimir');
// Route::get('/invoice-pdf', function () {
//     // return view('invoice-pdf');

//     $pdf = PDF::loadView('recetas.print');
//     return $pdf->download('invoice.pdf');
// });

// Route::resource('/perfiles', 'RecetaController');
Route::get('/perfiles/{perfil}', 'PerfilController@show')->name('perfiles.show');
Route::get('/perfiles/{perfil}/edit', 'PerfilController@edit')->name('perfiles.edit');
Route::put('/perfiles/{perfil}', 'PerfilController@update')->name('perfiles.update');

// ALmacena los likes de las recetas
Route::post('/recetas/{receta}', 'LikeController@update')->name('likes.update');

// Categorias
Route::get('/categoria/{categoria}', 'CategoriasController@show')->name('categorias.show');

Auth::routes();

