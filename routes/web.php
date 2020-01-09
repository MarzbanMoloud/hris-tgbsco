<?php

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

Auth::routes();

Route::middleware('auth')->group(function () {

//Route::get('/home', 'HomeController@index')->name('home');

/*---------------------------------- Dashboard ----------------------------------*/
    Route::get('/', 'DashboardController@index')->name('dashboard');

    /*---------------------------------- Personnel ----------------------------------*/
    Route::get('personnels/filter', 'PersonnelController@filter')->name('personnels.filter');
    Route::get('personnels/restore/{personnel}', 'PersonnelController@restore')->name('personnels.restore');
    Route::resource('personnels', 'PersonnelController');

    /*---------------------------------- OrganizationalUnit ----------------------------------*/
    Route::resource('organizationalUnits', 'OrganizationalUnitController');

    /*---------------------------------- Job ----------------------------------*/
    Route::resource('jobs', 'JobController');

    /*---------------------------------- CentralCost ----------------------------------*/
    Route::resource('centralCosts', 'CentralCostController');

    /*---------------------------------- Project ----------------------------------*/
    Route::resource('projects', 'ProjectController');

    /*---------------------------------- UploadFile ----------------------------------*/
    Route::post('uploadFile', 'UploadFileController@index')->name('uploadFile');

    /*---------------------------------- Event ----------------------------------*/
    Route::get('event/success/{event}', 'EventController@success')->name('event.success');
    Route::get('event/canceled/{event}', 'EventController@canceled')->name('event.canceled');
    Route::resource('events', 'EventController');

    /*---------------------------------- Excel ----------------------------------*/
    Route::prefix('excel')->name('excel.')->group(function () {
        //---------------------------------- Export ----------------------------------//
        Route::prefix('export')->name('export.')->group(function () {
            Route::post('filter-personnel', 'ExcelController@exportFilterPersonnel')->name('filterPersonnel');
        });
        //---------------------------------- Import ----------------------------------//
        Route::post('import', 'ExcelController@import')->name('import');
    });

    /*---------------------------------- Salary ----------------------------------*/
    Route::get('salaries/filter', 'SalaryController@filter')->name('salaries.filter');
    Route::get('salaries/amounts/{personnel}', 'SalaryController@amounts')->name('salaries.amounts');
    Route::resource('salaries', 'SalaryController');

    /*---------------------------------- Loan ----------------------------------*/
    Route::get('loans/times/{personnel}', 'LoanController@timesLoanToDedicatedPersonnel')->name('loan.times');
    Route::resource('loans', 'LoanController');

    /*---------------------------------- Help ----------------------------------*/
    Route::get('helps/times/{personnel}', 'HelpController@timesHelpToDedicatedPersonnel')->name('helps.times');
    Route::resource('helps', 'HelpController');

    /*---------------------------------- Guarantee ----------------------------------*/
    Route::get('guarantees/times/{personnel}', 'GuaranteeController@timesGuaranteeToDedicatedPersonnel')->name('guarantees.times');
    Route::resource('guarantees', 'GuaranteeController');

    /*---------------------------------- JobCertificate ----------------------------------*/
    Route::get('jobCertificates/times/{personnel}', 'JobCertificateController@timesJobCertificateToDedicatedPersonnel')->name('jobCertificates.times');
    Route::resource('jobCertificates', 'JobCertificateController');
});