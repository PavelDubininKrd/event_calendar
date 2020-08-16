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

Route::get('/', function () {
    return view('pages.index');
});

Auth::routes();

Route::get('/show', 'EventController@show')->name('show');
Route::resource('event', 'EventController');
Route::delete('event/{id}/{companyId}', 'EventController@eventAndCompanyDestroy')->name('destroy');
Route::get('/company/{id}', 'EventController@companyShow')->name('company.show');
