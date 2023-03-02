<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| l are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get("login",'Auth\LoginController@loginApi');


Route::group(['middleware' => ['auth:api','role:Skillbase API']], function () {
    //
 
 	//  Route::get("activeUsers","Apis\skillbaseApiController@listOfActiveUsers");

	// Route::get("userSkills","Apis\skillbaseApiController@listOfUserSkillsAPI");

	// Route::get("userCertificates","Apis\skillbaseApiController@listOfUserCertificatesAPI");

	//to avoid many hits on server
	Route::get("activeusercert","Apis\skillbaseApiController@activeUserCertificatesAPI");
	Route::get("activeusercertdashboard","Apis\skillbaseApiController@activeUserCertificatesAPIDashboard");

	Route::get("activeuserskills","Apis\skillbaseApiController@activeUserSkillsAPI");
	Route::get("activeuserskillsdashboard","Apis\skillbaseApiController@activeUserSkillsAPIDashboard");
	Route::get("allSkills","Apis\skillbaseApiController@allSkills");
	Route::get("allCerts","Apis\skillbaseApiController@allCerts");
});



