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

@endsection
