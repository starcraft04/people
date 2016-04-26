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

//AJAX
//Activity per employee
Route::get('activityperemployee/employee_id/{employee_id}/month/{month}', ['uses'=>'Ajax\ActivityAjaxController@getActivityPerEmployee','as'=>'ajaxactivityperemployee']);
Route::get('activityperproject/employee_id/{employee_id}/month/{month}', ['uses'=>'Ajax\ActivityAjaxController@getActivityPerProject','as'=>'ajaxactivityperproject']);