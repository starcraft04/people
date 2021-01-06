@extends('layouts.app')

@section('style')
<!-- CSS -->
<!-- Select2 -->
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
</style>
@stop

@section('scriptsrc')
<!-- JS -->
<!-- Bootbox -->
<script src="{{ asset('/plugins/bootbox/bootbox.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
@stop

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
        <h2>Options</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
          {!! Form::open(['url' => 'optionsUpdate/'.$user->id, 'method' => 'post', 'class' => 'form-horizontal']) !!}
          {!! Form::hidden('id', $user->id, ['class' => 'form-control', 'placeholder' => 'id']) !!}

          <div class="row">
              <div class="form-group {!! $errors->has('clusterboard_top') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('clusterboard_top', 'Cluster Dashboard Top', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                  {!! Form::text('clusterboard_top', (isset(Auth::user()->clusterboard_top)) ? Auth::user()->clusterboard_top : 0, ['class' => 'form-control', 'placeholder' => 'Top']) !!}
                  {!! $errors->first('clusterboard_top', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('revenue_product_codes') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('revenue_product_codes', 'Revenue product codes', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                  {!! Form::text('revenue_product_codes', (isset(Auth::user()->revenue_product_codes)) ? Auth::user()->revenue_product_codes : '', ['class' => 'form-control', 'placeholder' => 'comma separated values / leave blank for all']) !!}
                  {!! $errors->first('revenue_product_codes', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('revenue_target') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('revenue_target', 'Revenue target (€)', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                  {!! Form::text('revenue_target', (isset(Auth::user()->revenue_target)) ? Auth::user()->revenue_target : '', ['class' => 'form-control', 'placeholder' => 'Revenue target (€)']) !!}
                  {!! $errors->first('revenue_target', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('order_target') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('order_target', 'Order target (€)', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                  {!! Form::text('order_target', (isset(Auth::user()->order_target)) ? Auth::user()->order_target : '', ['class' => 'form-control', 'placeholder' => 'Order target (€)']) !!}
                  {!! $errors->first('order_target', '<small class="help-block">:message</small>') !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="form-group {!! $errors->has('table_height') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-2">
                      {!! Form::label('table_height', 'Table height (between 10 and 200)', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-10">
                  {!! Form::text('table_height', (isset(Auth::user()->table_height)) ? Auth::user()->table_height : '', ['class' => 'form-control', 'placeholder' => 'Table height']) !!}
                  {!! $errors->first('table_height', '<small class="help-block">:message</small>') !!}
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
        <div class="col-md-2">
          <button id="git_pull" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Check update</button>
        </div>
        <div class="col-md-2">
          <button id="debug_true" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> DEBUG true</button>
        </div>
        <div class="col-md-2">
          <button id="debug_false" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> DEBUG false</button>
        </div>
        <div class="col-md-2">
          <button id="db_cleanup" class="btn btn-success"><span class="glyphicon glyphicon-floppy-remove"></span> DB Cleanup</button>
        </div>
        <div class="col-md-2">
          <button id="factory_reset" class="btn btn-success"><span class="glyphicon glyphicon-trash"></span> Factory reset</button>
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
      <!-- Modal -->
      <div class="modal fade" id="modal_clean_db" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="display:table;">
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modal_clean_db_title">Clean DB</h4>
            </div>
            <!-- Modal Header -->
              
            <!-- Modal Body -->
            <div class="modal-body">
              All activities before the date selected will be deleted and all projects without an activity will be deleted.
              <form id="modal_clean_db_form" role="form" method="POST" action="">
                <div id="modal_clean_db_formgroup_year" class="col-md-6 col-sm-12 form-group">
                  <label class="control-label" for="modal_clean_db_form_year">Year</label>
                  <select class="form-control select2" style="width: 100%;" id="modal_clean_db_form_year" data-placeholder="Select a priority">
                    <option value="" ></option>
                    @foreach(config('select.year') as $key => $value)
                    <option value="{{ $key }}" @if(date('Y')==$key)selected @endif>
                      {{ $value }}
                    </option>
                    @endforeach
                  </select>
                  <span id="modal_clean_db_form_year_error" class="help-block"></span>
                </div>
                <div class="form-group">
                  <div id="modal_clean_db_form_hidden">
                  </div>
                </div>
              </form>  
            </div>
              
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="modal_clean_db_create_update_button" class="btn btn-success">Clean</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal -->

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

    // DB cleanup
    // Init select2 boxes in the modal
    $("#modal_clean_db_form_year").select2({
        allowClear: false
    });

    $(document).on('click', '#db_cleanup', function () {
      $('#modal_clean_db').modal("show");
    });

    // Factory reset
    $(document).on('click', '#factory_reset', function () {
      bootbox.confirm("Are you sure want to factory reset? Attention, the admin password will be set to Welcome1", function(result) {
          if (result){
              $.ajax({
                  type: 'get',
                  url: "{!! route('factory_reset') !!}",
                  dataType: 'json',
                  success: function(data) {
                      console.log(data);
                      $("#result").empty();
                      $("#result").append('Database reset complete. Please login with the account admin@orange.com with password Welcome1');
                  }
              });
          }
      });
    });

  });
</script>
@stop
