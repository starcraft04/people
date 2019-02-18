@extends('layouts.app')

@section('style')
    <!-- CSS -->
    <!-- Select2 -->
    <link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/forms.css') }}" rel="stylesheet" />

@stop

@section('scriptsrc')
    <!-- JS -->
    <!-- Select2 -->
    <script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
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
            {!! Form::hidden('from_otl', 0, ['class' => 'form-control']) !!}
          @elseif($action == 'update')
            {!! Form::open(['url' => 'userFormUpdate/'.$user->id, 'method' => 'post', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('id', $user->id, ['class' => 'form-control']) !!}
            {!! Form::hidden('from_otl', $user->from_otl, ['class' => 'form-control']) !!}
          @endif

          <div class="row">
              <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::text('name', (isset($user)) ? $user->name : '', ['class' => 'form-control', 'placeholder' => 'name']) !!}
                      {!! $errors->first('name', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::text('email', (isset($user)) ? $user->email : '', ['class' => 'form-control', 'placeholder' => 'email']) !!}
                      {!! $errors->first('email', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('password') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::password('password', ['class' => 'form-control']) !!}
                      {!! $errors->first('password', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('confirm-password') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('confirm-password', 'Confirm', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::password('confirm-password', ['class' => 'form-control']) !!}
                      {!! $errors->first('confirm-password', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('manager_id') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('manager_id', 'Manager', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::select('manager_id', $manager_list, (isset($manager[0])) ? $manager[0]->manager_id : '', ['class' => 'form-control']) !!}
                      {!! $errors->first('manager_id', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('activity_status') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('activity_status', 'Activity status', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::select('activity_status', config('select.activity_status'), (isset($user)) ? $user->activity_status : '', ['class' => 'form-control']) !!}
                      {!! $errors->first('activity_status', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
            <div class="form-group {!! $errors->has('date_started') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-2">
                {!! Form::label('date_started', 'Date started', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-10">
                {!! Form::date('date_started', (isset($user->date_started)) ? $user->date_started : '', ['class' => 'form-control']) !!}
                {!! $errors->first('date_started', '<small class="help-block">:message</small>') !!}
              </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group {!! $errors->has('date_ended') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-2">
                {!! Form::label('date_ended', 'Date ended', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-10">
                {!! Form::date('date_ended', (isset($user->date_ended)) ? $user->date_ended : '', ['class' => 'form-control']) !!}
                {!! $errors->first('date_ended', '<small class="help-block">:message</small>') !!}
              </div>
            </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('employee_type') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('employee_type', 'Type', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::select('employee_type', config('select.employee_type'), (isset($user)) ? $user->employee_type : '', ['class' => 'form-control']) !!}
                      {!! $errors->first('employee_type', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('job_role') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('job_role', 'Team', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::select('job_role', config('select.job_role'), (isset($user)) ? $user->job_role : '', ['class' => 'form-control']) !!}
                      {!! $errors->first('job_role', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('region') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('region', 'Region', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::select('region', config('select.region'), (isset($user)) ? $user->region : '', ['class' => 'form-control']) !!}
                      {!! $errors->first('region', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
            <div class="form-group {!! $errors->has('country') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-2">
                  {!! Form::label('country', 'Country', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-10">
                <select class="form-control select2" style="width: 100%;" id="country" name="country" data-placeholder="Select a country">
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
                {!! $errors->first('country', '<small class="help-block">:message</small>') !!}
              </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group {!! $errors->has('managed_cluster') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-2">
                {!! Form::label('managed_cluster', 'Managed Clusters', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-10">
                <select class="form-control select2" style="width: 100%;" id="managed_cluster" name="managed_cluster[]" data-placeholder="Select a Cluster"  multiple="multiple">
                  <option value="" ></option>
                  @foreach($clusters as $cluster)
                  <option value="{{ $cluster }}" 
                  @if (old('managed_cluster') == $cluster) selected
                  @elseif(isset($userCluster) && in_array($cluster,$userCluster)) selected
                  @endif>
                  {{ $cluster }}
                  </option>
                  @endforeach
                </select>
                {!! $errors->first('managed_cluster', '<small class="help-block">:message</small>') !!}
              </div>
            </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('domain') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('domain', 'Domain', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::select('domain', config('domains.domain-users'), (isset($user)) ? $user->domain : '', ['class' => 'form-control']) !!}
                      {!! $errors->first('domain', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('management_code') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('management_code', 'MC', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::text('management_code', (isset($user)) ? $user->management_code : '', ['class' => 'form-control', 'placeholder' => 'management code']) !!}
                      {!! $errors->first('management_code', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('is_manager') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('is_manager', 'Is manager?', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::checkbox('is_manager', '1', (isset($user)) ? $user->is_manager : '', ['class' => 'checkbox']) !!}
                      {!! $errors->first('manager_id', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
            <div class="form-group {!! $errors->has('roles') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-2">
                {!! Form::label('roles', 'Roles', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-10">
                <select class="form-control select2" style="width: 100%;" id="roles" name="roles[]" data-placeholder="Select a role"  multiple="multiple">
                  <option value="" ></option>
                  @foreach($roles as $key => $value)
                  <option value="{{ $key }}" 
                  @if(isset($defaultRole) && $value == $defaultRole)
                  selected
                  @elseif(isset($userRole) && in_array($key,$userRole))
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

  $("#managed_cluster").select2({
    allowClear: true
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