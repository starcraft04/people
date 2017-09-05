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
    <h3>Cluster</h3>
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
            Create cluster
          @elseif($action == 'update')
            Update cluster
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
            {!! Form::open(['url' => 'clusterFormCreate', 'method' => 'post', 'class' => 'form-horizontal']) !!}
           
          @elseif($action == 'update')
            {!! Form::open(['url' => 'clusterFormUpdate/'.$cluster->id, 'method' => 'post', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('cluster_id', $cluster->id, ['class' => 'form-control']) !!}
          @endif

          <div class="row">
              <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                      {!! Form::text('name', (isset($cluster)) ? $cluster->name : '', ['class' => 'form-control', 'placeholder' => 'Cluster Name']) !!}
                      {!! $errors->first('name', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>
         
          <div class="row">
            <div class="form-group {!! $errors->has('countries') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-2">
                  {!! Form::label('countries', 'Countries', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-10">
                <select class="form-control select2" style="width: 100%;" id="countries" name="countries[]" data-placeholder="Select a countries" multiple="multiple">
                
                <option value="" ></option>
                @foreach(config('countries.country') as $key => $value)
                <option value="{{ $key }}"
                    @if (old('countries') == $key) selected
                    @elseif (isset($clusterCountries) && in_array($value,$clusterCountries)) selected
                    @endif>
                    {{ $value }}
                </option>
                @endforeach
                </select>
                {!! $errors->first('countries', '<small class="help-block">:message</small>') !!}
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
  $("#countries").select2({
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