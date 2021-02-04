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
    return redirect('login');
});

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');

Route::get('dashboard', 'HomeController@index')->name('dashboard');
Route::get('calendar', 'HomeController@calendar')->name('calendar');

Route::get('patient-information', 'PatientInformationController@index')->name('patient-information');
Route::get('add-patient-information', 'PatientInformationController@create')->name('add-patient-information');
Route::post('store-patient-information', 'PatientInformationController@store')->name('store-patient-information');
Route::get('view-patient-information/{id}', 'PatientInformationController@show')->name('view-patient-information');
Route::put('update-patient-information/{id}', 'PatientInformationController@update')->name('update-patient-information');
Route::get('delete-patient-information/{id}', 'PatientInformationController@destroy')->name('delete-patient-information');
