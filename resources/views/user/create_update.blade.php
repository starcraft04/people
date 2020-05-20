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
@stop

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
        <h2>
          @if($action == 'create')
            Create user
          @elseif($action == 'update')
            Update user
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

          @if($action == 'create')
            {!! Form::open(['url' => 'userFormCreate', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('user[from_otl]', 0) !!}
            {!! Form::hidden('password', 'Welcome1') !!}
            <p>
              The user will be created with a password of <b>Welcome1</b>
            </p>
          @elseif($action == 'update')
            {!! Form::open(['url' => 'userFormUpdate/'.$user->id, 'method' => 'post', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('user_id', $user->id) !!}
          @endif

          <div class="row">
              <div class="form-group {!! $errors->has('user.name') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('user[name]', 'Name', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::text('user[name]', (isset($user)) ? $user->name : '', ['class' => 'form-control', 'placeholder' => 'name']) !!}
                      {!! $errors->first('user.name', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('user.email') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('user[email]', 'Email', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::text('user[email]', (isset($user)) ? $user->email : '', ['class' => 'form-control', 'placeholder' => 'email']) !!}
                      {!! $errors->first('user.email', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('manager.manager_id') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('manager[manager_id]', 'Manager', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::select('manager[manager_id]', $manager_list, (isset($manager[0])) ? $manager[0] : '', ['id' => 'user_manager','class' => 'form-control']) !!}
                      {!! $errors->first('manager.manager_id', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('user.activity_status') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('user[activity_status]', 'Activity status', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::select('user[activity_status]', config('select.activity_status'), (isset($user)) ? $user->activity_status : '', ['id' => 'user_status','class' => 'form-control']) !!}
                      {!! $errors->first('user.activity_status', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
            <div class="form-group {!! $errors->has('user.date_started') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-2">
                  <label class="control-label" for="user[date_started]">Date started</label>
                </div>
                <div class="col-md-10">
                  <input type="text" id="user_start_date" name="user[date_started]" class="form-control" value="@if(isset($user->date_started)) {{ $user->date_started }} @endif"></input>
                  {!! $errors->first('user.date_started', '<small class="help-block">:message</small>') !!}
                </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group {!! $errors->has('user.date_ended') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-2">
                  <label class="control-label" for="user[date_ended]">Date ended</label>
                </div>
                <div class="col-md-10">
                  <input type="text" id="user_end_date" name="user[date_ended]" class="form-control" value="@if(isset($user->date_ended)) {{ $user->date_ended }} @endif"></input>
                  {!! $errors->first('user.date_ended', '<small class="help-block">:message</small>') !!}
                </div>
            </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('user.employee_type') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('user[employee_type]', 'Type', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::select('user[employee_type]', config('select.employee_type'), (isset($user)) ? $user->employee_type : '', ['id' => 'user_type','class' => 'form-control']) !!}
                      {!! $errors->first('user.employee_type', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('user.job_role') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('user[job_role]', 'Team', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::select('user[job_role]', config('select.job_role'), (isset($user)) ? $user->job_role : '', ['id' => 'user_job_role','class' => 'form-control']) !!}
                      {!! $errors->first('user.job_role', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('user.region') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('user[region]', 'Region', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::select('user[region]', config('select.region'), (isset($user)) ? $user->region : '', ['id' => 'user_region','class' => 'form-control']) !!}
                      {!! $errors->first('user.region', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
            <div class="form-group {!! $errors->has('user.country') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-2">
                  {!! Form::label('user[country]', 'Country', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-10">
                <select class="form-control select2" style="width: 100%;" id="country" name="user[country]" data-placeholder="Select a country">
                <option value="" ></option>
                @foreach(config('countries.country') as $key => $value)
                <option value="{{ $key }}"
                    @if (old('country') == $key) selected
                    @elseif (isset($user->country) && $value == $user->country) selected
                    @endif>
                    {{ $value }}
                </option>
                @endforeach
                </select>
                {!! $errors->first('user.country', '<small class="help-block">:message</small>') !!}
              </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group {!! $errors->has('managed_clusters.0') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-2">
                {!! Form::label('managed_clusters[]', 'Managed Clusters', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-10">
                <select class="form-control select2" style="width: 100%;" id="managed_clusters" name="managed_clusters[]" data-placeholder="Select a Cluster"  multiple="multiple">
                  <option value="" ></option>
                  @foreach($clusters as $cluster)
                  <option value="{{ $cluster }}" 
                  @if (old('managed_clusters') == $cluster) selected
                  @elseif(isset($userCluster) && in_array($cluster,$userCluster)) selected
                  @endif>
                  {{ $cluster }}
                  </option>
                  @endforeach
                </select>
                {!! $errors->first('managed_clusters.0', '<small class="help-block">:message</small>') !!}
              </div>
            </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('user.domain') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('user[domain]', 'Domain', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::select('user[domain]', config('domains.domain-users'), (isset($user)) ? $user->domain : '', ['id' => 'user_domain','class' => 'form-control']) !!}
                      {!! $errors->first('user.domain', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
            <div class="form-group {!! $errors->has('user.management_code') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-2">
                  {!! Form::label('user[management_code]', 'MC', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-10">
                <select class="form-control select2" style="width: 100%;" id="user_management_code" name="user[management_code]" data-placeholder="Select a management code">
                <option value="" ></option>
                @foreach(config('select.users-mc') as $key => $value)
                <option value="{{ $key }}"
                    @if (old('user[management_code]') == $key) selected
                    @elseif (isset($user->management_code) && $value == $user->management_code) selected
                    @endif>
                    {{ $value }}
                </option>
                @endforeach
                </select>
                {!! $errors->first('user.management_code', '<small class="help-block">:message</small>') !!}
              </div>
            </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('user.is_manager') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('is_manager', 'Is manager?', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      <input type="hidden" name="user[is_manager]" value="0">
                      {!! Form::checkbox('user[is_manager]', '1', (isset($user)) ? $user->is_manager : '', ['class' => 'checkbox']) !!}
                      {!! $errors->first('user.is_manager', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
            <div class="form-group {!! $errors->has('roles') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-2">
                {!! Form::label('roles', 'Roles', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-10">
                <select class="form-control select2" style="width: 100%;" id="roles" name="roles[]" data-placeholder="Select a role" multiple="multiple">
                  <option value="" ></option>
                  @foreach($roles as $key => $value)
                  <option value="{{ $key }}" 
                  @if(isset($defaultRole) && $value == $defaultRole)
                  selected
                  @elseif(isset($userRole) && in_array($value,$userRole))
                  selected
                  @endif>
                  {{ $value }}
                  </option>
                  @endforeach
                </select>
                {!! $errors->first('roles', '<small class="help-block">:message</small>') !!}
              </div>
            </div>
          </div>

          

          <div class="row">
              <div class="col-md-offset-11 col-md-1">
                @if($action == 'create')
                  {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
                @elseif($action == 'update')
                  {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                @endif
              </div>
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
  //Init select2 boxes
  $("#roles").select2({
    allowClear: true,
    disabled: {{ $role_select_disabled }}
  });

  $("#country").select2({
    allowClear: true
  });

  $("#managed_clusters").select2({
    placeholder: 'Select a cluster',
    allowClear: true
  });

  $("#user_management_code").select2({
    allowClear: true
  });

  $("#user_domain").select2({
    placeholder: 'Select a domain',
    allowClear: true
  });

  $("#user_region").select2({
    placeholder: 'Select a region',
    allowClear: true
  });

  $("#user_job_role").select2({
    placeholder: 'Select a job role',
    allowClear: true
  });

  $("#user_type").select2({
    placeholder: 'Select a user type',
    allowClear: true
  });

  $("#user_status").select2({
    placeholder: 'Select a user status',
    allowClear: true
  });

  $("#user_manager").select2({
    placeholder: 'Select a manager',
    allowClear: true
  });

  // Init Date range
  $('#user_start_date').daterangepicker({
      singleDatePicker: true,
      autoUpdateInput: false,
      locale: {
        format: 'YYYY-MM-DD',
        cancelLabel: 'Clear'
      }
  });

  $('#user_start_date').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD'));
  });

  $('#user_start_date').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });

  // Init Date range
  $('#user_end_date').daterangepicker({
      singleDatePicker: true,
      autoUpdateInput: false,
      locale: {
        format: 'YYYY-MM-DD',
        cancelLabel: 'Clear'
      }
  });

  $('#user_end_date').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD'));
  });

  $('#user_end_date').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });


  // Now this is important so that we send the value of all disabled fields
  // What it does is when you try to submit, it will remove the disabled property on all fields with disabled
  jQuery(function ($) {
    $('form').bind('submit', function () {
      $(this).find(':input').prop('disabled', false);
    });
  });


});
</script>


@stop