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

// PATIENT SECTION
    // Dashboard
    Route::get('dashboard', 'HomeController@index')->name('dashboard');
    Route::get('fetch-all-schedules', 'HomeController@fetchAllSchedules')->name('fetch-all-schedules');
    Route::get('fetch-all-schedule-per-month', 'HomeController@fetchAllSchedulesPerMonth')->name('fetch-all-schedule-per-month');
    Route::get('fetch-all-schedule-today', 'HomeController@fetchAllSchedulesToday')->name('fetch-all-schedule-today');
    Route::get('delete-schedule', 'HomeController@deleteSchedule')->name('delete-schedule');
    Route::post('create-schedule', 'HomeController@createSchedule')->name('create-schedule');
    Route::put('update-schedule', 'HomeController@updateSchedule')->name('update-schedule');

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
    Route::post('add-medicine', 'InventoryController@addMedicine')->name('add-medicine');
    Route::post('upload-medicine-list', 'InventoryController@uploadMedicine')->name('upload-medicine-list');
// END OF PATIENT SECTION

// EMPLOYEES SECTION
    // Time Keeping
    Route::get('time-keeping', 'HRController@index')->name('time-keeping');
    Route::get('save-time-in', 'HRController@saveTimeIn')->name('save-time-in');
    Route::get('save-time-out', 'HRController@saveTimeOut')->name('save-time-out');

    Route::get('time-keeping-disputes', 'HRController@loadTimeKeepingDisputesPage')->name('time-keeping-disputes');
    Route::post('send-time-keeping-request', 'HRController@saveTimeKeepingRequest')->name('send-time-keeping-request');
    Route::post('update-dispute', 'HRController@updateDispute')->name('update-dispute');

    Route::post('send-leave-request', 'LeavesController@saveLeaveRequest')->name('send-leave-request');
    Route::get('action-leave-request', 'LeavesController@actionLeaveRequest')->name('action-leave-request');

    // Leaves
    Route::get('leaves', 'LeavesController@index')->name('leaves');
// END OF EMPLOYEE SECTION
