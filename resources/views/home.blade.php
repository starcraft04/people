@extends('layouts.app')

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Home</h3>
  </div>
</div>
<div class="clearfix"></div>
<!-- Page title -->

<!-- Window -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window title -->
      <div class="x_title">
        <h2>General<small>info</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <br />
        @if($employee_list)
        <div class="row">
        <div class="col-md-2"><b>User name</b></div><div class="col-md-2"><b>Last login</b></div><div class="col-md-2"><b>Last update</b></div>
        </div>
        @foreach($employee_list as $employee)
        <div class="row">
        <div class="col-md-2">{{$employee->name}}</div><div class="col-md-2">{{$employee->last_login}}</div><div class="col-md-2">{{$employee->last_activity_update}}</div>
        </div>
        @endforeach
        
        @else
        You are logged in!
        @endif
      </div>
      <!-- Window content -->
      
    </div>
  </div>
</div>
<!-- Window -->

@can('home-extrainfo')
<!-- Window -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window title -->
      <div class="x_title">
        <h2>Message from<small>admin</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <br />
        <b>USERS</b>
        <br />
        When creating or editing a user, a role needs to be selected:
        <br />
        <u>User</u>: able to enter working days on existing projects
        <br />
        <u>User-extended</u>: same as user with the addition to create a project
        <br />
        <u>Manager</u>: same as user-extend with the addition to do this for his team
        <br />
        <u>Super-manager</u>: same as manager with the addition to connect to the database management menu to add new users and modify roles
        <br />
        <u>Admin</u>: full access rights including modification of roles and mass update in the database
        <br />
        For your information, if needed, the admin can create other roles with more granularity…
        <br />
        <br />
        <b>CUSTOMERS</b>
        <br />
        If you are super-manager, you have access to the customers list which was coming from the One Truth file. In case an employee creates a project for a customer that is not in the list, he cans select other customer from <country>. Another solution is for you to add the customer in the DB in DB Management / Customers list. Be careful of duplicates!!!
        <br />
        <br />
        <b>SKILLS</b>
        <br />
        If you would like to add new skills available to the employees, you can just go in DB Management/Skills list and add or edit the list. Be careful on what you do and don’t delete existing skills as it will not be available anymore.
        <br />
        <br />
        <b>PASSWORD</b>
        <br />
        Because of the security of the environment it is impossible to have a mail access on the server (their firewalls block those ports). This means that password reset function cannot work L. If someone from your team doesn’t remember his password, you can go in DB Management / Users list, search the name and edit it, there you will be able to enter a new password for him. If you are the manager and you forgot your own (Jean, I point to no one J), then you have no choice but to come back to me.

      </div>
      <!-- Window content -->
      
    </div>
  </div>
</div>
<!-- Window -->
@endcan

@endsection
