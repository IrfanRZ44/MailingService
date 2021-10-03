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

// Route::get('/', function () { return view('login'); });
Route::get('/', 'App\Http\Controllers\MainController@index');
Route::post('/login', 'App\Http\Controllers\MainController@login');
Route::get('/logout', 'App\Http\Controllers\MainController@logout');
Route::get('/main', 'App\Http\Controllers\MainController@main');
Route::get('/download', 'App\Http\Controllers\MainController@download');
Route::post('/sent', 'App\Http\Controllers\MainController@sent');