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

Route::post('login', 'Api\UserController@login');
Route::post('logout', 'Api\UserController@logoutApi');

//company
Route::group(['prefix' => 'company', 'middleware' => 'auth:api'], function(){
    Route::get('/', 'Api\CompanyController@index');
    Route::get('single/{id}', 'Api\CompanyController@show');
    Route::get('single-edit/{id}', 'Api\CompanyController@edit');
    Route::post('create', 'Api\CompanyController@store');
    Route::post('updates/{id}', 'Api\CompanyController@update');
    Route::delete('delete/{id}', 'Api\CompanyController@destroy');
    Route::get('employee/{id}', 'Api\CompanyController@employee');

});

//Employees
Route::group(['prefix' => 'employee', 'middleware' => 'auth:api'], function(){
    Route::get('/', 'Api\EmployeeController@index');
    Route::get('single/{id}', 'Api\EmployeeController@show');
    Route::get('single-edit/{id}', 'Api\EmployeeController@edit');
    Route::post('create', 'Api\EmployeeController@store');
    Route::put('updates/{id}', 'Api\EmployeeController@update');
    Route::delete('delete/{id}', 'Api\EmployeeController@destroy');
    Route::get('company/{id}', 'Api\EmployeeController@company');

});