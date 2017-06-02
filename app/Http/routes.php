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

Route::auth();

Route::get('/', ['as' => 'home', function () {
    $position = ['main_title'=>'Home','second_title'=>'',
                 'urls'=>
                    [
                        ['name'=>'home','url'=>'#']
                    ]
                ];
    return view('home')->with('position',$position);
}]);

//OTL
Route::get('otlupload', ['uses'=>'OtlUploadController@getForm','as'=>'otluploadform']);
Route::post('otlupload', ['uses'=>'OtlUploadController@postForm','as'=>'otlupload']);

//STEP
Route::get('stepupload', ['uses'=>'StepUploadController@getForm','as'=>'stepuploadform']);
Route::post('stepupload', ['uses'=>'StepUploadController@postForm','as'=>'stepupload']);

//Employee activity
Route::get('employeeactivity', ['uses'=>'EmployeeActivityController@getView','as'=>'employeeactivity']);
//Employee skill
Route::get('employeeskill', ['uses'=>'EmployeeSkillController@getView','as'=>'employeeskill']);

//Employee
//  Main employee list
Route::get('employeeList', ['uses'=>'EmployeeController@getList','as'=>'employeeList']);
//  Create new employee
Route::get('employeeFormCreate', ['uses'=>'EmployeeController@getFormCreate','as'=>'employeeFormCreate']);
Route::post('employeeFormCreate', ['uses'=>'EmployeeController@postFormCreate']);
//  Update employee
Route::get('employeeFormUpdate/{n}', ['uses'=>'EmployeeController@getFormUpdate','as'=>'employeeFormUpdate']);
Route::post('employeeFormUpdate/{n}', ['uses'=>'EmployeeController@postFormUpdate']);
//  Delete employee
Route::get('employeeDelete/{n}', ['uses'=>'EmployeeController@delete','as'=>'employeeDelete']);
//  Employee information
Route::get('employee/{n}', ['uses'=>'EmployeeController@show','as'=>'employee']);

//AJAX
//Activity per employee
Route::post('activityperemployee', ['uses'=>'Ajax\ActivityAjaxController@postActivityPerEmployee','as'=>'ajaxactivityperemployee']);
Route::post('activityperproject', ['uses'=>'Ajax\ActivityAjaxController@postActivityPerProject','as'=>'ajaxactivityperproject']);
Route::post('skillperemployee', ['uses'=>'Ajax\SkillAjaxController@postSkillPerEmployee','as'=>'ajaxskillperemployee']);
//Lists
Route::get('ajaxlistdomain', ['uses'=>'Ajax\AjaxListController@getAjaxListDomain','as'=>'ajaxlistdomain']);
Route::get('ajaxlistmanager', ['uses'=>'Ajax\AjaxListController@getAjaxListManager','as'=>'ajaxlistmanager']);
Route::post('ajaxlistemployee', ['uses'=>'Ajax\AjaxListController@getAjaxListEmployee','as'=>'ajaxlistemployee']);
Route::get('ajaxlistsubdomain', ['uses'=>'Ajax\AjaxListController@getAjaxListSubDomain','as'=>'ajaxlistsubdomain']);
Route::get('ajaxlistjobrole', ['uses'=>'Ajax\AjaxListController@getAjaxListJobRole','as'=>'ajaxlistjobrole']);
Route::get('ajaxlistmetaactivity', ['uses'=>'Ajax\AjaxListController@getAjaxListMetaActivity','as'=>'ajaxlistmetaactivity']);
