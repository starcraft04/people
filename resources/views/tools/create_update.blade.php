@extends('layouts.app')

@section('style')
<!-- CSS -->
<!-- Select2 -->
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/css/forms.css') }}" rel="stylesheet" />
<!-- bootstrap-daterangepicker -->
<link href="{{ asset('/plugins/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
<link href="{{ asset('/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@stop

@section('scriptsrc')
<!-- JS -->
<!-- Select2 -->
<script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('/plugins/gentelella/vendors/moment/min/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/sweetalert2/sweetalert2.min.js') }}" type="text/javascript"></script>
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Project </h3>
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
        <h2>
          @if($action == 'create')
          Create project
          @elseif($action == 'update')
          Update project {{ isset($created_by_user_name) ? '(created by user '.$created_by_user_name.')' : '' }}
          @if($user_id != 0)
          <button id="project_info" class="btn btn-success btn-sm">info</button>
          @endif
          @endif
        </h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible">
              <button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
              {{ $message }}
            </div>
            @endif
            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible">
              <button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
              {{ $message }}
            </div>
            @endif

            @if($action == 'create')
            {!! Form::open(['url' => 'toolsFormCreate', 'method' => 'post']) !!}
            {!! Form::hidden('created_by_user_id', $created_by_user_id, ['class' => 'form-control']) !!}
            @elseif($action == 'update')
            {!! Form::open(['url' => 'toolsFormUpdate', 'method' => 'post']) !!}
            {!! Form::hidden('project_id', $project->id, ['class' => 'form-control']) !!}
            <!-- Now we need also to set up id so that it can be used for the ProjectUpdateRequest.php -->
            {!! Form::hidden('id', $project->id, ['class' => 'form-control']) !!}
            @endif


            <div class="row">
              <div class="col-md-offset-1 col-md-1">
                <a href="javascript:history.back()" class="btn btn-primary btn-sm">
                  <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
                </a>
              </div>
              <div class="col-md-offset-9 col-md-1">
                @if($action == 'create')
                {!! Form::submit('Create', ['class' => 'btn btn-success btn-sm']) !!}
                @elseif($action == 'update')
                {!! Form::submit('Update', ['class' => 'btn btn-success btn-sm']) !!}
                @endif
              </div>
            </div>
            <div class="ln_solid"></div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group {!! $errors->has('user_id') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-1">
                    {!! Form::label('user_id', 'User', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-11">
                    <select class="form-control select2" style="width: 100%;" id="user_id" name="user_id" data-placeholder="Select a user to be assigned">
                      <option value="" ></option>
                      @foreach($user_list as $key => $value)
                      <option value="{{ $key }}" <?php if ($key == $user_selected) { echo 'selected'; }?>>{{ $value }}</option>
                      @endforeach
                    </select>
                    {!! $errors->first('user_id', '<small class="help-block">:message</small>') !!}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="user_selected form-group {!! $errors->has('year') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-1">
                        {!! Form::label('year', 'year', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-11">
                        {!! Form::select('year', config('select.year'), (isset($year)) ? $year : '', ['class' => 'form-control']) !!}
                        {!! $errors->first('year', '<small class="help-block">:message</small>') !!}
                    </div>
                </div>
              </div>
            </div>

            <div class="row_months user_selected">
              <div class="col-md-12">
                Number of days for each month.
              </div>
            </div>
            <div class="row_months user_selected">
              @if($action == 'create')
              @for($i = 1; $i <= 12; $i++)
              <div class="form-group {!! $errors->has('month['.$i.']') ? 'has-error' : '' !!} col-md-1">
                {!! Form::label('month['.$i.']', config('select.month_names')[$i], ['class' => 'control-label']) !!}
                {!! Form::text('month['.$i.']',0, ['class' => 'form-control', 'placeholder' => config('select.month_names')[$i]]) !!}
                {!! $errors->first('month['.$i.']', '<small class="help-block">:message</small>') !!}
              </div>
              @endfor
              @elseif($action == 'update')
              @for($i = 1; $i <= 12; $i++)
              <div class="form-group {!! $errors->has('month['.$i.']') ? 'has-error' : '' !!} col-md-1">
                {!! Form::label('month['.$i.']', config('select.month_names')[$i], ['class' => 'control-label']) !!}
                {!! Form::text('month['.$i.']',isset($activities[$i]) ? $activities[$i] : 0, ['class' => 'form-control', 'placeholder' => config('select.month_names')[$i],!empty($from_otl[$i]) ? 'disabled' : '']) !!}
                {!! $errors->first('month['.$i.']', '<small class="help-block">:message</small>') !!}
              </div>
              @endfor
              @endif
            </div>

            <div class="clearfix"></div>
            <div class="ln_solid"></div>

            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="form-group {!! $errors->has('project_name') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('project_name', 'Project name', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      {!! Form::text('project_name', (isset($project->project_name)) ? $project->project_name : '', ['class' => 'form-control', 'placeholder' => 'project name',$edit_project_name]) !!}
                      {!! $errors->first('project_name', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('customer_name') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('customer_name', 'Customer name', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      {!! Form::text('customer_name', (isset($project->customer_name)) ? $project->customer_name : '', ['class' => 'form-control', 'placeholder' => 'customer name',$edit_project_name]) !!}
                      {!! $errors->first('customer_name', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('otl_project_code') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('otl_project_code', 'OTL project code', ['class' => 'control-label']) !!}
                      <a id="help_otl" href="#">(?)</a>
                    </div>
                    <div class="col-md-9">
                      {!! Form::text('otl_project_code', (isset($project->otl_project_code)) ? $project->otl_project_code : '', ['class' => 'form-control', 'placeholder' => 'OTL project code',$edit_otl_name]) !!}
                      {!! $errors->first('otl_project_code', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('otl_project_code') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('meta_activity', 'Meta-activity', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      <select class="form-control select2" style="width: 100%;" id="meta_activity" name="meta_activity" data-placeholder="Select a meta-activity">
                        <option value="" ></option>
                        @foreach(config('select.meta_activity') as $key => $value)
                        <option value="{{ $key }}" <?php if (isset($project->meta_activity) && $value == $project->meta_activity) { echo 'selected'; }?>>{{ $value }}</option>
                        @endforeach
                      </select>
                      {!! $errors->first('otl_project_code', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('project_type') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('project_type', 'Project type', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      <select class="form-control select2" style="width: 100%;" id="project_type" name="project_type" data-placeholder="Select a project type">
                        <option value="" ></option>
                        @foreach(config('select.project_type') as $key => $value)
                        <option value="{{ $key }}" <?php if (isset($project->project_type) && $value == $project->project_type) { echo 'selected'; }?>>{{ $value }}</option>
                        @endforeach
                      </select>
                      {!! $errors->first('project_type', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('activity_type') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('activity_type', 'Activity type', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      <select class="form-control select2" style="width: 100%;" id="activity_type" name="activity_type" data-placeholder="Select an activity type">
                        <option value="" ></option>
                        @foreach(config('select.activity_type') as $key => $value)
                        <option value="{{ $key }}" <?php if (isset($project->activity_type) && $value == $project->activity_type) { echo 'selected'; }?>>{{ $value }}</option>
                        @endforeach
                      </select>
                      {!! $errors->first('activity_type', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('project_status') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('project_status', 'Project status', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      <select class="form-control select2" style="width: 100%;" id="project_status" name="project_status" data-placeholder="Select a project status">
                        <option value="" ></option>
                        @foreach(config('select.project_status') as $key => $value)
                        <option value="{{ $key }}" <?php if (isset($project->project_status) && $value == $project->project_status) { echo 'selected'; }?>>{{ $value }}</option>
                        @endforeach
                      </select>
                      {!! $errors->first('project_status', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('region') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('region', 'Region', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      <select class="form-control select2" style="width: 100%;" id="region" name="region" data-placeholder="Select a region">
                        <option value="" ></option>
                        @foreach(config('select.region') as $key => $value)
                        <option value="{{ $key }}" <?php if (isset($project->region) && $value == $project->region) { echo 'selected'; }?>>{{ $value }}</option>
                        @endforeach
                      </select>
                      {!! $errors->first('region', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('country') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('country', 'Country', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      <select class="form-control select2" style="width: 100%;" id="country" name="country" data-placeholder="Select a country">
                        <option value="" ></option>
                        @foreach(config('select.country') as $key => $value)
                        <option value="{{ $key }}" <?php if (isset($project->country) && $value == $project->country) { echo 'selected'; }?>>{{ $value }}</option>
                        @endforeach
                      </select>
                      {!! $errors->first('country', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('customer_location') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('customer_location', 'Customer location', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      {!! Form::text('customer_location', (isset($project)) ? $project->customer_location : '', ['class' => 'form-control', 'placeholder' => 'customer location']) !!}
                      {!! $errors->first('customer_location', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('technology') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('technology', 'Technology', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      {!! Form::text('technology', (isset($project)) ? $project->technology : '', ['class' => 'form-control', 'placeholder' => 'technology']) !!}
                      {!! $errors->first('technology', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('description', 'description', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      {!! Form::text('description', (isset($project)) ? $project->description : '', ['class' => 'form-control', 'placeholder' => 'description']) !!}
                      {!! $errors->first('description', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('comments') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('comments', 'Comments', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      {!! Form::text('comments', (isset($project)) ? $project->comments : '', ['class' => 'form-control', 'placeholder' => 'Comments']) !!}
                      {!! $errors->first('comments', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="form-group {!! $errors->has('estimated_date') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('estimated_date', 'Estimated start to end date', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      <div class="control-group">
                        <div class="controls">
                          <div class="input-prepend input-group">
                            <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                            <input type="text" style="width: 200px" name="estimated_date" id="estimated_date" class="form-control" />

                          </div>
                          {!! $errors->first('estimated_date', '<small class="help-block">:message</small>') !!}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('LoE_onshore') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('LoE_onshore', 'LoE onshore (days)', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      {!! Form::text('LoE_onshore', (isset($project)) ? $project->LoE_onshore : '', ['class' => 'form-control', 'placeholder' => 'LoE onshore (days)']) !!}
                      {!! $errors->first('LoE_onshore', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('LoE_nearshore') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('LoE_nearshore', 'LoE nearshore (days)', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      {!! Form::text('LoE_nearshore', (isset($project)) ? $project->LoE_nearshore : '', ['class' => 'form-control', 'placeholder' => 'LoE nearshore (days)']) !!}
                      {!! $errors->first('LoE_nearshore', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('LoE_offshore') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('LoE_offshore', 'LoE offshore (days)', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      {!! Form::text('LoE_offshore', (isset($project)) ? $project->LoE_offshore : '', ['class' => 'form-control', 'placeholder' => 'LoE offshore (days)']) !!}
                      {!! $errors->first('LoE_offshore', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('LoE_contractor') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('LoE_contractor', 'LoE contractor (days)', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      {!! Form::text('LoE_contractor', (isset($project)) ? $project->LoE_contractor : '', ['class' => 'form-control', 'placeholder' => 'LoE contractor (days)']) !!}
                      {!! $errors->first('LoE_contractor', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('gold_order_number') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('gold_order_number', 'Gold order', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      {!! Form::text('gold_order_number', (isset($project)) ? $project->gold_order_number : '', ['class' => 'form-control', 'placeholder' => 'Gold order']) !!}
                      {!! $errors->first('gold_order_number', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('product_code') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('product_code', 'Product code', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      {!! Form::text('product_code', (isset($project)) ? $project->product_code : '', ['class' => 'form-control', 'placeholder' => 'Product code']) !!}
                      {!! $errors->first('product_code', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('revenue') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('revenue', 'Revenue (k€)', ['class' => 'control-label', 'id' => 'revenue_text']) !!}
                    </div>
                    <div class="col-md-9">
                      {!! Form::text('revenue', (isset($project)) ? $project->revenue : '', ['class' => 'form-control', 'placeholder' => 'Revenue (€)']) !!}
                      {!! $errors->first('revenue', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group {!! $errors->has('win_ratio') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-3">
                      {!! Form::label('win_ratio', 'Win ratio (%)', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-md-9">
                      {!! Form::text('win_ratio', (isset($project)) ? $project->win_ratio : '', ['class' => 'form-control', 'placeholder' => 'Win ratio (%)']) !!}
                      {!! $errors->first('win_ratio', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="row"></div>
              <div class="row"></div>
            </div>


            {!! Form::close() !!}

      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->


@stop

@section('script')


<script>
var year;

$(document).ready(function() {

  if($( "#project_type option:selected" ).text() == "Baseline"){
    $('#revenue_text').text("MRC (k€)");
    $("#revenue").attr("placeholder", "MRC (k€)");
  } else {
    $('#revenue_text').text("Revenue (k€)");
    $("#revenue").attr("placeholder", "Revenue (k€)");
  }

  $(document).on('click', '#help_otl', function () {
    swal({
      title: 'How to enter the correct OTL code',
      width: '80%',
      animation: false,
      html:
        'You can fin the <b>OTL code</b> and the <b>Meta-activity</b> by login into OTL and find the below fields</BR></BR></BR>' +
        '<img src="{{ asset("/img/help/OTL_help.jpg") }}">'
    });
  } );

  @if(isset($user_id) && $user_id != 0)
  $(document).on('click', '#project_info', function () {
    swal({
      title: 'Project info',
      width: '80%',
      animation: false,
      html:
        '<div class="row">'+
        '<div style="text-align: left;"><h3>OTL forecast comparison ({{$year}})</h3></div>'+
        '<table class="table">'+
        '<thead><th></th><th>Jan</th><th>Feb</th><th>Mar</th><th>Apr</th><th>May</th><th>Jun</th><th>Jul</th><th>Aug</th><th>Sep</th><th>Oct</th><th>Nov</th><th>Dec</th><thead>'+
        '<tbody>'+
        '<tr>'+
        '<td><b>OTL</b></td><td>{{$otl[1]}}</td><td>{{$otl[2]}}</td><td>{{$otl[3]}}</td><td>{{$otl[4]}}</td><td>{{$otl[5]}}</td><td>{{$otl[6]}}</td><td>{{$otl[7]}}</td><td>{{$otl[8]}}</td><td>{{$otl[9]}}</td><td>{{$otl[10]}}</td><td>{{$otl[11]}}</td><td>{{$otl[12]}}</td>'+
        '</tr>'+
        '<tr>'+
        '<td><b>Forecast</b></td><td>{{$forecast[1]}}</td><td>{{$forecast[2]}}</td><td>{{$forecast[3]}}</td><td>{{$forecast[4]}}</td><td>{{$forecast[5]}}</td><td>{{$forecast[6]}}</td><td>{{$forecast[7]}}</td><td>{{$forecast[8]}}</td><td>{{$forecast[9]}}</td><td>{{$forecast[10]}}</td><td>{{$forecast[11]}}</td><td>{{$forecast[12]}}</td>'+
        '</tr>'+
        '</tbody>'+
        '</table>'+
        '</div>'+
        '<div class="row">'+
        '<div style="text-align: left;"><h3>LoE</h3></div>'+
        '</div>'+

        //onshore
        '<div class="row">'+
        '<div class="row">'+
        '<div class="col-sm-12 text-left" style="padding-bottom: 10px;">LoE onshore ({!! $project->LoE_onshore !!} days)</div>'+
        '</div>'+
        @foreach($loe_list as $loe)
        @if($loe->user_employee_type == 'onshore')
        '<div class="row">'+
        '<div class="col-sm-3 text-right">{{ $loe->user_name }} ({{ $loe->year }}):</div><div class="col-sm-9 text-left">{{ $loe->LoE }} days</div>'+
        '</div>'+
        @endif
        @endforeach
        '</div>'+
        //nearshore
        '<div class="row">'+
        '<div class="row">'+
        '<div class="col-sm-12 text-left" style="padding-top: 10px;padding-bottom: 10px;">LoE nearshore ({!! $project->LoE_nearshore !!} days)</div>'+
        '</div>'+
        @foreach($loe_list as $loe)
        @if($loe->user_employee_type == 'nearshore')
        '<div class="row">'+
        '<div class="col-sm-3 text-right">{{ $loe->user_name }} ({{ $loe->year }}):</div><div class="col-sm-9 text-left">{{ $loe->LoE }} days</div>'+
        '</div>'+
        @endif
        @endforeach
        '</div>'+
        //offshore
        '<div class="row">'+
        '<div class="row">'+
        '<div class="col-sm-12 text-left" style="padding-top: 10px;padding-bottom: 10px;">LoE offshore ({!! $project->LoE_offshore !!} days)</div>'+
        '</div>'+
        @foreach($loe_list as $loe)
        @if($loe->user_employee_type == 'offshore')
        '<div class="row">'+
        '<div class="col-sm-3 text-right">{{ $loe->user_name }} ({{ $loe->year }}):</div><div class="col-sm-9 text-left">{{ $loe->LoE }} days</div>'+
        '</div>'+
        @endif
        @endforeach
        '</div>'+
        //contractor
        '<div class="row">'+
        '<div class="row">'+
        '<div class="col-sm-12 text-left" style="padding-top: 10px;">LoE contractor ({!! $project->LoE_contractor !!} days)</div>'+
        '</div>'+
        @foreach($loe_list as $loe)
        @if($loe->user_employee_type == 'contractor')
        '<div class="row">'+
        '<div class="col-sm-3 text-right">{{ $loe->user_name }} ({{ $loe->year }}):</div><div class="col-sm-9 text-left">{{ $loe->LoE }} days</div>'+
        '</div>'+
        @endif
        @endforeach
        '</div>'

    });
  } );
  @endif

  // Now this is important so that we send the value of all disabled fields
  // What it does is when you try to submit, it will remove the disabled property on all fields with disabled
  jQuery(function ($) {
    $('form').bind('submit', function () {
      $(this).find(':input').prop('disabled', false);
    });
  });

  if($('#user_id').val()===""){
    console.log('empty');
    $('.user_selected').hide();
  }
  else {
    console.log('not empty');
    $('.user_selected').show();
  }

  $('#user_id').change(function() {
    if($(this).val()===""){
      console.log('empty');
      $('.user_selected').hide();
    }
    else {
      console.log('not empty');
      $('.user_selected').show();
    }
  });

  $('#project_type').change(function() {
    if($(this).val()==="Baseline"){
      $('#revenue_text').text("MRC (k€)");
      $("#revenue").attr("placeholder", "MRC (k€)");
    }
    else {
      $('#revenue_text').text("Revenue (k€)");
      $("#revenue").attr("placeholder", "Revenue (k€)");
    }
  });

  // init DateRange picker
  $('#estimated_date').daterangepicker({
    locale: {
    format: 'YYYY-MM-DD'
    },
    showISOWeekNumbers: true,
    showDropdowns: true
    @if(isset($project->estimated_start_date))
    ,
    startDate: '{{ $project->estimated_start_date }}',
    endDate: '{{ $project->estimated_end_date }}'
    @endif
  });
  //Init select2 boxes
  $("#user_id").select2({
    allowClear: true,
    disabled: {{ $user_select_disabled }}
  });

  $("#year").select2({
    allowClear: false
  });

  $("#meta_activity").select2({
    allowClear: true,
    disabled: {{ $meta_activity_select_disabled }}
  });

  $("#project_type").select2({
    allowClear: true,
    disabled: {{ $project_type_select_disabled }}
  });

  $("#activity_type").select2({
    allowClear: true,
    disabled: {{ $activity_type_select_disabled }}
  });

  $("#project_status").select2({
    allowClear: true,
    disabled: {{ $project_status_select_disabled }}
  });

  $("#region").select2({
    allowClear: true,
    disabled: {{ $region_select_disabled }}
  });

  $("#country").select2({
    allowClear: true,
    disabled: {{ $country_select_disabled }}
  });

  @if($action == 'update')
    $('#year').on('change', function() {
        year=$(this).val();
        window.location.href = "{!! route('toolsFormUpdate',[$user_id,$project->id,'']) !!}"+"/"+year;
    });
  @endif

});
</script>


@stop
