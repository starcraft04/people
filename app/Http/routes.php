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

//Help section
Route::get('help', ['as' => 'help', 'uses' => 'GeneralController@help']);


//Auth
// Authentication Routes...
Route::get('login', 'Auth\AuthController@showLoginForm');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@logout']);

// Registration Routes...
// Registration will be deactivated by commenting out the routes
//Route::get('register', 'Auth\AuthController@showRegistrationForm');
//Route::post('register', 'Auth\AuthController@register');
// Password Reset Routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');

// All routes in this function will be protected by user needed to be logged in.
Route::group(['middleware' => ['auth']], function() {
      Route::get('/home', ['uses'=>'HomeController@index','as'=>'home']);
      Route::get('/', ['uses'=>'HomeController@index']);

      //OTL
      Route::get('otlupload', ['uses'=>'OtlUploadController@getForm','as'=>'otluploadform','middleware' => ['permission:otl-upload']]);
      Route::post('otlupload', ['uses'=>'OtlUploadController@postForm','middleware' => ['permission:otl-upload']]);

      //Clusters
      Route::get('clusterList', ['uses'=>'ClusterController@getList','as'=>'clusterList','middleware' => ['permission:user-view|user-create|user-edit|user-delete']]);
      Route::get('listOfClustersAjax', ['uses'=>'ClusterController@listOfClusters','as'=>'listOfClustersAjax','middleware' => ['permission:user-view|user-create|user-edit|user-delete']]);
      Route::get('cluster/{n}', ['uses'=>'ClusterController@show','as'=>'cluster','middleware' => ['permission:user-view']]);
      Route::get('clusterFormUpdate/{n}', ['uses'=>'ClusterController@getFormUpdate','as'=>'clusterFormUpdate','middleware' => ['permission:user-edit']]);
      Route::post('clusterFormUpdate/{id}', ['uses'=>'ClusterController@postFormUpdate','middleware' => ['permission:user-edit']]);
      //  Create new Cluster
      Route::get('clusterFormCreate', ['uses'=>'ClusterController@getFormCreate','as'=>'clusterFormCreate','middleware' => ['permission:user-create']]);
      Route::post('clusterFormCreate', ['uses'=>'ClusterController@postFormCreate','middleware' => ['permission:user-create']]);
      //  Delete cluster
      Route::get('clusterDelete/{n}', ['uses'=>'ClusterController@delete','as'=>'clusterDelete','middleware' => ['permission:user-delete']]);

      //User
      //  Main user list
      Route::get('userList', ['uses'=>'UserController@getList','as'=>'userList','middleware' => ['permission:user-view|user-create|user-edit|user-delete']]);
      //  user information
      Route::get('user/{n}', ['uses'=>'UserController@show','as'=>'user','middleware' => ['permission:user-view']]);
      //  Create new user
      Route::get('userFormCreate', ['uses'=>'UserController@getFormCreate','as'=>'userFormCreate','middleware' => ['permission:user-create']]);
      Route::post('userFormCreate', ['uses'=>'UserController@postFormCreate','middleware' => ['permission:user-create']]);
      //  Update user
      Route::get('userFormUpdate/{n}', ['uses'=>'UserController@getFormUpdate','as'=>'userFormUpdate','middleware' => ['permission:user-edit']]);
      Route::post('userFormUpdate/{n}', ['uses'=>'UserController@postFormUpdate','middleware' => ['permission:user-edit']]);
      //  Delete user
      Route::get('userDelete/{n}', ['uses'=>'UserController@delete','as'=>'userDelete','middleware' => ['permission:user-delete']]);
      //  user profile
      Route::get('profile/{n}', ['uses'=>'UserController@profile','as'=>'profile']);
      Route::post('passwordUpdate/{n}', ['uses'=>'UserController@passwordUpdate','as'=>'passwordUpdate']);
      //  AJAX
      Route::get('listOfUsersAjax', ['uses'=>'UserController@listOfUsers','as'=>'listOfUsersAjax','middleware' => ['permission:user-view|user-create|user-edit|user-delete']]);

      //ProfileToolsController
      Route::get('ajax_git_pull', ['uses'=>'ProfileToolsController@ajax_git_pull','as'=>'ajax_git_pull']);
      Route::get('ajax_env_app_debug/{n}', ['uses'=>'ProfileToolsController@ajax_env_app_debug','as'=>'ajax_env_app_debug']);

      // Roles
      Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index','middleware' => ['permission:role-view|role-create|role-edit|role-delete']]);
      Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create','middleware' => ['permission:role-create']]);
      Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store','middleware' => ['permission:role-create']]);
      Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit','middleware' => ['permission:role-edit']]);
      Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update','middleware' => ['permission:role-edit']]);
      Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy','middleware' => ['permission:role-delete']]);

      //Project
      //  Main project list
      Route::get('projectList', ['uses'=>'ProjectController@getList','as'=>'projectList','middleware' => ['permission:project-view|project-create|project-edit|project-delete']]);
      //  project information
      Route::get('project/{n}', ['uses'=>'ProjectController@show','as'=>'project','middleware' => ['permission:project-view']]);
      //  Create new project
      Route::get('projectFormCreate', ['uses'=>'ProjectController@getFormCreate','as'=>'projectFormCreate','middleware' => ['permission:project-create']]);
      Route::post('projectFormCreate', ['uses'=>'ProjectController@postFormCreate','middleware' => ['permission:project-create']]);
      //  Update project
      Route::get('projectFormUpdate/{n}', ['uses'=>'ProjectController@getFormUpdate','as'=>'projectFormUpdate','middleware' => ['permission:project-edit']]);
      Route::post('projectFormUpdate/{n}', ['uses'=>'ProjectController@postFormUpdate','middleware' => ['permission:project-edit']]);
      //  Delete project
      Route::get('projectDelete/{n}', ['uses'=>'ProjectController@delete','as'=>'projectDelete','middleware' => ['permission:project-delete']]);
      //  AJAX
      Route::post('listOfProjectsAjax', ['uses'=>'ProjectController@listOfProjects','as'=>'listOfProjectsAjax','middleware' => ['permission:tools-all_projects-view|tools-unassigned-view|tools-activity-edit|project-view|project-create|project-edit|project-delete']]);

      //Customer
      //  Main customer list
      Route::get('customerList', ['uses'=>'CustomerController@getList','as'=>'customerList','middleware' => ['permission:project-view|project-create|project-edit|project-delete']]);
      //  customer information
      Route::get('customer/{n}', ['uses'=>'CustomerController@show','as'=>'customer','middleware' => ['permission:project-view']]);
      //  Create new customer
      Route::get('customerFormCreate', ['uses'=>'CustomerController@getFormCreate','as'=>'customerFormCreate','middleware' => ['permission:project-create']]);
      Route::post('customerFormCreate', ['uses'=>'CustomerController@postFormCreate','middleware' => ['permission:project-create']]);
      //  Update customer
      Route::get('customerFormUpdate/{n}', ['uses'=>'CustomerController@getFormUpdate','as'=>'customerFormUpdate','middleware' => ['permission:project-edit']]);
      Route::post('customerFormUpdate/{n}', ['uses'=>'CustomerController@postFormUpdate','middleware' => ['permission:project-edit']]);
      //  Delete customer
      Route::get('customerDelete/{n}', ['uses'=>'CustomerController@delete','as'=>'customerDelete','middleware' => ['permission:project-delete']]);
      //  AJAX
      Route::post('listOfCustomersAjax', ['uses'=>'CustomerController@listOfCustomers','as'=>'listOfCustomersAjax','middleware' => ['permission:project-view|project-create|project-edit|project-delete']]);


      //Activity
      //  Main activity list
      Route::get('activityList', ['uses'=>'ActivityController@getList','as'=>'activityList','middleware' => ['permission:activity-view|activity-create|activity-edit|activity-delete']]);
      //  activity information
      Route::get('activity/{n}', ['uses'=>'ActivityController@show','as'=>'activity','middleware' => ['permission:activity-view']]);
      //  Create new activity
      Route::get('activityFormCreate', ['uses'=>'ActivityController@getFormCreate','as'=>'activityFormCreate','middleware' => ['permission:activity-create']]);
      Route::post('activityFormCreate', ['uses'=>'ActivityController@postFormCreate','middleware' => ['permission:activity-create']]);
      //  Update activity
      Route::get('activityFormUpdate/{n}', ['uses'=>'ActivityController@getFormUpdate','as'=>'activityFormUpdate','middleware' => ['permission:activity-edit']]);
      Route::post('activityFormUpdate/{n}', ['uses'=>'ActivityController@postFormUpdate','middleware' => ['permission:activity-edit']]);
      //  Delete activity
      Route::get('activityDelete/{n}', ['uses'=>'ActivityController@delete','as'=>'activityDelete','middleware' => ['permission:activity-delete']]);
      //  AJAX
      Route::get('listOfActivitiesAjax', ['uses'=>'ActivityController@listOfActivities','as'=>'listOfActivitiesAjax','middleware'
                    => ['permission:activity-view|activity-create|activity-edit|activity-delete']]);

      //Comment
      Route::get('comment/{id}', ['uses'=>'CommentController@show','as'=>'comment_show','middleware' => ['permission:tools-activity-new|tools-activity-edit']]);
      Route::get('comments/{project_id}', ['uses'=>'CommentController@getList','as'=>'comment_list','middleware' => ['permission:tools-activity-new|tools-activity-edit']]);
      Route::post('comment/edit/{id}', ['uses'=>'CommentController@edit','as'=>'comment_edit','middleware' => ['permission:tools-activity-new|tools-activity-edit']]);
      Route::get('comment/delete/{id}', ['uses'=>'CommentController@delete','as'=>'comment_delete','middleware' => ['permission:tools-activity-new|tools-activity-edit']]);

      //Tools
      Route::get('toolsActivities', ['uses'=>'ToolsController@activities','as'=>'toolsActivities','middleware' => ['permission:tools-activity-view']]);
      Route::get('toolsProjectsAll', ['uses'=>'ToolsController@projectsAll','as'=>'projectsAll','middleware' => ['permission:tools-all_projects-view']]);
      Route::get('toolsProjectsLost', ['uses'=>'ToolsController@projectsLost','as'=>'projectsLost','middleware' => ['permission:tools-all_projects-view']]);
      Route::get('toolsProjectsAssignedAndNot', ['uses'=>'ToolsController@projectsAssignedAndNot','as'=>'projectsAssignedAndNot','middleware' => ['permission:tools-unassigned-view']]);
      Route::get('toolsProjectsMissingInfo', ['uses'=>'ToolsController@projectsMissingInfo','as'=>'projectsMissingInfo','middleware' => ['permission:tools-missing_info-view']]);
      Route::get('toolsProjectsMissingOTL', ['uses'=>'ToolsController@projectsMissingOTL','as'=>'projectsMissingOTL','middleware' => ['permission:tools-missing_info-view']]);
      //  Create new activity
      Route::get('toolsFormCreate/{y}', ['uses'=>'ToolsController@getFormCreate','as'=>'toolsFormCreate','middleware' => ['permission:tools-activity-new']]);
      Route::post('toolsFormCreate', ['uses'=>'ToolsController@postFormCreate','middleware' => ['permission:tools-activity-new']]);
      //  Update activity
      Route::get('toolsFormUpdate/{u}/{p}/{y}', ['uses'=>'ToolsController@getFormUpdate','as'=>'toolsFormUpdate','middleware' => ['permission:tools-activity-edit']]);
      Route::post('toolsFormUpdate', ['uses'=>'ToolsController@postFormUpdate','middleware' => ['permission:tools-activity-edit']]);
      //  Transfer user
      Route::get('toolsFormTransfer/{user_id}/{project_id}', ['uses'=>'ToolsController@getFormTransfer','as'=>'toolsFormTransfer','middleware' => ['permission:tools-user_assigned-transfer']]);
      Route::get('toolsFormTransferAction/{user_id}/{old_project_id}/{new_project_id}', ['uses'=>'ToolsController@getFormTransferAction','as'=>'toolsFormTransferAction','middleware' => ['permission:tools-user_assigned-transfer']]);
      //  AJAX
      Route::post('listOfActivitiesPerUserAjax', ['uses'=>'ActivityController@listOfActivitiesPerUser','as'=>'listOfActivitiesPerUserAjax','middleware' => ['permission:tools-activity-view']]);
      Route::get('listOfProjectsMissingInfoAjax', ['uses'=>'ProjectController@listOfProjectsMissingInfo','as'=>'listOfProjectsMissingInfoAjax','middleware' => ['permission:tools-missing_info-view']]);
      Route::get('listOfProjectsMissingOTLAjax', ['uses'=>'ProjectController@listOfProjectsMissingOTL','as'=>'listOfProjectsMissingOTLAjax','middleware' => ['permission:tools-missing_info-view']]);
      Route::get('listOfProjectsLostAjax', ['uses'=>'ProjectController@listOfProjectsLost','as'=>'listOfProjectsLostAjax','middleware' => ['permission:tools-all_projects-view']]);
      Route::get('listOfProjectsAll', ['uses'=>'ProjectController@listOfProjectsAll','as'=>'listOfProjectsAllAjax','middleware' => ['permission:tools-all_projects-view']]);

      //Dashboards
      Route::get('dashboardLoad', ['uses'=>'DashboardController@load','as'=>'dashboardLoad','middleware' => ['permission:dashboard-view']]);
      Route::get('dashboardLoadChart', ['uses'=>'DashboardController@load_chart','as'=>'dashboardLoadChart','middleware' => ['permission:dashboard-view']]);
      Route::get('clusterdashboard', ['uses'=>'DashboardController@clusterboard','as'=>'clusterdashboard','middleware' => ['permission:cluster-view']]);
      //  AJAX
      Route::post('listOfLoadPerUserAjax', ['uses'=>'ActivityController@listOfLoadPerUserAjax','as'=>'listOfLoadPerUserAjax','middleware' => ['permission:dashboard-view']]);
      Route::post('listOfLoadPerUserChartAjax', ['uses'=>'ActivityController@listOfLoadPerUserChartAjax','as'=>'listOfLoadPerUserChartAjax','middleware' => ['permission:dashboard-view']]);
});

//Route::get('test', ['uses'=>'ActivityController@test']);
