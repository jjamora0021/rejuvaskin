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

// Dashboard
Route::get('dashboard', 'HomeController@index')->name('dashboard');

// Calendar
Route::get('calendar', 'HomeController@calendar')->name('calendar');

// Patients
Route::get('fetch-all-patient-info', 'PatientInformationController@fetchAll')->name('fetch-all-patient-info');
Route::get('patient-information', 'PatientInformationController@index')->name('patient-information');
Route::get('add-patient-information', 'PatientInformationController@create')->name('add-patient-information');
Route::post('store-patient-information', 'PatientInformationController@store')->name('store-patient-information');
Route::get('view-patient-information/{id}', 'PatientInformationController@show')->name('view-patient-information');
Route::put('update-patient-history/{id}', 'PatientInformationController@update')->name('update-patient-history');
Route::get('delete-patient-information', 'PatientInformationController@deleteRecord')->name('delete-patient-information');
Route::get('update-patient-information/{id}', 'PatientInformationController@loadUpdatePatientInformationPage');
Route::post('update-patient-information/{id}', 'PatientInformationController@updatePatientInformation')->name('update-patient-information');

// Inventory
Route::get('inventory-list', 'InventoryController@index')->name('inventory-list');
Route::get('fetch-all-medicine-info', 'InventoryController@fetchAllMedicine')->name('fetch-all-medicine-info');
Route::get('update-inventory-list/{id}', 'InventoryController@updateStocks')->name('update-inventory-list');
Route::get('delete-medicine', 'InventoryController@deleteMedicine')->name('delete-medicine');
