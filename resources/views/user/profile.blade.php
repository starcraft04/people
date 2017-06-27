@extends('layouts.app')

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Profile</h3>
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
        <h2>Change password</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <br />
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
          {!! Form::open(['url' => 'passwordUpdate/'.$user->id, 'method' => 'post', 'class' => 'form-horizontal']) !!}
          {!! Form::hidden('id', $user->id, ['class' => 'form-control', 'placeholder' => 'id']) !!}

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
              <div class="col-md-offset-11 col-md-1">
                {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
              </div>
          </div>
          {!! Form::close() !!}
      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->
@if (Auth::user()->name == 'admin')
<!-- Window -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window title -->
      <div class="x_title">
        <h2>Tools</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <div class="col-md-1">
          <button id="git_pull" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Git PULL</button>
        </div>
        <div class="col-md-1">
          <button id="debug_true" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> DEBUG true</button>
        </div>
        <div class="col-md-1">
          <button id="debug_false" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> DEBUG false</button>
        </div>
      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->

<!-- Window -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window title -->
      <div class="x_title">
        <h2>Output</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <pre id="result">
        </pre>
      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->
@endif
@stop

@section('script')
<script>
  $(document).ready(function() {

    // git pull
    $(document).on('click', '#git_pull', function () {
      $.ajax({
          type: 'get',
          url: "{!! route('ajax_git_pull') !!}",
          success: function(data) {
            $("#result").empty();
            $("#result").append(data);
          }
      });
    });

    // DEBUG true
    $(document).on('click', '#debug_true', function () {
      $.ajax({
          type: 'get',
          url: "{!! route('ajax_env_app_debug','true') !!}",
          success: function(data) {
            $("#result").empty();
            $("#result").append('set to true');
          }
      });
    });

    // DEBUG false
    $(document).on('click', '#debug_false', function () {
      $.ajax({
          type: 'get',
          url: "{!! route('ajax_env_app_debug','false') !!}",
          success: function(data) {
            $("#result").empty();
            $("#result").append('set to false');
          }
      });
    });

  });
</script>
@stop
