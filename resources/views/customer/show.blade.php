@extends('layouts.app')

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Customer</h3>
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
      <div class="x_content">

        <table class="table table-striped table-hover table-bordered mytable" width="100%">
          <tr>
            <th >Customer Name</th>
            <th >Cluster Owner</th>
            <th >Country Owner</th>
            <th >Projects</th>
            <th >IC01 Information</th>
          </tr>
          <tr>
            <td >{!! $customer->name !!}</td>
            <td rowspan="10">
              @foreach($ic01_codes as $key => $value)
                <p>{{$key}} {{$value}}</p><br>
              @endforeach
            </td>
            <td >{!! $customer->cluster_owner !!}</td>
            <td >{!! $customer->country_owner !!}</td>          
            <td >
              @foreach($projects_of_the_customer as $key => $value)
                  {{$value->project_name}}<br>
              @endforeach
            </td>
            
          </tr>
        </table>
        
        
      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->

@stop
