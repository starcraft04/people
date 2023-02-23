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
        <h2>
          @if($action == 'create')
          Create customer
          @elseif($action == 'update')
          Update customer
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
          {!! Form::open(['url' => 'customerFormCreate', 'method' => 'post', 'class' => 'form-horizontal']) !!}

          @elseif($action == 'update')
          {!! Form::open(['url' => 'customerFormUpdate/'.$customer->id, 'method' => 'post', 'class' => 'form-horizontal']) !!}
          {!! Form::hidden('id', $customer->id, ['class' => 'form-control']) !!}
          @endif

          <div class="row">
            <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-3">
                {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-9">
                {!! Form::text('name', (isset($customer)) ? $customer->name : '', ['class' => 'form-control', 'placeholder' => 'name']) !!}
                {!! $errors->first('name', '<small class="help-block">:message</small>') !!}
              </div>
            </div>
          </div>

          <div class="row">

            <div class="form-group {!! $errors->has('cluster_owner') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-3">
                {!! Form::label('cluster_owner', 'Cluster owner', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-9">
                {!! Form::text('cluster_owner', (isset($customer)) ? $customer->cluster_owner : '', ['class' => 'form-control', 'placeholder' => 'Cluster owner']) !!}
                {!! $errors->first('cluster_owner', '<small class="help-block">:message</small>') !!}
              </div>
            </div>
          </div>
          <div class="row">
          <div class="form-group {!! $errors->has('country') ? 'has-error' : '' !!} col-md-12">
            <div class="col-md-3">
              {!! Form::label('country_owner', 'Country Owner', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-9">
              <select class="form-control select2" style="width: 100%;" id="country_owner" name="country_owner" data-placeholder="Select a country">
                <option value="" ></option>
                @foreach($countries as $key => $value)
                <option value="{{ $value }}"
                  @if (old('country') == $value) selected
                  @elseif (isset($customer->country_owner) && $value == $customer->country_owner) selected
                  @endif>
                  {{ $value }}
                </option>
                @endforeach
              </select>
              {!! $errors->first('country_owner', '<small class="help-block">:message</small>') !!}
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
    $("#country_owner").select2({
    allowClear: true
  });
});
</script>

@stop
