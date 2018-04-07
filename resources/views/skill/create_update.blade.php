@extends('layouts.app')

@section('content')

<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Skill</h3>
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
          {!! Form::open(['url' => 'skillFormCreate', 'method' => 'post', 'class' => 'form-horizontal']) !!}

          @elseif($action == 'update')
          {!! Form::open(['url' => 'skillFormUpdate/'.$skill->id, 'method' => 'post', 'class' => 'form-horizontal']) !!}
          {!! Form::hidden('id', $skill->id, ['class' => 'form-control']) !!}
          @endif

          <div class="row">
            <div class="form-group {!! $errors->has('domain') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-3">
                {!! Form::label('domain', 'Domain', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-9">
                {!! Form::text('domain', (isset($skill)) ? $skill->domain : '', ['class' => 'form-control', 'placeholder' => 'domain']) !!}
                {!! $errors->first('domain', '<small class="help-block">:message</small>') !!}
              </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group {!! $errors->has('subdomain') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-3">
                {!! Form::label('subdomain', 'Sub-domain', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-9">
                {!! Form::text('subdomain', (isset($skill)) ? $skill->subdomain : '', ['class' => 'form-control', 'placeholder' => 'subdomain']) !!}
                {!! $errors->first('subdomain', '<small class="help-block">:message</small>') !!}
              </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group {!! $errors->has('technology') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-3">
                {!! Form::label('technology', 'Technology', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-9">
                {!! Form::text('technology', (isset($skill)) ? $skill->technology : '', ['class' => 'form-control', 'placeholder' => 'technology']) !!}
                {!! $errors->first('technology', '<small class="help-block">:message</small>') !!}
              </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group {!! $errors->has('skill') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-3">
                {!! Form::label('skill', 'Skill', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-9">
                {!! Form::text('skill', (isset($skill)) ? $skill->skill : '', ['class' => 'form-control', 'placeholder' => 'skill']) !!}
                {!! $errors->first('skill', '<small class="help-block">:message</small>') !!}
              </div>
            </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('certification') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-3">
                      {!! Form::label('certification', 'Certification', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-9">
                      {!! Form::checkbox('certification', '1', (isset($skill)) ? $skill->certification : '', ['class' => 'checkbox']) !!}
                      {!! $errors->first('manager_id', '<small class="help-block">:message</small>') !!}
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
