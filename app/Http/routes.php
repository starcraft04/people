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

      // Backup routes
      Route::get('backup', ['uses'=>'BackupController@index','as'=>'backupList','middleware' => ['permission:backup-create|backup-download|backup-delete']]);
      Route::get('backup/create', ['uses'=>'BackupController@create','as'=>'backupCreate','middleware' => ['permission:backup-create']]);
      Route::get('backup/download/{file_name}', ['uses'=>'BackupController@download','as'=>'backupDownload','middleware' => ['permission:backup-download']]);
      Route::get('backup/delete/{file_name}', ['uses'=>'BackupController@delete','as'=>'backupDelete','middleware' => ['permission:backup-delete']]);

      //OTL
      Route::get('otlupload', ['uses'=>'OtlUploadController@getForm','as'=>'otluploadform','middleware' => ['permission:otl-upload']]);
      Route::get('otlupload_help', ['uses'=>'OtlUploadController@help','as'=>'otluploadhelp','middleware' => ['permission:otl-upload']]);
      Route::post('otlupload', ['uses'=>'OtlUploadController@postForm','middleware' => ['permission:otl-upload']]);

      //Revenue
      Route::get('revenueupload', ['uses'=>'RevenueUploadController@getForm','as'=>'revenueuploadform','middleware' => ['permission:revenue-upload']]);
      Route::post('revenueupload', ['uses'=>'RevenueUploadController@postForm','middleware' => ['permission:revenue-upload']]);

      //Samba
      Route::get('sambaupload', ['uses'=>'SambaUploadController@getForm','as'=>'sambauploadform','middleware' => ['permission:samba-upload']]);
      Route::post('sambaupload', ['uses'=>'SambaUploadController@postForm','as'=>'sambauploadPOST','middleware' => ['permission:samba-upload']]);
      Route::post('sambauploadcreate', ['uses'=>'SambaUploadController@postFormCreate','as'=>'sambauploadcreatePOST','middleware' => ['permission:samba-upload']]);

      //Customer upload
      Route::get('customerupload', ['uses'=>'CustomerUploadController@getForm','as'=>'customeruploadform','middleware' => ['permission:customer-upload']]);
      Route::post('customerupload', ['uses'=>'CustomerUploadController@postForm','middleware' => ['permission:customer-upload']]);

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
      Route::post('optionsUpdate/{id}', ['uses'=>'UserController@optionsUpdate','as'=>'optionsUpdate']);
      //  AJAX
      Route::get('listOfUsersAjax/{exclude_contractors}', ['uses'=>'UserController@listOfUsers','as'=>'listOfUsersAjax','middleware' => ['permission:user-view|user-create|user-edit|user-delete']]);

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
      Route::get('toolsUserSummary', ['uses'=>'ToolsController@userSummary','as'=>'toolsUserSummary','middleware' => ['permission:tools-user-summary']]);
      Route::post('actionList', ['uses'=>'ActionController@actionList','as'=>'actionList','middleware' => ['permission:tools-user-summary']]);
      Route::post('actionInsertUpdate', ['uses'=>'ActionController@actionInsertUpdate','as'=>'actionInsertUpdate','middleware' => ['permission:action-create']]);
      Route::post('actionDelete', ['uses'=>'ActionController@actionDelete','as'=>'actionDelete','middleware' => ['permission:action-delete']]);
      Route::post('userSummaryProjects', ['uses'=>'ToolsController@userSummaryProjects','as'=>'userSummaryProjects','middleware' => ['permission:tools-activity-view']]);
      Route::get('toolsProjectsAll', ['uses'=>'ToolsController@projectsAll','as'=>'projectsAll','middleware' => ['permission:tools-all_projects-view']]);
      Route::get('toolsProjectsLost', ['uses'=>'ToolsController@projectsLost','as'=>'projectsLost','middleware' => ['permission:projects-lost']]);
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
      // Users skills
      Route::get('toolsUsersSkills', ['uses'=>'ToolsController@userskillslist','as'=>'toolsUsersSkills','middleware' => ['permission:tools-usersskills']]);
      Route::get('userskillFormCreate/{id?}', ['uses'=>'ToolsController@getuserskillFormCreate','as'=>'userskillFormCreate','middleware' => ['permission:tools-usersskills']]);
      Route::post('userskillFormCreate', ['uses'=>'ToolsController@postuserskillFormCreate','middleware' => ['permission:tools-usersskills']]);
      Route::get('userskillFormUpdate/{id}', ['uses'=>'ToolsController@getuserskillFormUpdate','as'=>'userskillFormUpdate','middleware' => ['permission:tools-usersskills']]);
      Route::post('userskillFormUpdate/{id}', ['uses'=>'ToolsController@postuserskillFormUpdate','middleware' => ['permission:tools-usersskills']]);
      //  AJAX
      Route::get('ProjectsRevenueAjax/{id}', ['uses'=>'ProjectController@listOfProjectsRevenue','as'=>'listOfProjectsRevenueAjax','middleware' => ['permission:projectRevenue-create']]);
      Route::post('ProjectsRevenueAddAjax', ['uses'=>'ProjectController@addRevenue','as'=>'ProjectsRevenueAddAjax','middleware' => ['permission:projectRevenue-create']]);
      Route::post('ProjectsRevenueUpdateAjax', ['uses'=>'ProjectController@updateRevenue','as'=>'ProjectsRevenueUpdateAjax','middleware' => ['permission:projectRevenue-edit']]);
      Route::get('projectRevenueDelete/{n}', ['uses'=>'ProjectController@deleteRevenue','as'=>'projectRevenueDelete','middleware' => ['permission:projectRevenue-delete']]);
      Route::post('listOfActivitiesPerUserAjax', ['uses'=>'ActivityController@listOfActivitiesPerUser','as'=>'listOfActivitiesPerUserAjax','middleware' => ['permission:tools-activity-view']]);
      Route::get('listOfProjectsMissingInfoAjax', ['uses'=>'ProjectController@listOfProjectsMissingInfo','as'=>'listOfProjectsMissingInfoAjax','middleware' => ['permission:tools-missing_info-view']]);
      Route::get('listOfProjectsMissingOTLAjax', ['uses'=>'ProjectController@listOfProjectsMissingOTL','as'=>'listOfProjectsMissingOTLAjax','middleware' => ['permission:tools-missing_info-view']]);
      Route::get('listOfProjectsLostAjax', ['uses'=>'ProjectController@listOfProjectsLost','as'=>'listOfProjectsLostAjax','middleware' => ['permission:tools-all_projects-view']]);
      Route::get('listOfProjectsAll', ['uses'=>'ProjectController@listOfProjectsAll','as'=>'listOfProjectsAllAjax','middleware' => ['permission:tools-all_projects-view']]);
      Route::post('listOfSkills/{cert}', ['uses'=>'ToolsController@listOfSkills','as'=>'listOfSkills','middleware' => ['permission:tools-usersskills']]);
      Route::post('listOfUsersSkills/{cert}', ['uses'=>'ToolsController@listOfUsersSkills','as'=>'listOfUsersSkills','middleware' => ['permission:tools-usersskills']]);
      Route::get('userskillDelete/{id}', ['uses'=>'ToolsController@userSkillDelete','as'=>'userskillDelete','middleware' => ['permission:tools-usersskills']]);

      //Dashboards
      Route::get('dashboardLoad', ['uses'=>'DashboardController@load','as'=>'dashboardLoad','middleware' => ['permission:dashboard-view']]);
      Route::get('dashboardLoadChart', ['uses'=>'DashboardController@load_chart','as'=>'dashboardLoadChart','middleware' => ['permission:dashboard-view']]);
      Route::get('clusterdashboard/{year?}/{customer_id?}/{domain_selected?}', ['uses'=>'DashboardController@clusterboard','as'=>'clusterdashboard','middleware' => ['permission:cluster-view']]);
      Route::get('dashboarddscisc/{year?}', ['uses'=>'DashboardController@dscisc','as'=>'dashboarddscisc','middleware' => ['permission:dashboard-view']]);
      Route::get('revenuedashboard/{year?}/{user_id?}', ['uses'=>'DashboardController@revenue','as'=>'revenuedashboard','middleware' => ['permission:dashboardRevenue-view']]);
      Route::get('orderdashboard/{year?}/{user_id?}', ['uses'=>'DashboardController@order','as'=>'orderdashboard','middleware' => ['permission:dashboardOrder-view']]);
      //  AJAX
      Route::post('listOfLoadPerUserAjax', ['uses'=>'ActivityController@listOfLoadPerUserAjax','as'=>'listOfLoadPerUserAjax','middleware' => ['permission:dashboard-view']]);
      Route::post('listOfLoadPerUserChartAjax', ['uses'=>'ActivityController@listOfLoadPerUserChartAjax','as'=>'listOfLoadPerUserChartAjax','middleware' => ['permission:dashboard-view']]);
      // Skills
      //  Main skill list
      Route::get('skillList', ['uses'=>'SkillController@getList','as'=>'skillList','middleware' => ['permission:user-view|user-create|user-edit|user-delete']]);
      //  skill information
      Route::get('skill/{n}', ['uses'=>'SkillController@show','as'=>'skill','middleware' => ['permission:user-view']]);
      //  Create new skill
      Route::get('skillFormCreate', ['uses'=>'SkillController@getFormCreate','as'=>'skillFormCreate','middleware' => ['permission:user-create']]);
      Route::post('skillFormCreate', ['uses'=>'SkillController@postFormCreate','middleware' => ['permission:user-create']]);
      //  Update skill
      Route::get('skillFormUpdate/{n}', ['uses'=>'SkillController@getFormUpdate','as'=>'skillFormUpdate','middleware' => ['permission:user-edit']]);
      Route::post('skillFormUpdate/{n}', ['uses'=>'SkillController@postFormUpdate','middleware' => ['permission:user-edit']]);
      //  Delete skill
      Route::get('skillDelete/{n}', ['uses'=>'SkillController@delete','as'=>'skillDelete','middleware' => ['permission:user-delete']]);
      //  AJAX
      Route::post('listOfSkillsAjax', ['uses'=>'SkillController@listOfSkills','as'=>'listOfSkillsAjax','middleware' => ['permission:user-view|user-create|user-edit|user-delete']]);

});

//Route::get('test', ['uses'=>'ActivityController@test']);
