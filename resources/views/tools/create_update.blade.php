@extends('layouts.app')

@section('style')
<!-- CSS -->
<!-- Select2 -->
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/css/forms.css') }}" rel="stylesheet" />
<!-- bootstrap-daterangepicker -->
<link href="{{ asset('/plugins/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
<link href="{{ asset('/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
<!-- Switchery -->
<link href="{{ asset('/plugins/gentelella/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
<!-- Datatables -->
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
<!-- Progressbar -->
<link href="{{ asset('/plugins/gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
<!-- Range slider -->
<link href="{{ asset('/plugins/gentelella/vendors/ion.rangeSlider/css/ion.rangeSlider.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/ion.rangeSlider/css/ion.rangeSlider.skinModern.css') }}" rel="stylesheet">
<!-- Document styling -->
<style>
h3 {
  overflow: hidden;
  text-align: center;
}

h3:before,
h3:after {
  background-color: #000;
  content: "";
  display: inline-block;
  height: 1px;
  position: relative;
  vertical-align: middle;
  width: 50%;
}

h3:before {
  right: 0.5em;
  margin-left: -50%;
}

h3:after {
  left: 0.5em;
  margin-right: -50%;
}
.label_error {
  color: red;
}
</style>
@stop

@section('scriptsrc')
<!-- JS -->
<!-- Select2 -->
<script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('/plugins/gentelella/vendors/moment/min/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/sweetalert2/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/switchery/dist/switchery.min.js') }}" type="text/javascript"></script>
<!-- Bootbox -->
<script src="{{ asset('/plugins/bootbox/bootbox.min.js') }}"></script>
<!-- Balloon -->
<script src="{{ asset('/plugins/balloon/jquery.balloon.min.js') }}" type="text/javascript"></script>
<!-- DataTables -->
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/buttons.colVis.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/jszip/dist/jszip.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/pdfmake/build/pdfmake.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/pdfmake/build/vfs_fonts.js') }}" type="text/javascript"></script>
<!-- Switchery -->
<script src="{{ asset('/plugins/gentelella/vendors/switchery/dist/switchery.min.js') }}" type="text/javascript"></script>
<!-- Progressbar -->
<script src="{{ asset('/plugins/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}" type="text/javascript"></script>
<!-- Range slider -->
<script src="{{ asset('/plugins/gentelella/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js') }}" type="text/javascript"></script>
@stop

