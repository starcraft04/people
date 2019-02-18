@extends('layouts.app')

@section('content')

<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>User</h3>
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
        <h2>Info</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content" align="center">
        <br />
        <h2><p align="center" > {!! $user->name !!}</p></h2>
      

        <div class="row" style="width: 70%;" align="left">

          <div class="col-sm-12" style="background-color:lavender;">
          <p> <b> Manager Name: </b> 
            @if(isset($manager[0]))
              {!! $manager[0]->name !!}</p>
            @else
              None.
            @endif
          </div>

          <div class="col-sm-12" style="background-color:lavenderblush;">
          <p> <b>Email:</b>  {!! $user->email !!}</p>
          </div>
          <div class="col-sm-12" style="background-color:lavender;">
          <p> <b>Activity status: </b> {!! $user->activity_status !!}</p>
          </div>
          <div class="col-sm-12" style="background-color:lavender;">
          <p> <b>Date started: </b> {!! $user->date_started !!}</p>
          </div>
          <div class="col-sm-12" style="background-color:lavender;">
          <p> <b>Date ended: </b> {!! $user->date_ended !!}</p>
          </div>
          <div class="col-sm-12" style="background-color:lavenderblush;">
          <p> <b>Type: </b> {!! $user->employee_type !!}</p>
          </div>

          <div class="col-sm-12" style="background-color:lavender;">
          <p> <b>Team:</b>  {!! $user->job_role !!}</p>
          </div>
          <div class="col-sm-12" style="background-color:lavenderblush;">
          <p> <b>Region:</b>  {!! $user->region !!}</p>
          </div>

          <div class="col-sm-12" style="background-color:lavender;">
          <p> <b>Country:</b>  {!! $user->country !!}</p>
          </div>

          <div class="col-sm-12" style="background-color:lavenderblush;">
          <p> <b>Managed clusters:</b>
            @if(!empty($userCluster))
               
                 {{ implode(' - ', $userCluster) }}

            @else
      
              None.

            @endif
          </p>
          </div>

          <div class="col-sm-12" style="background-color:lavenderblush;">
          <p> <b>Domain: </b> {!! $user->domain !!}</p>
          </div>
          <div class="col-sm-12" style="background-color:lavender;">
          <p> <b>Management code:</b>  {!! $user->management_code !!}</p>
          </div>


        </div>

      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->

@stop
