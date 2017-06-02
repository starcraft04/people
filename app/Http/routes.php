<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['middleware' => 'auth','as' => 'home', function () {
    return view('home');
}]);

//OTL
Route::get('otlupload', ['middleware' => 'auth','uses'=>'OtlUploadController@getForm','as'=>'otluploadform']);
Route::post('otlupload', ['middleware' => 'auth','uses'=>'OtlUploadController@postForm','as'=>'otlupload']);

//Employee
//  Main employee list
Route::get('employeeList', ['middleware' => 'auth','uses'=>'EmployeeController@getList','as'=>'employeeList']);
//  Create new employee
Route::get('employeeFormCreate', ['middleware' => 'auth','uses'=>'EmployeeController@getFormCreate','as'=>'employeeFormCreate']);
Route::post('employeeFormCreate', ['middleware' => 'auth','uses'=>'EmployeeController@postFormCreate']);
//  Update employee
Route::get('employeeFormUpdate/{n}', ['middleware' => 'auth','uses'=>'EmployeeController@getFormUpdate','as'=>'employeeFormUpdate']);
Route::post('employeeFormUpdate/{n}', ['middleware' => 'auth','uses'=>'EmployeeController@postFormUpdate']);
//  Delete employee
Route::get('employeeDelete/{n}', ['middleware' => 'auth','uses'=>'EmployeeController@delete','as'=>'employeeDelete']);
//  Employee information
Route::get('employee/{n}', ['middleware' => 'auth','uses'=>'EmployeeController@show','as'=>'employee']);
//  AJAX
Route::get('listOfEmployeesAjax', ['middleware' => 'auth','uses'=>'EmployeeController@listOfEmployees','as'=>'listOfEmployeesAjax']);

//Auth
Route::auth();
Route::get('/home', 'HomeController@index');
Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@logout']);
