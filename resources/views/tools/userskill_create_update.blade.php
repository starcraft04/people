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
    <h3>User Skill</h3>
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
          Create skill
          @elseif($action == 'update')
          Update skill
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
          {!! Form::open(['url' => 'userskillFormCreate', 'method' => 'post', 'class' => 'form-horizontal']) !!}
          {!! Form::hidden('skill_id', $skill->id, ['class' => 'form-control']) !!}

          @elseif($action == 'update')
          {!! Form::open(['url' => 'userskillFormUpdate/'.$userskill->id, 'method' => 'post', 'class' => 'form-horizontal']) !!}
          @endif
          <div class="row">
            <div class="col-md-1"><b>Domain</b></div>
            <div class="col-md-2"><b>Sub-domain</b></div>
            <div class="col-md-2"><b>Technology</b></div>
            <div class="col-md-2"><b>Skill</b></div>
            <div class="col-md-2"><b>Certification</b></div>
          </div>
          <div class="row">
            <div class="col-md-1">{!! $skill->domain !!}</div>
            <div class="col-md-2">{!! $skill->subdomain !!}</div>
            <div class="col-md-2">{!! $skill->technology !!}</div>
            <div class="col-md-2">{!! $skill->skill !!}</div>
            <div class="col-md-2">{!! $skill->certification !!}</div>
          </div>
          <br />

        <div class="row">
          <div class="form-group {!! $errors->has('user_id') ? 'has-error' : '' !!} col-md-12">
            <div class="col-md-2">
              {!! Form::label('user_id', 'User', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-10">
              {!! Form::select('user_id', $user_list, (isset($userskill)) ? $userskill->user_id : '', ['class' => 'form-control']) !!}
              {!! $errors->first('user_id', '<small class="help-block">:message</small>') !!}
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-group {!! $errors->has('rating') ? 'has-error' : '' !!} col-md-12">
            <div class="col-md-2">
              {!! Form::label('rating', 'Rating', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-10">
              {!! Form::select('rating', config('select.userskill_rating'), (isset($userskill)) ? $userskill->rating : '', ['class' => 'form-control']) !!}
              {!! $errors->first('rating', '<small class="help-block">:message</small>') !!}
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
$(document).ready(function() {
  $("#user_id").select2({
    allowClear: false
    @if($action == 'update')
      ,disabled: true
    @endif
  });
  $("#rating").select2({
    allowClear: false
  });
});
</script>

@stop
