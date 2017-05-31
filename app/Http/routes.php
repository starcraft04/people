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

//Employee
Route::get('employee', ['uses'=>'EmployeeController@getList','as'=>'employee']);
Route::get('employee/{n}', ['uses'=>'EmployeeController@show']);
Route::get('employeeForm', ['uses'=>'EmployeeController@getForm']);
Route::post('employeeForm', ['uses'=>'EmployeeController@postForm']);
Route::get('employeeFormUpdate/{n}', ['uses'=>'EmployeeController@getFormUpdate']);
Route::post('employeeFormUpdate/{n}', ['uses'=>'EmployeeController@postFormUpdate']);

//Employee activity
Route::get('employeeactivity', ['uses'=>'EmployeeActivityController@getView','as'=>'employeeactivity']);
//Employee skill
Route::get('employeeskill', ['uses'=>'EmployeeSkillController@getView','as'=>'employeeskill']);

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