@section('content')
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
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
          <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
            <li role="presentation" class="active"><a href="#tab_content1" id="tab_main" role="tab" data-toggle="tab" aria-expanded="true">Project</a></li>
            @if($action == 'update')
              @can('projectRevenue-create')
              <li role="presentation"><a href="#tab_content2" id="tab_revenue" role="tab" data-toggle="tab" aria-expanded="true">Revenue</a></li>
              @endcan
              @can('projectLoe-view')
              <li role="presentation"><a href="#tab_content4" id="tab_loe" role="tab" data-toggle="tab" aria-expanded="true">LoE</a></li>
              @endcan
              @can('action-view')
              <li role="presentation"><a href="#tab_content5" id="tab_action" role="tab" data-toggle="tab" aria-expanded="true">Actions (<span id="num_of_actions">{{ $num_of_actions }}</span>)</a></li>
              @endcan
              @can('tools-projects-comments')
              <li role="presentation"><a href="#tab_content3" id="tab_comment" role="tab" data-toggle="tab" aria-expanded="true">Comments (<span id="num_of_comments">{{ $num_of_comments }}</span>)</a></li>
              @endcan
            @endif
          </ul>

          <div id="myTabContent" class="tab-content">
            <!-- Project -->
            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="tab_main">
              @if($action == 'create')
                {!! Form::open(['url' => 'toolsFormCreate', 'method' => 'post', 'id' => 'projectForm']) !!}
                {!! Form::hidden('created_by_user_id', $created_by_user_id, ['class' => 'form-control']) !!}
              @elseif($action == 'update')
                {!! Form::open(['url' => 'toolsFormUpdate', 'method' => 'post', 'id' => 'projectForm']) !!}
                {!! Form::hidden('project_id', $project->id, ['class' => 'form-control']) !!}
                <!-- Now we need also to set up id so that it can be used for the ProjectUpdateRequest.php -->
                {!! Form::hidden('id', $project->id, ['class' => 'form-control']) !!}
                {!! Form::hidden('user_id_url', $user_id, ['class' => 'form-control']) !!}
              @endif
              <!-- Row with buttons -->
              <div class="row">
                <div class="col-md-1">
                  <a href="javascript:history.back()" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
                  </a>
                </div>
                <div class="col-md-offset-8 col-md-1" style="text-align: right;">
                  @if($action == 'update')
                  @can('tools-user_assigned-remove')
                  @if($user_id != 0)
                  <button type="button" id="remove_user" class="btn btn-danger btn-sm">Remove user</button>
                  @endif
                  @endcan
                  @endif
                </div>
                <div class="col-md-1" style="text-align: right;">
                  @if($action == 'update')
                  @can('tools-user_assigned-transfer')
                  @if($user_id != 0)
                  <button type="button" id="transfer_user" class="btn btn-info btn-sm">Transfer</button>
                  @endif
                  @endcan
                  @endif
                </div>
                <div class="col-md-1" style="text-align: right;">
                  @if($action == 'create')
                  <input class="btn btn-success btn-sm" type="submit" name="action" value="Create" />
                  @elseif($action == 'update')
                  <input class="btn btn-success btn-sm" type="submit" name="action" value="Update" />
                  @endif
                </div>
              </div>

              <!-- Row with User and Year -->
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group {!! $errors->has('user_id') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-1">
                      {!! Form::label('user_id', 'User', ['class' => 'control-label']) !!}
                      @if($action == 'update')
                      @if($show_change_button)
                      <span class="glyphicon glyphicon-refresh" id="change_user"></span>
                      @endif
                      @endif
                    </div>
                    <div class="col-md-11">
                      <select class="form-control select2" style="width: 100%;" id="user_id" name="user_id" data-placeholder="Select a user to be assigned">
                        <option value="" ></option>
                        @foreach($user_list as $key => $value)
                        <option value="{{ $key }}"
                          @if (old('user_id') == $key) selected
                          @elseif ($key == $user_selected) selected
                          @endif>
                          {{ $value }}
                        </option>
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

              <!-- Row with months and values -->
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

              <!-- Row with Project details -->
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="form-group {!! $errors->has('project_name') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('project_name', 'Project name *', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('project_name', (isset($project->project_name)) ? $project->project_name : '', 
                        ['class' => 'form-control mandatory', 
                        'placeholder' => 'project name',
                        'title' => "<p>The only mandatory fields to save the project have a * next to them and are:</BR>
                                      <ul>
                                        <li>Project name</li>
                                        <li>Customer name</li>
                                        <li>Each month (leave 0 if you don't know yet or if nothing to be entered for a specific month.</li>
                                      </ul>
                                    </p>
                                    ",
                        $project_name_disabled
                        ]) !!}
                        {!! $errors->first('project_name', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('customer_id') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('customer_id', 'Customer name *', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        <select class="form-control select2" style="width: 100%;" id="customer_id" name="customer_id" data-placeholder="Select a customer name">
                          @foreach($customers_list as $key => $value)
                          <option value="{{ $key }}"
                            @if (old('customer_id') == $key) selected
                            @elseif (isset($project->customer_id) && $key == $project->customer_id) selected
                            @endif>
                            {{ $value }}
                          </option>
                          @endforeach
                        </select>
                        {!! $errors->first('customer_id', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('otl_project_code') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('otl_project_code', 'Prime project code', ['class' => 'control-label']) !!}
                        <a id="help_otl" href="#">(?)</a>
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('otl_project_code', (isset($project->otl_project_code)) ? $project->otl_project_code : '', 
                        ['class' => 'form-control OTL_code', 
                        'placeholder' => 'Prime project code',
                        'title' => "<p>This field is NOT mandatory.</BR>
                                    If you do not know the OTL code yet, then do not enter the OTL code nor the Meta-activity.</BR>
                                    You can come back later to edit it when you will have the right OTL code.</BR>
                                    But if you enter either the OTL code or the Meta-activity, then you will need to fill in the other one too.</BR></p>
                                    <p>Also, keep in mind that the OTL data is fetched every month in this tool for the existing OTL code </BR>
                                    so if you enter the OTL code, you will need to wait the 5th of the month to see the values.</p>
                                    ",
                        $otl_name_disabled]
                        ) !!}
                        {!! $errors->first('otl_project_code', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('meta_activity') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('meta_activity', 'Meta-activity', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        <select class="form-control select2" style="width: 100%;" id="meta_activity" name="meta_activity" data-placeholder="Select a meta-activity">
                          <option value="" ></option>
                          @foreach(config('select.meta_activity') as $key => $value)
                          <option value="{{ $key }}"
                            @if (old('meta_activity') == $key) selected
                            @elseif (isset($project->meta_activity) && $value == $project->meta_activity) selected
                            @endif>
                            {{ $value }}
                          </option>
                          @endforeach
                        </select>
                        {!! $errors->first('meta_activity', '<small class="help-block">:message</small>') !!}
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
                          <option value="{{ $key }}"
                            @if (old('project_type') == $key) selected
                            @elseif (isset($project->project_type) && $value == $project->project_type) selected
                            @endif>
                            {{ $value }}
                          </option>
                          @endforeach
                        </select>
                        {!! $errors->first('project_type', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('project_subtype') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('project_subtype', ' ', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        <select class="form-control select2" style="width: 100%;" id="project_subtype" name="project_subtype" data-placeholder="Select a sub-type">
                          <option value="" ></option>
                          @foreach(config('select.project_subtype') as $key => $value)
                          <option value="{{ $key }}"
                            @if (old('project_subtype') == $key) selected
                            @elseif (isset($project->project_subtype) && $value == $project->project_subtype) selected
                            @endif>
                            {{ $value }}
                          </option>
                          @endforeach
                        </select>
                        {!! $errors->first('project_subtype', '<small class="help-block">:message</small>') !!}
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
                          <option value="{{ $key }}"
                            @if (old('activity_type') == $key) selected
                            @elseif (isset($project->activity_type) && $value == $project->activity_type) selected
                            @endif>
                            {{ $value }}
                          </option>
                          @endforeach
                        </select>
                        {!! $errors->first('activity_type', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div id="project_status_row" class="row">
                    <div class="form-group {!! $errors->has('project_status') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('project_status', 'Project status', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        <select class="form-control select2" style="width: 100%;" id="project_status" name="project_status" data-placeholder="Select a project status">
                          <option value="" ></option>
                          @foreach(config('select.project_status') as $key => $value)
                          <option value="{{ $key }}"
                            @if (old('project_status') == $key) selected
                            @elseif (isset($project->project_status) && $value == $project->project_status) selected
                            @endif>
                            {{ $value }}
                          </option>
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
                          <option value="{{ $key }}"
                            @if (old('region') == $key) selected
                            @elseif (isset($project->region) && $value == $project->region) selected
                            @endif>
                            {{ $value }}
                          </option>
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
                          @foreach(config('countries.country') as $key => $value)
                          <option value="{{ $key }}"
                            @if (old('country') == $key) selected
                            @elseif (isset($project->country) && $value == $project->country) selected
                            @endif>
                            {{ $value }}
                          </option>
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
                        {!! Form::text('customer_location', (isset($project)) ? $project->customer_location : '', ['class' => 'form-control', 'placeholder' => 'customer location',$customer_location_disabled]) !!}
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
                        {!! Form::text('technology', (isset($project)) ? $project->technology : '', ['class' => 'form-control', 'placeholder' => 'technology',$technology_disabled]) !!}
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
                        {!! Form::text('description', (isset($project)) ? $project->description : '', ['class' => 'form-control', 'placeholder' => 'description',$description_disabled]) !!}
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
                        {!! Form::text('comments', (isset($project)) ? $project->comments : '', ['class' => 'form-control', 'placeholder' => 'Comments',$comments_disabled]) !!}
                        {!! $errors->first('comments', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="estimated_date_row" class="row">
                    <div class="form-group {!! $errors->has('estimated_date') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('estimated_date', 'Estimated start to end date', ['class' => 'control-label', 'id' => 'estimated_date_text']) !!}
                      </div>
                      <div class="col-md-9">
                        <div class="control-group">
                          <div class="controls">
                            <div class="input-prepend input-group">
                              <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                              <input type="text" style="width: 200px" name="estimated_date" id="estimated_date" class="form-control" {{$estimated_date_disabled}} />
                            </div>
                            {!! $errors->first('estimated_date', '<small class="help-block">:message</small>') !!}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row hidden">
                    <div class="form-group {!! $errors->has('LoE_onshore') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('LoE_onshore', 'LoE onshore (days)', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('LoE_onshore', (isset($project)) ? $project->LoE_onshore : '', ['class' => 'form-control', 'placeholder' => 'LoE onshore (days)',$LoE_onshore_disabled]) !!}
                        {!! $errors->first('LoE_onshore', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row hidden">
                    <div class="form-group {!! $errors->has('LoE_nearshore') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('LoE_nearshore', 'LoE nearshore (days)', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('LoE_nearshore', (isset($project)) ? $project->LoE_nearshore : '', ['class' => 'form-control', 'placeholder' => 'LoE nearshore (days)',$LoE_nearshore_disabled]) !!}
                        {!! $errors->first('LoE_nearshore', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row hidden">
                    <div class="form-group {!! $errors->has('LoE_offshore') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('LoE_offshore', 'LoE offshore (days)', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('LoE_offshore', (isset($project)) ? $project->LoE_offshore : '', ['class' => 'form-control', 'placeholder' => 'LoE offshore (days)',$LoE_offshore_disabled]) !!}
                        {!! $errors->first('LoE_offshore', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row hidden">
                    <div class="form-group {!! $errors->has('LoE_contractor') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('LoE_contractor', 'LoE contractor (days)', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('LoE_contractor', (isset($project)) ? $project->LoE_contractor : '', ['class' => 'form-control', 'placeholder' => 'LoE contractor (days)',$LoE_contractor_disabled]) !!}
                        {!! $errors->first('LoE_contractor', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div id="gold_order_row" class="row">
                    <div class="form-group {!! $errors->has('gold_order_number') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('gold_order_number', 'Gold order', ['class' => 'control-label', 'id' => 'gold_order_text']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('gold_order_number', (isset($project)) ? $project->gold_order_number : '', ['class' => 'form-control', 'placeholder' => 'Gold order',$gold_order_disabled]) !!}
                        {!! $errors->first('gold_order_number', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div id="samba_id_row" class="row">
                    <div class="form-group {!! $errors->has('samba_id') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('samba_id', 'CL ID', ['class' => 'control-label', 'id' => 'samba_id_text']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('samba_id', (isset($project)) ? $project->samba_id : '', ['class' => 'form-control', 'placeholder' => 'CL ID',$samba_options_disabled]) !!}
                        {!! $errors->first('samba_id', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div id="pullthru_samba_id_row" class="row">
                    <div class="form-group {!! $errors->has('pullthru_samba_id') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('pullthru_samba_id', 'Pull-Thru CL ID', ['class' => 'control-label', 'id' => 'pullthru_samba_id_text']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('pullthru_samba_id', (isset($project)) ? $project->pullthru_samba_id : '', ['class' => 'form-control', 'placeholder' => 'Pull-Thru CL ID',$samba_options_disabled]) !!}
                        {!! $errors->first('pullthru_samba_id', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div id="samba_opportunity_owner_row" class="row">
                    <div class="form-group {!! $errors->has('samba_opportunit_owner') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('samba_opportunit_owner', 'CL opportunity owner', ['class' => 'control-label', 'id' => 'samba_opportunit_owner_text']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('samba_opportunit_owner', (isset($project)) ? $project->samba_opportunit_owner : '', ['class' => 'form-control', 'placeholder' => 'CL opportunity owner',$samba_options_disabled]) !!}
                        {!! $errors->first('samba_opportunit_owner', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div id="samba_lead_domain_row" class="row">
                    <div class="form-group {!! $errors->has('samba_lead_domain') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('samba_lead_domain', 'CL lead domain', ['class' => 'control-label', 'id' => 'samba_lead_domain_text']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('samba_lead_domain', (isset($project)) ? $project->samba_lead_domain : '', ['class' => 'form-control', 'placeholder' => 'CL lead domain',$samba_options_disabled]) !!}
                        {!! $errors->first('samba_lead_domain', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div id="samba_stage_row" class="row">
                    <div class="form-group {!! $errors->has('samba_stage') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('samba_stage', 'CL stage', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        <select class="form-control select2" style="width: 100%;" id="samba_stage" name="samba_stage" data-placeholder="Select a stage">
                          <option value="" ></option>
                          @foreach(config('select.samba_stage') as $key => $value)
                          <option value="{{ $key }}"
                            @if (old('samba_stage') == $key) selected
                            @elseif (isset($project->samba_stage) && $value == $project->samba_stage) selected
                            @endif>
                            {{ $value }}
                          </option>
                          @endforeach
                        </select>
                        {!! $errors->first('samba_stage', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row hidden">
                    <div class="form-group {!! $errors->has('product_code') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('product_code', 'Product codes', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('product_code', (isset($project)) ? $project->product_code : '', ['class' => 'form-control', 'placeholder' => 'Product codes',$product_code_disabled]) !!}
                        {!! $errors->first('product_code', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div id="revenue_row" class="row">
                    <div class="form-group {!! $errors->has('revenue') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('revenue', 'Order Intake incl. CS (€)', ['class' => 'control-label', 'id' => 'revenue_text']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('revenue', (isset($project)) ? $project->revenue : '', ['class' => 'form-control', 'placeholder' => 'Order Intake incl. CS (€)',$revenue_disabled]) !!}
                        {!! $errors->first('revenue', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div id="samba_consulting_product_tcv_row" class="row">
                    <div class="form-group {!! $errors->has('samba_consulting_product_tcv') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('samba_consulting_product_tcv', 'CL consulting TCV (€)', ['class' => 'control-label', 'id' => 'samba_consulting_product_tcv_text']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('samba_consulting_product_tcv', (isset($project)) ? $project->samba_consulting_product_tcv : '', ['class' => 'form-control', 'placeholder' => 'CL consulting TCV (€)',$samba_options_disabled]) !!}
                        {!! $errors->first('samba_consulting_product_tcv', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div id="samba_pullthru_tcv_row" class="row">
                    <div class="form-group {!! $errors->has('samba_pullthru_tcv') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('samba_pullthru_tcv', 'CL Pull-Thru TCV (€)', ['class' => 'control-label', 'id' => 'samba_pullthru_tcv_text']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('samba_pullthru_tcv', (isset($project)) ? $project->samba_pullthru_tcv : '', ['class' => 'form-control', 'placeholder' => 'CL Pull-Thru TCV (€)',$samba_options_disabled]) !!}
                        {!! $errors->first('samba_pullthru_tcv', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div id="win_ratio_row" class="row">
                    <div class="form-group {!! $errors->has('win_ratio') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('win_ratio', 'Win ratio (%)', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('win_ratio', (isset($project)) ? $project->win_ratio : '', ['class' => 'form-control', 'placeholder' => 'Win ratio (%)',$win_ratio_disabled]) !!}
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
            
            <!-- Project -->

            @if($action == 'update')
              <!-- Revenues -->
              <!-- Table -->
              @can('projectRevenue-create')
              <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="tab_revenue">
                <div class="row">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered mytable" width="100%" id="projectRevenue">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Year</th>
                          <th>FPC</th>
                          <th>Jan</th>
                          <th>feb</th>
                          <th>Mar</th>
                          <th>Apr</th>
                          <th>May</th>
                          <th>Jun</th>
                          <th>Jul</th>
                          <th>Aug</th>
                          <th>Sep</th>
                          <th>Oct</th>
                          <th>Nov</th>
                          <th>Dec</th>
                          <th>
                            @can('projectRevenue-create')
                              <button type="button" id="new_revenue" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
                            @endcan
                          </th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
              <!-- Table -->

              <!-- Modal -->
              <div class="modal fade" id="modal_revenue" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" style="display:table;">
                      <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title" id="modal_revenue_title"></h4>
                        </div>
                        <!-- Modal Header -->
                      
                        <!-- Modal Body -->
                        <div class="modal-body">
                          <form id="modal_revenue_form" role="form" method="POST" action="">
                            <div id="modal_revenue_formgroup_year" class="form-group">
                                <label class="control-label" for="modal_revenue_form_year">Year</label>
                                <select class="form-control select2" style="width: 100%;" id="modal_revenue_form_year" data-placeholder="Select a year">
                                  <option value="" ></option>
                                  @foreach(config('select.year') as $key => $value)
                                  <option value="{{ $key }}" @if($key == date("Y")) selected @endif>
                                    {{ $value }}
                                  </option>
                                  @endforeach
                                </select>
                                <span id="modal_revenue_form_year_error" class="help-block"></span>
                            </div>
                            <div id="modal_revenue_formgroup_product_code" class="form-group">
                                <label  class="control-label" for="modal_revenue_form_product_code">FPC</label>
                                <input type="text" id="modal_revenue_form_product_code" class="form-control" placeholder="FPC"></input>
                                <span id="modal_revenue_form_product_code_error" class="help-block"></span>
                            </div>
                            @foreach(config('select.available_months') as $key => $month)
                            <div id="modal_revenue_formgroup_{{ $month }}" class="form-group">
                                <label  class="control-label" for="modal_revenue_form_{{ $month }}">{{ $month }}</label>
                                <input type="text" id="modal_revenue_form_{{ $month }}" class="form-control" placeholder="{{ $month }}"></input>
                                <span id="modal_revenue_form_{{ $month }}_error" class="help-block"></span>
                            </div>
                            @endforeach

                            <div class="form-group">
                                <div id="modal_revenue_form_hidden"></div>
                            </div>
                          </form>
                        </div>
                          
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" id="modal_revenue_create_update_button" class="btn btn-success"></button>
                        </div>
                      </div>
                  </div>
              </div>
              <!-- Modal -->
              @endcan
              <!-- Revenues -->

              <!-- LoE -->
              @can('projectLoe-view')
              <!-- Table -->
              <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="tab_loe">
                <div class="row">
                <div class="table-responsive">
                  <table class="table table-striped table-hover table-bordered mytable" width="100%" id="projectLoe">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Project ID</th>
                        <th>Customer</th>
                        <th>Project</th>
                        <th>Created by</th>
                        <th>Start date</th>
                        <th>End date</th>
                        <th>Domain</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Man days</th>
                        <th>Description</th>
                        <th>History</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Manager signoff</th>
                        <th>
                          @can('projectLoe-create')
                            <button type="button" id="new_loe" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
                          @endcan
                        </th>
                      </tr>
                    </thead>
                  </table>
                </div>
                </div>
              </div>
              <!-- Table -->

              <!-- Modal -->
              <div class="modal fade" id="modal_loe" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" style="display:table;">
                      <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" id="modal_loe_title"></h4>
                        </div>
                        <!-- Modal Header -->
                      
                        <!-- Modal Body -->
                        <div class="modal-body">
                          <form id="modal_loe_form" role="form" method="POST" action="">
                            <div id="modal_loe_formgroup_domain" class="form-group">
                                <label class="control-label" for="modal_loe_form_domain">Domain</label>
                                <select class="form-control select2" style="width: 100%;" id="modal_loe_form_domain" data-placeholder="Select a domain">
                                  <option value="" ></option>
                                  @foreach(config('select.domain-users') as $key => $value)
                                  <option value="{{ $key }}">
                                    {{ $value }}
                                  </option>
                                  @endforeach
                                </select>
                                <span id="modal_loe_form_domain_error" class="help-block"></span>
                            </div>
                            <div id="modal_loe_formgroup_type" class="form-group">
                                <label class="control-label" for="modal_loe_form_type">Type</label>
                                <select class="form-control select2" style="width: 100%;" id="modal_loe_form_type" data-placeholder="Select a resource type">
                                    <option value="" ></option>
                                    @foreach(config('select.loe_type') as $key => $value)
                                    <option value="{{ $key }}">
                                      {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                                <span id="modal_loe_form_type_error" class="help-block"></span>
                            </div>
                            <div id="modal_loe_formgroup_location" class="form-group">
                                <label  class="control-label" for="modal_loe_form_location">Location</label>
                                <select class="form-control select2" style="width: 100%;" id="modal_loe_form_location" data-placeholder="Select a location">
                                    <option value="" ></option>
                                    @foreach(config('countries.country') as $key => $value)
                                    <option value="{{ $key }}">
                                      {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                                <span id="modal_loe_form_location_error" class="help-block"></span>
                            </div>
                            <div id="modal_loe_formgroup_mandays" class="form-group">
                                <label  class="control-label" for="modal_loe_form_mandays">Mandays</label>
                                <input type="text" id="modal_loe_form_mandays" class="form-control" placeholder="Mandays"></input>
                                <span id="modal_loe_form_mandays_error" class="help-block"></span>
                            </div>
                            <div id="modal_loe_formgroup_description" class="form-group">
                                <label  class="control-label" for="modal_loe_form_description">Description</label>
                                <textarea type="text" id="modal_loe_form_description" class="form-control" placeholder="Enter a description" rows="4"></textarea>
                                <span id="modal_loe_form_description_error" class="help-block"></span>
                            </div>
                            <div id="modal_loe_formgroup_date" class="form-group">
                                <label  class="control-label" for="modal_loe_form_date">Start to end date</label>
                                <input type="text" id="modal_loe_form_date" class="form-control"></input>
                                <span id="modal_loe_form_date_error" class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <div id="modal_loe_form_hidden"></div>
                            </div>
                          </form>
                        </div>
                          
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" id="modal_loe_create_update_button" class="btn btn-success">Update</button>
                        </div>
                      </div>
                  </div>
              </div>
              <!-- Modal -->
              @endcan
              <!-- LoE -->

              <!-- Actions -->
              @can('action-view')
              <!-- Table -->
              <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="tab_action">
                <div class="row">
                <div class="table-responsive">
                  <table class="table table-striped table-hover table-bordered mytable" width="100%" id="actionsTable">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Assigned to user id</th>
                        <th>Created by</th>
                        <th>Assigned to</th>
                        <th>Action name</th>
                        <th>Requestor</th>
                        <th>Status</th>
                        <th>Percent complete</th>
                        <th>Priority</th>
                        <th>Start date</th>
                        <th>End date</th>
                        <th>Description</th>
                        <th>Next action desc</th>
                        <th>Next action dependency</th>
                        <th>Next action due date</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>
                          @can('action-create')
                            <button type="button" id="new_action" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
                          @endcan
                        </th>
                      </tr>
                    </thead>
                  </table>
                </div>
                </div>
              </div>
              <!-- Table -->

              <!-- Modal -->
              <div class="modal fade" id="actionModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" style="display:table;">
                      <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" id="action_title_modal"></h4>
                        </div>
                        <!-- Modal Header -->
                      
                        <!-- Modal Body -->
                        <div class="modal-body">
                          <form id="form_action_modal" role="form" method="POST" action="">
                            <div class="form-group">
                              <label  class="control-label" for="assigned_to_action_modal">Assigned to</label>
                              <div>
                                <select class="form-control select2" style="width: 100%;" id="assigned_to_action_modal" name="assigned_to_action_modal" data-placeholder="Select a user">
                                  <option value="" ></option>
                                  @foreach($users_on_project as $key => $value)
                                  <option value="{{ $key }}">
                                    {{ $value }}
                                  </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                                <label  class="control-label" for="action_name_modal">Name</label>
                                <div>
                                    <input type="text" name="action_name_modal" class="form-control" placeholder="Name"></input>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="control-label" for="action_requestor_modal">Requestor</label>
                                <div>
                                    <input type="text" name="action_requestor_modal" class="form-control" placeholder="Requestor"></input>
                                </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6 col-sm-12 form-group">
                                  <label  class="control-label" for="status_action_modal">Status</label>
                                  <div>
                                    <select class="form-control select2" style="width: 100%;" id="status_action_modal" name="status_action_modal" data-placeholder="Select a status">
                                      <option value="" ></option>
                                      @foreach(config('select.action_status') as $key => $value)
                                      <option value="{{ $key }}">
                                        {{ $value }}
                                      </option>
                                      @endforeach
                                    </select>
                                  </div>
                              </div>
                              <div class="col-md-6 col-sm-12 form-group">
                                <label  class="control-label" for="priority_action_modal">Priority</label>
                                <div>
                                  <select class="form-control select2" style="width: 100%;" id="priority_action_modal" name="priority_action_modal" data-placeholder="Select a priority">
                                    <option value="" ></option>
                                    @foreach(config('select.action_severity') as $key => $value)
                                    <option value="{{ $key }}">
                                      {{ $value }}
                                    </option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                                <label  class="control-label" for="action_percentage_modal">Percent complete</label>
                                <div>
                                    <input type="text" name="action_percentage_modal" class="form-control" placeholder=""></input>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="control-label" for="date_action_modal">Start to end date</label>
                                <div>
                                    <input type="text" id="date_action_modal" name="date_action_modal" class="form-control"></input>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="control-label" for="description_action_modal">Description</label>
                                <div>
                                    <textarea type="text" name="description_action_modal" class="form-control" placeholder="Enter a description" rows="4"></textarea>
                                </div>
                            </div>
                            <h3>Next action</h3>
                            <div class="form-group">
                                <label  class="control-label" for="description_next_action_modal">Next action description</label>
                                <div>
                                    <textarea type="text" name="description_next_action_modal" class="form-control" placeholder="Enter a description" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="control-label" for="next_action_dependency_modal">Next action dependency</label>
                                <div>
                                    <input type="text" name="next_action_dependency_modal" class="form-control" placeholder="Next action dependency"></input>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="control-label" for="next_action_due_date_modal">Next action due datedate</label>
                                <div>
                                    <input type="text" id="next_action_due_date_modal" name="next_action_due_date_modal" class="form-control"></input>
                                </div>
                            </div>
                            <div class="form-group">
                                <div id="action_hidden"></div>
                            </div>
                          </form>
                        </div>
                          
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" id="action_create_update_button_modal" class="btn btn-success">Update</button>
                        </div>
                      </div>
                  </div>
              </div>
              <!-- Modal -->
              @endcan
              <!-- Actions -->

              <!-- Comments -->
              @can('tools-projects-comments')
              <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="tab_comment">
                @can('comment-create')
                <div class="row">
                  <div class="col-md-1">
                    <button type="button" id="new_comment" class="btn btn-info btn-xl"><span class="glyphicon glyphicon-plus"></span> Add comment</button>
                  </div>
                </div>
                <div class="ln_solid"></div>
                @endcan
                <div id="all_comments">
                @if($action == 'update')
                @foreach ($comments as $comment)
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      {{$comment->user->name}} said <small class="text-primary">{{$comment->updated_at->diffForHumans()}}</small>
                      @if($comment->user_id == Auth::user()->id || Auth::user()->can('comment-all'))
                        @can('comment-edit')
                          <a data-id="{{ $comment->id }}" class="pull-right comment_edit"><span class="glyphicon glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                        @endcan
                        @can('comment-delete')
                          <a data-id="{{ $comment->id }}" style="margin-right: 10px;" class="pull-right comment_delete"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                        @endcan
                      @endif
                    </div>
                    <div class="panel-body">
                      <span class="comment_textarea">{{$comment->comment}}</span>
                    </div>
                  </div>
                @endforeach
                @endif
                </div>
              </div>
              <!-- Modal -->
              <div class="modal fade" id="modal_comment" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="display:table;">
                  <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="modal_comment_title"></h4>
                    </div>
                    <!-- Modal Header -->
                      
                    <!-- Modal Body -->
                    <div class="modal-body">
                      <form id="modal_comment_form" role="form" method="POST" action="">
                        <div id="modal_comment_formgroup_comment" class="form-group">
                          <label  class="control-label" for="modal_comment_form_comment">Comment</label>
                          <textarea type="text" id="modal_comment_form_comment" class="form-control" placeholder="Enter a comment" rows="4"></textarea>
                          <span id="modal_comment_form_comment_error" class="help-block"></span>
                        </div>
                        <div class="form-group">
                          <div id="modal_comment_form_hidden">
                          </div>
                        </div>
                      </form>  
                    </div>
                      
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id="modal_comment_create_update_button" class="btn btn-success"></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Modal -->
              @endcan
              <!-- Comments -->
            @endif
          </div>
        </div>
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
var revenues;
var projectRevenue;
// If we set up the tab to be selected in the url it will be in variable tab_origin
var tab_origin = "{{ $tab }}";

$(document).ready(function() {
  //region Init Main interface

  // Ajax setup needed in case there is an update for revenue, comment, loe, ... tabs
  @if($action == 'update')
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  @endif

  // This code will make any modal window draggable
  $(".modal-header").on("mousedown", function(mousedownEvt) {
    var $draggable = $(this);
    var x = mousedownEvt.pageX - $draggable.offset().left,
        y = mousedownEvt.pageY - $draggable.offset().top;
    $("body").on("mousemove.draggable", function(mousemoveEvt) {
        $draggable.closest(".modal-dialog").offset({
            "left": mousemoveEvt.pageX - x,
            "top": mousemoveEvt.pageY - y
        });
    });
    $("body").one("mouseup", function() {
        $("body").off("mousemove.draggable");
    });
    $draggable.closest(".modal").one("bs.modal.hide", function() {
        $("body").off("mousemove.draggable");
    });
  });
  // OTL code mandatory
  $('.OTL_code,.mandatory').balloon({ 
    position: "right",
    tipSize: 24,
    html: true,
    css: {
      border: 'solid 4px #5baec0',
      padding: '10px',
      fontSize: '100%',
      fontWeight: 'bold',
      lineHeight: '2',
      backgroundColor: '#666',
      color: '#fff'
    } 
  });

  // Change the tab on screen with the one selected from the url
  if (tab_origin != 'tab_main') {
    $('#'+tab_origin).trigger('click');
  }

  // In case this is baseline, project or pre-sales, we will have different text to be selected
  function project_type_value_check() {
    project_type_val = $("#project_type option:selected").val();
    project_status_val = $("#project_status option:selected").val();
    if (project_type_val == "Pre-sales")
    {
      $('#estimated_date_text').text("Start / Close date");
      $("#gold_order_row").hide();
      $("#samba_id_row").show();
      $("#pullthru_samba_id_row").show();
      $("#samba_opportunity_owner_row").show();
      $("#samba_lead_domain_row").show();
      $("#samba_stage_row").show();
      $("#revenue_row").show();
      $("#samba_consulting_product_tcv_row").show();
      $("#samba_pullthru_tcv_row").show();
      $("#win_ratio_row").show();
      $("#tab_revenue").hide();
      $("#tab_loe").show();
    }
    else {
      $('#estimated_date_text').text("Estimated Start to End date");
      if (project_status_val == "Pipeline") {
        $("#gold_order_row").hide();
        $("#samba_id_row").show();
        $("#win_ratio_row").show();
      } else {
        $("#gold_order_row").show();
        $("#samba_id_row").hide();
        $("#win_ratio_row").hide();
      }
      $("#pullthru_samba_id_row").hide();
      $("#samba_opportunity_owner_row").hide();
      $("#samba_lead_domain_row").hide();
      $("#samba_stage_row").hide();
      $("#revenue_row").hide();
      $("#samba_consulting_product_tcv_row").hide();
      $("#samba_pullthru_tcv_row").hide();
      $("#tab_revenue").show();
      $("#tab_loe").hide();
    }
  }

  // This is when the page loads
  project_type_value_check();

  // This is when the select box changes
  $('#project_type, #project_status').change(function() {
    project_type_value_check();
  });

  // This is to show the help when the button is clicked
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

  // Now this is important so that we send the value of all disabled fields
  // What it does is when you try to submit, it will remove the disabled property on all fields with disabled
  jQuery(function ($) {
    $('#projectForm').bind('submit', function () {
      $(this).find(':input').prop('disabled', false);
    });
  });

  // This is to allow to change the user when change user button is clicked
  @if($action == 'update')
    @if($show_change_button)
    $(document).on('click', '#change_user', function () {
      $('#user_id').prop('disabled', false);
    });
    @endif
  @endif

  // This is to show or hide the entry of days on the project if the user is selected or not
  if($('#user_id').val()===""){
    $('.user_selected').hide();
  }
  else {
    $('.user_selected').show();
  }

  $('#user_id').change(function() {
    if($(this).val()===""){
      $('.user_selected').hide();
    }
    else {
      $('.user_selected').show();
    }
  });

  // init DateRange picker
  $('#estimated_date').daterangepicker({
    locale: {
    format: 'YYYY-MM-DD'
    },
    showISOWeekNumbers: true,
    showDropdowns: true,
    autoApply: true,
    disabled: true,
    @if(!empty(old('estimated_date')))
    startDate: '{{ explode(" - ",old("estimated_date"))[0] }}',
    endDate: '{{ explode(" - ",old("estimated_date"))[1] }}'
    @elseif(isset($project->estimated_start_date))
    startDate: '{{ $project->estimated_start_date }}',
    endDate: '{{ $project->estimated_end_date }}'
    @endif
  });

  //region Init select2 boxes
  $("#user_id").select2({
    allowClear: true,
    disabled: {{ $user_select_disabled }}
  });

  $("#year").select2({
    allowClear: false
  });

  $("#customer_id").select2({
    allowClear: false,
    disabled: {{ $customer_id_select_disabled }}
  });

  $("#meta_activity").select2({
    allowClear: true,
    disabled: {{ $meta_activity_select_disabled }}
  });

  $("#project_type").select2({
    allowClear: true,
    disabled: {{ $project_type_select_disabled }}
  });

  $("#project_subtype").select2({
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

  $("#samba_stage").select2({
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
  //endregion

  // Change when year has been changed
  @if($action == 'update')
    $('#year').on('change', function() {
        year=$(this).val();
        window.location.href = "{!! route('toolsFormUpdate',[$user_id,$project->id,'']) !!}"+"/"+year;
    });
  @endif

  // Click remove user
  $('#remove_user').on('click', function () {
      bootbox.confirm("Are you sure want to remove the user from this project?", function(result) {
          if (result){
            $('<input />').attr('type', 'hidden')
              .attr('name', 'action')
              .attr('value', 'Remove')
              .appendTo('#projectForm');
            $('#projectForm').submit();
          }
      });
  });

  // Click transfer user
  @if($action == 'update')
    $('#transfer_user').on('click', function () {
      bootbox.confirm("Are you sure want to transfer the user from this project?", function(result) {
          if (result){
            window.location.href = "{!! route('toolsFormTransfer',[$user_id,$project->id]) !!}";
          }
      });
    });
  @endif

  //endregion

  //region Revenue
  @if($action == 'update')

    // Init select2 boxes in the modal
    $("#modal_revenue_form_year").select2({
        allowClear: false
    });

    function modal_revenue_form_clean(title) {
      $('#modal_revenue_title').text(title+' Revenue');
      $('#modal_revenue_create_update_button').text(title);
      $('#modal_revenue_form_hidden').empty();

      // Set date to today's year
      var d = new Date();
      var year = d.getFullYear()
      $('select#modal_revenue_form_year').val(year);
      $('select#modal_revenue_form_year').select2().trigger('change');

      $('#modal_revenue_form_product_code').val('');

      all_inputs = $('#form#modal_revenue_form input');
      console.log(all_inputs);

      // Set all months value to 0
      @foreach(config('select.available_months') as $key => $month)
        $('#modal_revenue_form_{{ $month }}').val(0);
      @endforeach

      modal_revenue_form_error_clean();
    }

    function modal_revenue_form_error_clean() {
      // Clean all error class
      $("form#modal_revenue_form  div.form-group").each(function(){
        $(this).removeClass('has-error');
      });
      // Clean all error message
      $("form#modal_revenue_form span.help-block").each(function(){
        $(this).empty();
      });
    }

    projectRevenue = $('#projectRevenue').DataTable({
        serverSide: true,
        processing: true,
        scrollX: true,
        stateSave: true,
        responsive: false,
        ajax: {
                url: "{!! route('listOfProjectsRevenueAjax',$project->id) !!}",
                type: "GET",
                dataType: "JSON"
            },
        columns: [
            { name: 'id', data: 'id' , searchable: false , visible: false },
            { name: 'year', data: 'year' , searchable: true , visible: true },
            { name: 'product_code', data: 'product_code' , searchable: true , visible: true },
            { name: 'jan', data: 'jan' , searchable: true , visible: true },
            { name: 'feb', data: 'feb' , searchable: true , visible: true },
            { name: 'mar', data: 'mar' , searchable: true , visible: true },
            { name: 'apr', data: 'apr' , searchable: true , visible: true },
            { name: 'may', data: 'may' , searchable: true , visible: true },
            { name: 'jun', data: 'jun' , searchable: true , visible: true },
            { name: 'jul', data: 'jul' , searchable: true , visible: true },
            { name: 'aug', data: 'aug' , searchable: true , visible: true },
            { name: 'sep', data: 'sep' , searchable: true , visible: true },
            { name: 'oct', data: 'oct' , searchable: true , visible: true },
            { name: 'nov', data: 'nov' , searchable: true , visible: true },
            { name: 'dec', data: 'dec' , searchable: true , visible: true },
            {
                name: 'actions',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
              var actions = '';
              actions += '<div class="btn-group btn-group-xs">';
              if ({{ Auth::user()->can('projectRevenue-edit') ? 'true' : 'false' }}){
                actions += '<button type="button" data-id="'+data.id+'" class="buttonRevenueEdit btn btn-success"><span class="glyphicon glyphicon-pencil"></span></button>';
              };
              if ({{ Auth::user()->can('projectRevenue-delete') ? 'true' : 'false' }}){
                actions += '<button type="button" data-id="'+data.id+'" class="buttonRevenueDelete btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>';
              };
              actions += '</div>';
              return actions;
            },
                width: '70px'
            }
            ],
        order: [[1, 'desc']],
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        dom: 'Bfrtip',
        buttons: [
          {
            extend: "colvis",
            className: "btn-sm",
            columns: [ 1,2,3,4,5,6,7,8,9,10,11,12,13,14]
          },
          {
            extend: "pageLength",
            className: "btn-sm"
          },
          {
            extend: "csv",
            className: "btn-sm",
            exportOptions: {
                columns: ':visible'
            }
          },
          {
            extend: "excel",
            className: "btn-sm",
            exportOptions: {
                columns: ':visible'
            }
          },
          {
            extend: "print",
            className: "btn-sm",
            exportOptions: {
                columns: ':visible'
            }
          },
        ]   
    });

    // Click add new
    $(document).on('click', '#new_revenue', function () {
      modal_revenue_form_clean('Create');

      var hidden = '';
      hidden += '<input class="form-control" id="modal_revenue_form_project_id" type="hidden" value="'+{{ $project->id }}+'">';
      hidden += '<input class="form-control" id="modal_revenue_form_action" type="hidden" value="create">';
      $('#modal_revenue_form_hidden').append(hidden);
      $('#modal_revenue').modal("show");
    });

    // Click edit
    $(document).on('click', '.buttonRevenueEdit', function () {
      modal_revenue_form_clean('Update');

      var table = projectRevenue;
      var tr = $(this).closest('tr');
      var row = table.row(tr);

      var hidden = '';
      hidden += '<input class="form-control" id="modal_revenue_form_revenue_id" type="hidden" value="'+row.data().id+'">';
      hidden += '<input class="form-control" id="modal_revenue_form_action" type="hidden" value="update">';
      $('#modal_revenue_form_hidden').append(hidden);

      $('select#modal_revenue_form_year').val(row.data().year);
      $('select#modal_revenue_form_year').select2().trigger('change');
      
      $('input#modal_revenue_form_product_code').val(row.data().product_code);

      @foreach(config('select.available_months') as $key => $month)
        $('input#modal_revenue_form_{{ $month }}').val(row.data().{{ $month }});
      @endforeach

      $('#modal_revenue').modal("show");
    });

    // click send info ajax to create or update
    $(document).on('click', '#modal_revenue_create_update_button', function () {
      // Getting inputs
      var action_revenue_modal = $('input#modal_revenue_form_action').val();
      var year = $('select#modal_revenue_form_year').children("option:selected").val();
      var product_code = $('input#modal_revenue_form_product_code').val();
      @foreach(config('select.available_months') as $key => $month)
        var input_revenue_{{ $month }} = $('input#modal_revenue_form_{{ $month }}').val();
      @endforeach
 
      switch (action_revenue_modal) {
        case 'create':
          var project_id_revenue_modal = $('input#modal_revenue_form_project_id').val();
          var data = {'project_id':project_id_revenue_modal,'year':year,'product_code':product_code
                      @foreach(config('select.available_months') as $key => $month)
                        ,'{{ $month }}':  input_revenue_{{ $month }}
                      @endforeach
          };
          var revenue_create_update_route = "{!! route('ProjectsRevenueAddAjax') !!}";
          var type = 'post';
          break;
        case 'update':
          var revenue_id = $('input#modal_revenue_form_revenue_id').val();
          var data = {'year':year,'product_code':product_code
                      @foreach(config('select.available_months') as $key => $month)
                      ,'{{ $month }}':  input_revenue_{{ $month }}
                      @endforeach
          };
          var revenue_create_update_route = "{{ route('ProjectsRevenueUpdateAjax',['']) }}/"+revenue_id;
          var type = 'patch';
          break;
      }
      
      $.ajax({
            type: type,
            url: revenue_create_update_route,
            data:data,
            dataType: 'json',
            success: function(data) {
              if (data.result == 'success'){
                  box_type = 'success';
                  message_type = 'success';
              }
              else {
                  box_type = 'danger';
                  message_type = 'error';
              }

              $('#flash-message').empty();
              var box = $('<div id="delete-message" class="alert alert-'+box_type+' alert-dismissible flash-'+message_type+'" role="alert"><button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>'+data.msg+'</div>');
              $('#flash-message').append(box);
              $('#delete-message').delay(2000).queue(function () {
                  $(this).addClass('animated flipOutX')
              });
              $('#modal_revenue').modal('hide');
              projectRevenue.ajax.reload();
            },
            error: function (data, ajaxOptions, thrownError) {
              modal_revenue_form_error_clean();
              var errors = data.responseJSON.errors;
              var status = data.status;

              if (status === 422) {
                console.log(errors);
                $.each(errors, function (key, value) {
                  $('#modal_revenue_formgroup_'+key).addClass('has-error');
                  $('#modal_revenue_form_'+key+'_error').text(value);
                });
              } else if (status === 403 || status === 500) {
                $('#modal_comment_formgroup_'+key).addClass('has-error');
                $('#modal_comment_form_'+key+'_error').text('No Authorization!');
              }
            }
      });

    });

    $(document).on('click', '.buttonRevenueDelete', function () {
      record_id = $(this).attr('data-id');
      bootbox.confirm("Are you sure want to delete this record?", function(result) {
        if (result){
          $.ajax({
            type: 'get',
            url: "{!! route('projectRevenueDelete','') !!}/"+record_id,
            dataType: 'json',
            success: function(data) {
              //console.log(data);
              if (data.result == 'success'){
                  box_type = 'success';
                  message_type = 'success';
              }
              else {
                  box_type = 'danger';
                  message_type = 'error';
              }

              $('#flash-message').empty();
              var box = $('<div id="delete-message" class="alert alert-'+box_type+' alert-dismissible flash-'+message_type+'" role="alert"><button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>'+data.msg+'</div>');
              $('#flash-message').append(box);
              $('#delete-message').delay(2000).queue(function () {
                  $(this).addClass('animated flipOutX')
              });
              projectRevenue.ajax.reload();
            }
          });
        }
      });
    });
  @endif
  //endregion

  //region Comment
  @if($action == 'update')

    function modal_comment_form_clean(title) {
      $('#modal_comment_title').text(title+' Comment');
      $('#modal_comment_create_update_button').text(title);
      $('#modal_comment_form_hidden').empty();
      // Clean all textarea
      $("form#modal_comment_form textarea").each(function(){
        $(this).val('');
      });

      modal_comment_form_error_clean();
    }

    function modal_comment_form_error_clean() {
      // Clean all error class
      $("form#modal_comment_form  div.form-group").each(function(){
        $(this).removeClass('has-error');
      });
      // Clean all error message
      $("form#modal_comment_form span.help-block").each(function(){
        $(this).empty();
      });
    }

    // Click add new
    $(document).on('click', '#new_comment', function () {
      modal_comment_form_clean('Create');
      var hidden = '';
      hidden += '<input class="form-control" id="modal_comment_form_project_id" type="hidden" value="'+{{ $project->id }}+'">';
      hidden += '<input class="form-control" id="modal_comment_form_action" type="hidden" value="create">';
      $('#modal_comment_form_hidden').append(hidden);
      $('#modal_comment').modal("show");
    });

    // Click edit
    $(document).on('click', '.comment_edit', function () {
      modal_comment_form_clean('Update');
      comment_id = $(this).attr('data-id');
      comment_comment = $(this).parent().next().find(".comment_textarea").text();
      $('#modal_comment_form_comment').val(comment_comment);
      var hidden = '';
      hidden += '<input class="form-control" id="modal_comment_form_comment_id" type="hidden" value="'+comment_id+'">';
      hidden += '<input class="form-control" id="modal_comment_form_action" type="hidden" value="update">';
      $('#modal_comment_form_hidden').append(hidden);
      $('#modal_comment').modal("show");
    });

    // Function to refresh comments from ajax request
    function refresh_comments() {
      $.ajax({
                type: 'get',
                url: "{!! route('comment_list','') !!}/"+{{ $project->id }},
                dataType: 'json',
                success: function(data) {
                  $('#num_of_comments').text(data.num_of_comments);
                  $('#all_comments').empty();

                  var comments = '';
                  $.each(data.list, function( index, value ) {
                    comments += '<div class="panel panel-default">';
                    comments += '<div class="panel-heading">';
                    comments += value.user_name +' said <small class="text-primary">'+value.time+'</small>';
                    if (value.id > 0) {
                      @can('comment-edit')
                        comments += '<a data-id="'+value.id+'" class="pull-right comment_edit"><span class="glyphicon glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
                      @endcan
                      @can('comment-delete')
                        comments += '<a data-id="'+value.id+'" style="margin-right: 10px;" class="pull-right comment_delete"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
                      @endcan
                    }
                    comments += '</div>';
                    comments += '<div class="panel-body">';
                    comments += '<span class="comment_textarea">';
                    comments += value.comment;
                    comments += '</span>';
                    comments += '</div>';
                    comments += '</div>';
                  });
                  
                  $('#all_comments').append(comments); 

                }
              }); 
    }

    // click send info ajax to create or update
    $(document).on('click', '#modal_comment_create_update_button', function () {
      // Getting inputs
      var action_comment_modal = $('input#modal_comment_form_action').val();
      var comment_comment = $('#modal_comment_form_comment').val();
      switch (action_comment_modal) {
        case 'create':
          // Data
          var project_id_comment_modal = $('input#modal_comment_form_project_id').val();
          var data = {'project_id':project_id_comment_modal,'comment':comment_comment};
          // Route info
          var comment_create_update_route = "{!! route('commentInsert') !!}";
          var type = 'post';
          break;

        case 'update':
          // Data
          var comment_id = $('input#modal_comment_form_comment_id').val();
          var data = {'comment':comment_comment};
          // Route info
          var comment_create_update_route = "{!! route('comment_edit','') !!}/"+comment_id;
          var type = 'patch';
          break;
      }
      
      $.ajax({
            type: type,
            url: comment_create_update_route,
            data:data,
            dataType: 'json',
            success: function(data) {
              refresh_comments();
              if (data.result == 'success'){
                  box_type = 'success';
                  message_type = 'success';
              }
              else {
                  box_type = 'danger';
                  message_type = 'error';
              }

              $('#flash-message').empty();
              var box = $('<div id="delete-message" class="alert alert-'+box_type+' alert-dismissible flash-'+message_type+'" role="alert"><button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>'+data.msg+'</div>');
              $('#flash-message').append(box);
              $('#delete-message').delay(2000).queue(function () {
                  $(this).addClass('animated flipOutX')
              });
              $('#modal_comment').modal('hide');
              projectLoe.ajax.reload();
            },
            error: function (data, ajaxOptions, thrownError) {
              modal_comment_form_error_clean();
              var errors = data.responseJSON.errors;
              var status = data.status;

              if (status === 422) {
                $.each(errors, function (key, value) {
                  $('#modal_comment_formgroup_'+key).addClass('has-error');
                  $('#modal_comment_form_'+key+'_error').text(value);
                });
              } else if (status === 403 || status === 500) {
                $('#modal_comment_formgroup_'+key).addClass('has-error');
                $('#modal_comment_form_'+key+'_error').text('No Authorization!');
              }
            }
      });
    });

    // Click delete
    $(document).on('click', '.comment_delete', function () {
      var comment_id = $(this).attr('data-id');
      bootbox.confirm("Are you sure want to delete this message?", function(result) {
        if (result){
          $.ajax({
            type: 'delete',
            url: "{!! route('comment_delete','') !!}/"+comment_id,
            dataType: 'json',
            success: function(data) {
              refresh_comments();

              if (data.result == 'success'){
                  box_type = 'success';
                  message_type = 'success';
              }
              else {
                  box_type = 'danger';
                  message_type = 'error';
              }

              $('#flash-message').empty();
              var box = $('<div id="delete-message" class="alert alert-'+box_type+' alert-dismissible flash-'+message_type+'" role="alert"><button type="button" href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>'+data.msg+'</div>');
              //console.log(data.msg);
              $('#flash-message').append(box);
              $('#delete-message').delay(2000).queue(function () {
                  $(this).addClass('animated flipOutX')
              });
            }
          });
        }
      });
    });
  @endif
  //endregion
  
  //region Loe
  @if($action == 'update')
    // Init daterange in input field
    $('#modal_loe_form_date').daterangepicker({
      showISOWeekNumbers: true,
      showDropdowns: true,
      autoUpdateInput: false,
      locale: {
        format: 'YYYY-MM-DD',
        cancelLabel: 'Clear'
      }
    });

    $('#modal_loe_form_date').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('#modal_loe_form_date').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });

    // Init select2 boxes in the modal
    $("#modal_loe_form_domain").select2({
      allowClear: true
    });

    $("#modal_loe_form_type").select2({
      allowClear: true
    });

    $("#modal_loe_form_location").select2({
      allowClear: true
    });


    // Ajax datatables to create the table
    projectLoe = $('#projectLoe').DataTable({
        serverSide: true,
        processing: true,
        scrollX: true,
        stateSave: true,
        responsive: false,
        ajax: {
                url: "{!! route('listOfProjectsLoeAjax',$project->id) !!}",
                type: "GET",
                dataType: "JSON"
            },
        columns: [
            { name: 'project_loe.id', data: 'loe_id' , searchable: false , visible: false },
            { name: 'project_loe.project_id', data: 'p_id' , searchable: false , visible: false },
            { name: 'customers.name', data: 'customer_name' , searchable: true , visible: false },
            { name: 'projects.project_name', data: 'project_name' , searchable: true , visible: false },
            { name: 'users.name', data: 'user_name' , searchable: true , visible: true },
            { name: 'project_loe.start_date', data: 'start_date' , searchable: true , visible: true },
            { name: 'project_loe.end_date', data: 'end_date' , searchable: true , visible: true },
            { name: 'project_loe.domain', data: 'domain' , searchable: true , visible: true },
            { name: 'project_loe.type', data: 'type' , searchable: true , visible: true },
            { name: 'project_loe.location', data: 'location' , searchable: true , visible: true },
            { name: 'project_loe.mandays', data: 'mandays' , searchable: true , visible: true },
            { name: 'project_loe.description', data: 'description' , searchable: true , visible: true },
            { name: 'project_loe.history', data: 'history' , searchable: true , visible: false },
            { name: 'project_loe.created_at', data: 'created_at' , searchable: true , visible: false },
            { name: 'project_loe.updated_at', data: 'updated_at' , searchable: true , visible: false },
            { name: 'project_loe.signoff', data: 'signoff' , searchable: true , visible: false },
            {
                name: 'actions',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                  var actions = '';
                  actions += '<div class="btn-group btn-group-xs">';
                  if ({{ Auth::user()->can('projectLoe-edit') ? 'true' : 'false' }} || {{ Auth::user()->can('projectLoe-editAll') ? 'true' : 'false' }}){
                    actions += '<button type="button" data-id="'+data.loe_id+'" class="buttonLoeEdit btn btn-success"><span class="glyphicon glyphicon-pencil"></span></button>';
                  };
                  if ({{ Auth::user()->can('projectLoe-delete') ? 'true' : 'false' }} || {{ Auth::user()->can('projectLoe-deleteAll') ? 'true' : 'false' }}){
                    actions += '<button type="button" data-id="'+data.loe_id+'" class="buttonLoeDelete btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>';
                  };
                  actions += '</div>';
                  return actions;
                },
                width: '70px'
            }
            ],
        order: [[2, 'desc']],
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        dom: 'Bfrtip',
        buttons: [
          {
            extend: "colvis",
            className: "btn-sm",
            columns: [ 2,3,4,5,6,7,8,9,10,11,12,13,14,15]
          },
          {
            extend: "pageLength",
            className: "btn-sm"
          },
          {
            extend: "csv",
            className: "btn-sm",
            exportOptions: {
                columns: ':visible'
            }
          },
          {
            extend: "excel",
            className: "btn-sm",
            exportOptions: {
                columns: ':visible'
            }
          },
          {
            extend: "print",
            className: "btn-sm",
            exportOptions: {
                columns: ':visible'
            }
          },
        ]   
    });

    function modal_loe_form_clean(title) {
      $('#modal_loe_title').text(title+' LoE');
      $('#modal_loe_create_update_button').text(title);
      $('#modal_loe_form_hidden').empty();
      // Clean all input
      $("form#modal_loe_form input").each(function(){ 
        $(this).val('');
      });
      // Clean all textarea
      $("form#modal_loe_form textarea").each(function(){
        $(this).val('');
      });
      // Clean all select
      $("form#modal_loe_form select").each(function(){
        $(this).val('');
        $(this).select2().trigger('change');
      });

      modal_loe_form_error_clean();
    }

    function modal_loe_form_error_clean() {
      // Clean all error class
      $("form#modal_loe_form  div.form-group").each(function(){
        $(this).removeClass('has-error');
      });
      // Clean all error message
      $("form#modal_loe_form span.help-block").each(function(){
        $(this).empty();
      });
    }

    // Click add new
    $(document).on('click', '#new_loe', function () {
      modal_loe_form_clean('Create');
      var hidden = '';
      hidden += '<input class="form-control" id="modal_loe_form_project_id" type="hidden" value="'+{{ $project->id }}+'">';
      hidden += '<input class="form-control" id="modal_loe_form_action" type="hidden" value="create">';
      $('#modal_loe_form_hidden').append(hidden);
      $('#modal_loe').modal("show");
    });

    // Click edit
    $(document).on('click', '.buttonLoeEdit', function () {
      modal_loe_form_clean('Update');

      var table = projectLoe;
      var tr = $(this).closest('tr');
      var row = table.row(tr);

      var hidden = '';
      hidden += '<input class="form-control" id="modal_loe_form_loe_id" type="hidden" value="'+row.data().loe_id+'">';
      hidden += '<input class="form-control" id="modal_loe_form_action" type="hidden" value="update">';
      $('#modal_loe_form_hidden').append(hidden);
      
      $('input#modal_loe_form_mandays').val(row.data().mandays);
      $('textarea#modal_loe_form_description').val(row.data().description);
      if (row.data().start_date) {
        $('input#modal_loe_form_date').val(row.data().start_date+" - "+row.data().end_date);
      } else {
        $('input#modal_loe_form_date').val('');
      }
      

      $('select#modal_loe_form_domain').val(row.data().domain);
      $('select#modal_loe_form_domain').select2().trigger('change');

      $('select#modal_loe_form_type').val(row.data().type);
      $('select#modal_loe_form_type').select2().trigger('change');

      $('select#modal_loe_form_location').val(row.data().location);
      $('select#modal_loe_form_location').select2().trigger('change');

      $('#modal_loe').modal("show");
    });

    // click send info ajax to create or update
    $(document).on('click', '#modal_loe_create_update_button', function () {
      // hidden input
      var action_loe_modal = $('input#modal_loe_form_action').val();
      var domain_loe_modal = $('select#modal_loe_form_domain').children("option:selected").val();
      var type_loe_modal = $('select#modal_loe_form_type').children("option:selected").val();
      var location_loe_modal = $('select#modal_loe_form_location').children("option:selected").val();
      var mandays_loe_modal = $('input#modal_loe_form_mandays').val();
      var description_loe_modal = $('textarea#modal_loe_form_description').val();
      var date_loe_modal = $('input#modal_loe_form_date').val().split(" - ");
      var start_date = date_loe_modal[0];
      var end_date = date_loe_modal[1];

      switch (action_loe_modal) {
        case 'create':
          // Data
          var project_id_loe_modal = $('input#modal_loe_form_project_id').val();
          var data = {'project_id':project_id_loe_modal,'domain':domain_loe_modal,
                      'type':type_loe_modal,'location':location_loe_modal,'mandays':mandays_loe_modal,'description':description_loe_modal,
                      'start_date':start_date,'end_date':end_date
          };
          // Route info
          var loe_create_update_route = "{!! route('ProjectsLoeAddAjax') !!}";
          var type = 'post';
          break;

        case 'update':
          // Data
          var loe_id = $('input#modal_loe_form_loe_id').val();
          var data = {'domain':domain_loe_modal,
                      'type':type_loe_modal,'location':location_loe_modal,'mandays':mandays_loe_modal,'description':description_loe_modal,
                      'start_date':start_date,'end_date':end_date
          };
          // Route info
          var loe_create_update_route = "{!! route('ProjectsLoeUpdateAjax','') !!}/"+loe_id;
          var type = 'patch';
          break;
      }
      
      $.ajax({
            type: type,
            url: loe_create_update_route,
            data:data,
            dataType: 'json',
            success: function(data) {
              //console.log(data);
              if (data.result == 'success'){
                  box_type = 'success';
                  message_type = 'success';
              }
              else {
                  box_type = 'danger';
                  message_type = 'error';
              }

              $('#flash-message').empty();
              var box = $('<div id="delete-message" class="alert alert-'+box_type+' alert-dismissible flash-'+message_type+'" role="alert"><button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>'+data.msg+'</div>');
              $('#flash-message').append(box);
              $('#delete-message').delay(2000).queue(function () {
                  $(this).addClass('animated flipOutX')
              });
              $('#modal_loe').modal('hide');
              projectLoe.ajax.reload();
            },
            error: function (data, ajaxOptions, thrownError) {
              modal_loe_form_error_clean();
              var errors = data.responseJSON.errors;
              var status = data.status;

              if (status === 422) {
                $.each(errors, function (key, value) {
                  $('#modal_loe_formgroup_'+key).addClass('has-error');
                  $('#modal_loe_form_'+key+'_error').text(value);
                });
              } else if (status === 403 || status === 500) {
                $('#modal_loe_formgroup_'+key).addClass('has-error');
                $('#modal_loe_form_'+key+'_error').text('No Authorization!');
              }
            }
      });
    });

    // Click delete
    $(document).on('click', '.buttonLoeDelete', function () {
      record_id = $(this).attr('data-id');

      bootbox.confirm("Are you sure want to delete this record?", function(result) {
        if (result){
          $.ajax({
            type: 'get',
            url: "{!! route('projectLoeDelete','') !!}/"+record_id,
            dataType: 'json',
            success: function(data) {
              //console.log(data);
              if (data.result == 'success'){
                  box_type = 'success';
                  message_type = 'success';
              }
              else {
                  box_type = 'danger';
                  message_type = 'error';
              }

              $('#flash-message').empty();
              var box = $('<div id="delete-message" class="alert alert-'+box_type+' alert-dismissible flash-'+message_type+'" role="alert"><button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>'+data.msg+'</div>');
              $('#flash-message').append(box);
              $('#delete-message').delay(2000).queue(function () {
                  $(this).addClass('animated flipOutX')
              });
              projectLoe.ajax.reload();
            }
          });
        }
      });
    } );
  @endif
  //endregion Loe

  //region Action
  @if($action == 'update')
  // Init select2 boxes in the modal
  $("#assigned_to_action_modal").select2({
      allowClear: true
  });
  $("#status_action_modal").select2({
      allowClear: true
  });
  $("#priority_action_modal").select2({
      allowClear: true
  });

  // Init Date range
  $('#date_action_modal').daterangepicker({
      showISOWeekNumbers: true,
      showDropdowns: false,
      autoUpdateInput: false,
      locale: {
        format: 'YYYY-MM-DD',
        cancelLabel: 'Clear'
      }
  });

  $('#date_action_modal').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
  });

  $('#date_action_modal').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });

  $('#next_action_due_date_modal').daterangepicker({
      singleDatePicker: true,
      autoUpdateInput: false,
      locale: {
        format: 'YYYY-MM-DD',
        cancelLabel: 'Clear'
      }
  });

  $('#next_action_due_date_modal').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD'));
  });

  $('#next_action_due_date_modal').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });

  // Init slider
  $("input[name='action_percentage_modal']").ionRangeSlider({
        min: 0,
        max: 100,
        from: 0,
        step: 5,
        postfix: '%',
        grid: true
  });

  var action_percentage_modal = $("input[name='action_percentage_modal']").data("ionRangeSlider");

  // Ajax datatables to create the table
  var actionsTable = $('#actionsTable').DataTable({
      serverSide: true,
      processing: true,
      scrollX: true,
      stateSave: true,
      responsive: false,
      ajax: {
              url: "{!! route('actionListAjax',$project->id) !!}",
              type: "GET",
              dataType: "JSON"
          },
      columns: [
          { name: 'actions.id', data: 'action_id' , searchable: false , visible: false },
          { name: 'assigned.id', data: 'assigned_to_user_id' , searchable: false , visible: false },
          { name: 'created_by.name', data: 'created_by_name' , searchable: true , visible: true },
          { name: 'assigned.name', data: 'assigned_to_name' , searchable: true , visible: true },
          { name: 'actions.name', data: 'action_name' , searchable: true , visible: true },
          { name: 'actions.requestor', data: 'action_requestor' , searchable: true , visible: true },
          { name: 'actions.status', data: 'action_status' , searchable: true , visible: true },
          { 
            name: 'actions.percent_complete', 
            data: 'percent_complete', 
            searchable: true, 
            visible: true,
            render: function (data, type, row) {
                  //console.log(data);
                  var actions = '';
                  actions += '<small>'+data+'% Complete</small>';
                  actions += '<div class="progress">';
                  actions += '<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="'+data+'" aria-valuemin="0" aria-valuemax="100" style="width:'+data+'%">';
                  actions += '</div>';
                  actions += '</div>';
                  return type === 'export' ? data : actions;
                },
            width: '150px'
          },
          { name: 'actions.severity', data: 'action_severity' , searchable: true , visible: true },
          { name: 'actions.estimated_start_date', data: 'action_start_date' , searchable: true , visible: true },
          { name: 'actions.estimated_end_date', data: 'action_end_date' , searchable: true , visible: true },
          { name: 'actions.description', data: 'action_description' , searchable: true , visible: true },
          { name: 'actions.next_action_description', data: 'next_action_description' , searchable: true , visible: true },
          { name: 'actions.next_action_dependency', data: 'next_action_dependency' , searchable: true , visible: true },
          { name: 'actions.next_action_due_date', data: 'next_action_due_date' , searchable: true , visible: true },
          { name: 'actions.created_at', data: 'created_at' , searchable: true , visible: true },
          { name: 'actions.updated_at', data: 'updated_at' , searchable: true , visible: true },
          {
              name: 'actions',
              data: null,
              sortable: false,
              searchable: false,
              render: function (data) {
                var actions = '';
                actions += '<div class="btn-group btn-group-xs">';
                if ({{ Auth::user()->can('action-edit') ? 'true' : 'false' }} || {{ Auth::user()->can('action-all') ? 'true' : 'false' }}){
                  actions += '<button type="button" data-id="'+data.action_id+'" class="buttonActionEdit btn btn-success"><span class="glyphicon glyphicon-pencil"></span></button>';
                };
                if ({{ Auth::user()->can('action-delete') ? 'true' : 'false' }} || {{ Auth::user()->can('action-all') ? 'true' : 'false' }}){
                  actions += '<button type="button" data-id="'+data.action_id+'" class="buttonActionDelete btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>';
                };
                actions += '</div>';
                return actions;
              },
              width: '70px'
          }
          ],
      order: [[2, 'desc']],
      lengthMenu: [
          [ 10, 25, 50, -1 ],
          [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      dom: 'Bfrtip',
      buttons: [
        {
          extend: "colvis",
          className: "btn-sm",
          columns: [ 2,3,4,5,6,7,8,9,10,11,12,13,14,15,16]
        },
        {
          extend: "pageLength",
          className: "btn-sm"
        },
        {
          extend: "csv",
          className: "btn-sm",
          exportOptions: {
              columns: ':visible',
              orthogonal: 'export'
          }
        },
        {
          extend: "excel",
          className: "btn-sm",
          exportOptions: {
              columns: ':visible'
          }
        },
        {
          extend: "print",
          className: "btn-sm",
          exportOptions: {
              columns: ':visible'
          }
        },
      ]   
  });

  // Click add new
  $(document).on('click', '#new_action', function () {
      $('#action_title_modal').text('Create Action');
      $('#action_create_update_button_modal').text('Create');
      $('#action_hidden').empty();
      var hidden = '';
      hidden += '<input class="form-control" id="project_id_action_modal" name="project_id_action_modal" type="hidden" value="'+{{ $project->id }}+'">';
      hidden += '<input class="form-control" id="user_id_action_modal" name="user_id_action_modal" type="hidden" value="'+{{ Auth::user()->id }}+'">';
      hidden += '<input class="form-control" id="section_action_modal" name="user_id_action_modal" type="hidden" value="project">';
      hidden += '<input class="form-control" id="action_action_modal" name="action_action_modal" type="hidden" value="create">';
      $('#action_hidden').append(hidden);

      // Init fields

      $('select[name="assigned_to_action_modal"]').val('');
      $('select[name="assigned_to_action_modal"]').select2().trigger('change');
      
      $('input[name="action_name_modal"]').val('');

      $('select[name="status_action_modal"]').val('OPEN');
      $('select[name="status_action_modal"]').select2().trigger('change');

      $('select[name="priority_action_modal"]').val('LOW');
      $('select[name="priority_action_modal"]').select2().trigger('change');

      action_percentage_modal.update({
          from: 0
      });

      $('input[name="date_action_modal"]').val('');

      $('textarea[name="description_action_modal"]').val('');

      $('textarea[name="description_next_action_modal"]').val('');

      $('input[name="next_action_dependency_modal"]').val('');

      $('input[name="next_action_due_date_modal"]').val('');


      $('#actionModal').modal("show");
  });

  // Click edit
  $(document).on('click', '.buttonActionEdit', function () {
    $('#action_title_modal').text('Update Action');
    $('#action_create_update_button_modal').text('Update');

    var table = actionsTable;
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    //console.log('the loe id is '+row.data().loe_id);

    $('#action_hidden').empty();
    var hidden = '';
    hidden += '<input class="form-control" id="action_action_modal" name="action_action_modal" type="hidden" value="update">';
    hidden += '<input class="form-control" id="action_id" name="action_id" type="hidden" value="'+row.data().action_id+'">';
    hidden += '<input class="form-control" id="section_action_modal" name="user_id_action_modal" type="hidden" value="project">';
    $('#action_hidden').append(hidden);

    // Init fields

    $('select[name="assigned_to_action_modal"]').val(row.data().assigned_to_user_id);
    $('select[name="assigned_to_action_modal"]').select2().trigger('change');
    
    $('input[name="action_name_modal"]').val(row.data().action_name);
    $('input[name="action_requestor_modal"]').val(row.data().action_requestor);

    $('select[name="status_action_modal"]').val(row.data().action_status);
    $('select[name="status_action_modal"]').select2().trigger('change');

    $('select[name="priority_action_modal"]').val(row.data().action_severity);
    $('select[name="priority_action_modal"]').select2().trigger('change');

    action_percentage_modal.update({
        from: row.data().percent_complete
    });

    if (row.data().action_start_date) {
      $('input[name="date_action_modal"]').val(row.data().action_start_date+" - "+row.data().action_end_date);
    } else {
        $('input[name="date_action_modal"]').val('');
    }
    $('textarea[name="description_action_modal"]').val(row.data().action_description);

    $('textarea[name="description_next_action_modal"]').val(row.data().next_action_description);

    $('input[name="next_action_dependency_modal"]').val(row.data().next_action_dependency);

    if (row.data().next_action_due_date) {
      $('input[name="next_action_due_date_modal"]').val(row.data().next_action_due_date);
    } else {
      $('input[name="next_action_due_date_modal"]').val('');
    }
    $('#actionModal').modal("show");
  });

  // Click delete
  $(document).on('click', '.buttonActionDelete', function () {
    record_id = $(this).attr('data-id');

    bootbox.confirm("Are you sure want to delete this record?", function(result) {
      if (result){
        $.ajax({
          type: 'get',
          url: "{!! route('projectActionDelete','') !!}/"+record_id,
          dataType: 'json',
          success: function(data) {
            $('#num_of_actions').text(data.num_of_actions);
            //console.log(data);
            if (data.result == 'success'){
                box_type = 'success';
                message_type = 'success';
            }
            else {
                box_type = 'danger';
                message_type = 'error';
            }

            $('#flash-message').empty();
            var box = $('<div id="delete-message" class="alert alert-'+box_type+' alert-dismissible flash-'+message_type+'" role="alert"><button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>'+data.msg+'</div>');
            $('#flash-message').append(box);
            $('#delete-message').delay(2000).queue(function () {
                $(this).addClass('animated flipOutX')
            });
            actionsTable.ajax.reload();
          }
        });
      }
    });
  } );

  // click send info ajax to create or update
  $(document).on('click', '#action_create_update_button_modal', function () {
    // hidden input
    var action_action_modal = $('input#action_action_modal').val();
    var section_action_modal = $('input#section_action_modal').val();
    if (action_action_modal == 'create') {
      var project_id_action_modal = $('input#project_id_action_modal').val();
      var user_id_action_modal = $('input#user_id_action_modal').val();
    } else if (action_action_modal == 'update') {
      var action_id = $('input#action_id').val();
    }

    // filled in
    var assigned_to_action_modal = $('select[name="assigned_to_action_modal"]').children("option:selected").val();
    var action_name_modal = $('input[name="action_name_modal"]').val();
    var action_requestor_modal = $('input[name="action_requestor_modal"]').val();
    var status_action_modal = $('select[name="status_action_modal"]').children("option:selected").val();
    var priority_action_modal = $('select[name="priority_action_modal"]').children("option:selected").val();
    var action_percentage_modal = $('input[name="action_percentage_modal"]').val();
    if ($('input[name="date_action_modal"]').val()) {
      var date_action_modal = $('input[name="date_action_modal"]').val().split(" - ");
      var estimated_start_date = date_action_modal[0];
      var estimated_end_date = date_action_modal[1];
    } else {
      var estimated_start_date = '';
      var estimated_end_date = '';
    }
    
    var description_action_modal = $('textarea[name="description_action_modal"]').val();
    var description_next_action_modal = $('textarea[name="description_next_action_modal"]').val();
    var next_action_dependency_modal = $('input[name="next_action_dependency_modal"]').val();
    var next_action_due_date_modal = $('input[name="next_action_due_date_modal"]').val();

    var data = {'assigned_user_id':assigned_to_action_modal,'name':action_name_modal,'requestor':action_requestor_modal,'status':status_action_modal,
      'severity':priority_action_modal,'percent_complete':action_percentage_modal,
      'estimated_start_date':estimated_start_date,'estimated_end_date':estimated_end_date,
      'description':description_action_modal,'next_action_description':description_next_action_modal,'next_action_dependency':next_action_dependency_modal,
      'next_action_due_date':next_action_due_date_modal,'section':section_action_modal
      };
    if (action_action_modal == "create") {
      data.project_id = project_id_action_modal;
      data.user_id = user_id_action_modal;
    } else if (action_action_modal == "update") {
      data.id = action_id;
    }
    //console.log(data);

    $.ajax({
          type: 'post',
          url: "{!! route('projectActionInsertUpdate') !!}",
          data:data,
          dataType: 'json',
          success: function(data) {
            $('#num_of_actions').text(data.num_of_actions);
            //console.log(data);
            if (data.result == 'success'){
                box_type = 'success';
                message_type = 'success';
            }
            else {
                box_type = 'danger';
                message_type = 'error';
            }

            $('#flash-message').empty();
            var box = $('<div id="delete-message" class="alert alert-'+box_type+' alert-dismissible flash-'+message_type+'" role="alert"><button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>'+data.msg+'</div>');
            $('#flash-message').append(box);
            $('#delete-message').delay(2000).queue(function () {
                $(this).addClass('animated flipOutX')
            });
            actionsTable.ajax.reload();
          }
    });

    $('#actionModal').modal('hide');

  });

  @endif
  //endregion

  // This part is to make sure that datatables can adjust the columns size when it is hidden because of non active tab when created
  @if($action == 'update')
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
    });
  @endif

});
</script>
@stop
