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
@stop

@section('content')
<!-- Selections -->
  <div class="form-group row">
    <div class="col-xs-3">
      <h3>User <small>summary</small></h3>
    </div>
    <div class="col-xs-3">
      <label for="month" class="control-label">Year</label>
      <select class="form-control select2" id="year" name="year" data-placeholder="Select a year">
        @foreach($authUsersForDataView->year_list as $key => $value)
        <option value="{{ $key }}"
          @if(isset($authUsersForDataView->year_selected) && $key == $authUsersForDataView->year_selected) selected
          @endif>
          {{ $value }}
        </option>
        @endforeach
      </select>
    </div>
    <div class="col-xs-3">
      <label for="user" class="control-label">User</label>
      <select class="form-control select2" id="user" name="user" data-placeholder="Select a user">
        @foreach($authUsersForDataView->user_list as $key => $value)
        <option value="{{ $key }}"
          @if(isset($authUsersForDataView->user_selected) && $key == $authUsersForDataView->user_selected) selected
          @endif>
          {{ $value }}
        </option>
        @endforeach
      </select>
    </div>
    <div class="col-xs-3">
      <label for="closed" class="control-label">Hide closed actions</label>
      <input name="closed" type="checkbox" id="switch_actions_closed" class="form-group js-switch-small" checked /> 
    </div>
  </div>
<!-- Selections -->
<div class="clearfix"></div>
<!-- Page title -->

<!-- Window -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <!-- Window content -->
      <div class="x_content">
        <!-- Load -->
        <div class="row">
          <h3>General</h3>
          <h4>Load</h4>
          <table id="loadTable" class="table table-striped table-hover table-bordered mytable" width="100%">
            <thead>
              <tr>
                <th>Jan</th>
                <th>Feb</th>
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
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <div class="row">
          <h4>Actions</h4>
          <table id="general" data-project_id="" class="table table-striped table-hover table-bordered mytable actions" width="100%">
            <thead>
              <tr>
                <th style="{{ $extra_info_display }}">Action ID</th>
                <th style="{{ $extra_info_display }}">Created by ID</th>
                <th>Created by</th>
                <th style="{{ $extra_info_display }}">Assigned to ID</th>
                <th style="{{ $extra_info_display }}">Assigned to</th>
                <th>Name</th>
                <th style="{{ $extra_info_display }}">Section</th>
                <th style="{{ $extra_info_display }}">Project ID</th>
                <th style="{{ $extra_info_display }}">Project Name</th>
                <th>Status</th>
                <th>Severity</th>
                <th>Description</th>
                <th>Start</th>
                <th>End</th>
                <th>
                  @permission('action-create')
                    <button type="button" class="btn btn-info btn-xs new_action"><span class="glyphicon glyphicon-plus"></span></button>
                  @endpermission
                </th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <!-- Load -->

      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->

  @stop

  @section('script')
  <script>
  var year = [];
  var user = [];
  var datatablesUse = false;
  var load;
  var load_months = ['jan_com','feb_com','mar_com','apr_com','may_com','jun_com','jul_com','aug_com','sep_com','oct_com','nov_com','dec_com'];
  var user_id = {{ $user_id }};
  var loadActionsTable;
  var hide_closed = true;

  // Here we are going to get from PHP the list of roles and their value for the logged in customer
  // Roles check
  <?php
          $options = array(
              'validate_all' => true,
              'return_type' => 'both'
          );
          list($validate, $allValidations) = Entrust::ability(null,array('action-create','action-edit','action-delete','action-all'),$options);
          echo "var permissions = jQuery.parseJSON('".json_encode($allValidations['permissions'])."');";
  ?>
  //console.log(permissions);
  // Roles check


  // This is the function that will set the values in the select2 boxes with info from Cookies
  function fill_select(select_id){
    array_to_use = [];
    values = Cookies.get(select_id);

    if (values != null) {
      values = values.replace(/\"/g,'').replace('[','').replace(']','');
      values = values.split(',');
      $('#'+select_id).val(values).trigger('change');
      array_to_use = [];
      $("#"+select_id+" option:selected").each(function()
      {
        // log the value and text of each option
        array_to_use.push($(this).val());

      });
    }
    else {
      $("#"+select_id+" option:selected").each(function()
      {
        // log the value and text of each option
        array_to_use.push($(this).val());
      });
    }
    return array_to_use;
  }

  $(document).ready(function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // switchery
    var small = document.querySelector('.js-switch-small');
    var switchery = new Switchery(small, { size: 'small' });

    // SELECTIONS START
    // ________________
    // First we define the select2 boxes

    //Init select2 boxes
    $("#year").select2({
      allowClear: false,
      disabled: {{ $authUsersForDataView->year_select_disabled }}
    });
    //Init select2 boxes
    $("#user").select2({
      allowClear: false,
      disabled: {{ $authUsersForDataView->user_select_disabled }}
    });

    // Then we need to get back the information from the cookie

    year = fill_select('year');
    user = fill_select('user');

    //alert($.fn.dataTable.version);

    // Then we define what happens when the selection changes

    $('#year').on('change', function() {
      Cookies.set('year', $('#year').val());
      year = [];
      $("#year option:selected").each(function()
      {
        // log the value and text of each option
        year.push($(this).val());
        load();
      });
    });

    $('#user').on('change', function() {
      Cookies.set('user', $('#user').val());
      user = [];
      $("#user option:selected").each(function()
      {
        // log the value and text of each option
        user.push($(this).val());
        load();
        loadActions();
      });
    });

    // SELECTIONS END

    // LOAD

    // LOAD DATA

    function load() {
      $.ajax({
        url: "{!! route('listOfLoadPerUserAjax') !!}",
        type: "POST",
        data: {'year[]': year,'user[]': user,'datatablesUse': datatablesUse},
        dataType: "JSON",
        success:function(data){
          //console.log(data);
          var markup = "<tr>";
          load_months.forEach(function (item, index) 
            { 
              markup += "<td>"+data.data[0][item]+"</td>";
            });
          markup += "</tr>";
          $("#loadTable tbody").empty();
          $("#loadTable tbody").append(markup);
        }
      });
    }

    load();

    // LOAD DATA

    // LOAD ACTIONS

    function loadActions(table) {
      section = $("#"+table).attr('id');
      project_id = $("#"+table).attr('data-project_id');
      // console.log(project_id);

      $.ajax({
        url: "{!! route('actionList') !!}",
        type: "POST",
        data: {'user[]': user,'section': section,'project_id': project_id,'hide_closed':hide_closed},
        dataType: "JSON",
        success:function(data){
          var markup = "";
          //console.log(data);
          data.forEach(function (item, index) 
            { 
              if (item['action_estimated_start_date'] == null) {
                item['action_estimated_start_date'] = '';
              }
              if (item['action_estimated_end_date'] == null) {
                item['action_estimated_end_date'] = '';
              }
              markup += '<tr>';
              markup += '<td name="action_id" style="{{ $extra_info_display }}">'+item['action_id']+'</td>';
              markup += '<td name="created_by_id" style="{{ $extra_info_display }}">'+item['created_by_id']+'</td>';
              markup += '<td name="created_by_name">'+item['created_by_name']+'</td>';
              markup += '<td name="assigned_to_id" style="{{ $extra_info_display }}">'+item['assigned_to_id']+'</td>';
              markup += '<td name="assigned_to_name" style="{{ $extra_info_display }}">'+item['assigned_to_name']+'</td>';
              markup += '<td name="action_name">'+item['action_name']+'</td>';
              markup += '<td name="action_section" style="{{ $extra_info_display }}">'+item['action_section']+'</td>';
              markup += '<td name="action_project_id" style="{{ $extra_info_display }}">'+item['project_id']+'</td>';
              markup += '<td name="action_project_name" style="{{ $extra_info_display }}">'+item['project_name']+'</td>';
              markup += '<td name="action_status">'+item['action_status']+'</td>';
              markup += '<td name="action_severity">'+item['action_severity']+'</td>';
              markup += '<td name="action_description">'+item['action_description']+'</td>';
              markup += '<td name="action_estimated_start_date">'+item['action_estimated_start_date']+'</td>';
              markup += '<td name="action_estimated_end_date">'+item['action_estimated_end_date']+'</td>';
              markup += '<td>';
              delete_permission = false;
              edit_permission = false;
              if (permissions['action-delete'] && item['created_by_id'] == {!! $user_id !!}) {
                delete_permission = true;
              }
              if (permissions['action-edit'] && item['created_by_id'] == {!! $user_id !!}) {
                edit_permission = true;
              }
              if (permissions['action-all']) {
                delete_permission = true;
                edit_permission = true;
              }
              
              if (edit_permission) {
                markup += '<button type="button" class="buttonActionEdit btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></button>';
              }
              if (delete_permission) {
                markup += '<button type="button" class="buttonActionDelete btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></button>';
              }
              markup += '</td>';
              markup += '</tr>';
            });
          
          $("#"+table+" tbody").empty();
          $("#"+table+" tbody").append(markup);
        }
      });
    }

    // We go through all the tables with class actions and load them with ajax data
    $("table.actions").each(function (index, value) {
        loadActions($(this).attr('id'));
    });

    

    $('.new_action').click(function(){
      var table = $(this).closest('table').attr('id');
      var project_id = $(this).closest('table').attr('data-project_id');
      var project_name = $(this).closest('table').attr('data-project_name');
      var assigned_id = $('#user option:selected').val();
      var assigned_name = $('#user option:selected').text();
      //console.log(table);
      $(this).hide();
      var html = '<tr>';
      html += '<td style="{{ $extra_info_display }}"></td>';
      html += '<td name="user_id" style="{{ $extra_info_display }}">{{ $user_id }}</td>';
      html += '<td name="user_name">{{ $user_name }}</td>';
      html += '<td name="assigned_user_id" style="{{ $extra_info_display }}">'+assigned_id+'</td>';
      html += '<td name="assigned_user_name" style="{{ $extra_info_display }}">'+assigned_name+'</td>';
      html += '<td><input type="text" name="action_name"></td>';
      html += '<td name="section" style="{{ $extra_info_display }}">'+table+'</td>';
      html += '<td name="project_id" style="{{ $extra_info_display }}">'+project_id+'</td>';
      html += '<td name="project_name" style="{{ $extra_info_display }}">'+project_name+'</td>';
      html += '<td>';
        html += '<select class="form-control select2 load_action_select" style="width: 100%;" name="action_status">';
          @foreach(config('select.action_status') as $key => $value)
            html += '<option value="{{ $key }}" @if ($value == "open") selected @endif>';
            html += '{{ $value }}';
            html += '</option>';
          @endforeach
        html += '</select>';
      html += '</td>';
      html += '<td>';
        html += '<select class="form-control select2 load_action_select" style="width: 100%;" name="action_severity">';
          @foreach(config('select.action_severity') as $key => $value)
            html += '<option value="{{ $key }}" @if ($value == "low") selected @endif>';
            html += '{{ $value }}';
            html += '</option>';
          @endforeach
        html += '</select>';
      html += '</td>';
      html += '<td><textarea rows="4" name="action_description"></textarea></td>';
      html += '<td><input type="text" class="load_action_estimated_date_input" name="action_start_date"></td>';
      html += '<td><input type="text" class="load_action_estimated_date_input" name="action_end_date"></td>';
      html += '<td>';
        html += '<button type="button" name="action_insert" class="btn btn-success btn-xs action_insert"><span class="glyphicon glyphicon-log-in"></span></button>';
        html += '<button type="button" name="action_insert_cancel" class="btn btn-success btn-xs action_insert_cancel"><span class="glyphicon glyphicon-remove"></span></button>';
      html += '</td>';
      html += '</tr>';
      
      $('#'+table+' tbody').prepend(html);

      // init DateRange picker
      $('.load_action_estimated_date_input').daterangepicker({
        locale: {
        format: 'YYYY-MM-DD'
        },
        showISOWeekNumbers: true,
        showDropdowns: true,
        autoApply: true,
        disabled: true,
        singleDatePicker: true
      });
      $(".load_action_select").select2({
      allowClear: false,
      minimumResultsForSearch: Infinity
      });
    });

    $(document).on('click', '.action_insert_cancel', function(){
      var table = $(this).closest('table').attr('id');
      button = $('#'+table).find('.new_action');
      button.show();
      loadActions(table);
    });

    $(document).on('click', '.action_insert', function(){
      var $row = $(this).closest("tr");
      var id = $row.find('td[name="action_id"]').text();
      var created_user_id = $row.find('td[name="user_id"]').text();
      var created_user_name = $row.find('td[name="user_name"]').text();
      var assigned_user_id = $row.find('td[name="assigned_user_id"]').text();
      var assigned_user_name = $row.find('td[name="assigned_user_name"]').text();
      var section = $row.find('td[name="section"]').text();
      var project_id = $row.find('td[name="project_id"]').text();
      var project_name = $row.find('td[name="project_name"]').text();
      var name = $row.find('input[name="action_name"]').val();
      var status = $row.find('select[name="action_status"] option:selected').val();
      var severity = $row.find('select[name="action_severity"] option:selected').val();
      var description = $row.find('textarea[name="action_description"]').val();
      var action_start_date = $row.find('input[name="action_start_date"]').val();
      var action_end_date = $row.find('input[name="action_end_date"]').val();

      $.ajax({
        url: "{!! route('actionInsertUpdate') !!}",
        type: "POST",
        data: {'id': id,'user_id': created_user_id,'assigned_user_id': assigned_user_id,'name': name,'section': section,'project_id': project_id,
          'status': status,'severity': severity,'description': description,
          'estimated_start_date': action_start_date,'estimated_end_date': action_end_date},
        dataType: "JSON",
        success:function(data){
          //console.log(data);
          button = $('#'+section).find('.new_action');
          button.show();
          loadActions(section);

          // Flash message
          $('#flash-message').empty();
          var box = $('<div id="delete-message" class="alert alert-'+data.box_type+' alert-dismissible flash-'+data.message_type+'" role="alert"><button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>'+data.msg+'</div>');
          $('#flash-message').append(box);
          $('#delete-message').delay(2000).queue(function () {
              $(this).addClass('animated flipOutX')
          });
          // Flash message
        }
      });

    });

    $(document).on('click', '.buttonActionDelete', function(){
      var $row = $(this).closest("tr");
      var id = $row.find('td[name="action_id"]').text();
      var table = $(this).closest('table').attr('id');

      $.ajax({
        url: "{!! route('actionDelete') !!}",
        type: "POST",
        data: {'id': id},
        dataType: "JSON",
        success:function(data){
          //console.log(data);
          loadActions(table);

          // Flash message
          $('#flash-message').empty();
          var box = $('<div id="delete-message" class="alert alert-'+data.box_type+' alert-dismissible flash-'+data.message_type+'" role="alert"><button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>'+data.msg+'</div>');
          $('#flash-message').append(box);
          $('#delete-message').delay(2000).queue(function () {
              $(this).addClass('animated flipOutX')
          });
          // Flash message
        }
      });
    });

    $(document).on('click', '.buttonActionEdit', function(){
      var $row = $(this).closest("tr");
      var id = $row.find('td[name="action_id"]').text();
      var created_user_id = $row.find('td[name="created_by_id"]').text();
      var created_user_name = $row.find('td[name="created_by_name"]').text();
      var assigned_user_id = $row.find('td[name="assigned_to_id"]').text();
      var assigned_user_name = $row.find('td[name="assigned_to_name"]').text();
      var section = $row.find('td[name="action_section"]').text();
      var project_id = $row.find('td[name="action_project_id"]').text();
      var project_name = $row.find('td[name="action_project_name"]').text();
      var name = $row.find('td[name="action_name"]').text();
      var status = $row.find('td[name="action_status"]').text();
      var severity = $row.find('td[name="action_severity"]').text();
      var description = $row.find('td[name="action_description"]').text();
      var action_start_date = $row.find('td[name="action_estimated_start_date"]').text();
      var action_end_date = $row.find('td[name="action_estimated_end_date"]').text();

      var html = '';
      html += '<td name="action_id" style="{{ $extra_info_display }}">'+id+'</td>';
      html += '<td name="user_id" style="{{ $extra_info_display }}">'+created_user_id+'</td>';
      html += '<td name="user_name">'+created_user_name+'</td>';
      html += '<td name="assigned_user_id" style="{{ $extra_info_display }}">'+assigned_user_id+'</td>';
      html += '<td name="assigned_user_name" style="{{ $extra_info_display }}">'+assigned_user_name+'</td>';
      html += '<td><input type="text" name="action_name" value="'+name+'"></td>';
      html += '<td name="section" style="{{ $extra_info_display }}">'+section+'</td>';
      html += '<td name="project_id" style="{{ $extra_info_display }}">'+project_id+'</td>';
      html += '<td name="project_name" style="{{ $extra_info_display }}">'+project_name+'</td>';
      html += '<td>';
        html += '<select class="form-control select2 load_action_select" style="width: 100%;" name="action_status">';
          @foreach(config('select.action_status') as $key => $value)
            html += '<option value="{{ $key }}" @if ($value == "open") selected @endif>';
            html += '{{ $value }}';
            html += '</option>';
          @endforeach
        html += '</select>';
      html += '</td>';
      html += '<td>';
        html += '<select class="form-control select2 load_action_select" style="width: 100%;" name="action_severity">';
          @foreach(config('select.action_severity') as $key => $value)
            html += '<option value="{{ $key }}" @if ($value == "low") selected @endif>';
            html += '{{ $value }}';
            html += '</option>';
          @endforeach
        html += '</select>';
      html += '</td>';
      html += '<td><textarea rows="4" name="action_description">'+description+'</textarea></td>';
      html += '<td><input type="text" class="load_action_estimated_date_input" name="action_start_date" value="'+action_start_date+'"></td>';
      html += '<td><input type="text" class="load_action_estimated_date_input" name="action_end_date" value="'+action_end_date+'"></td>';
      html += '<td>';
        html += '<button type="button" name="action_insert" class="btn btn-success btn-xs action_insert"><span class="glyphicon glyphicon-log-in"></span></button>';
        html += '<button type="button" name="action_insert_cancel" class="btn btn-success btn-xs action_insert_cancel"><span class="glyphicon glyphicon-remove"></span></button>';
      html += '</td>';

      $row.empty();
      $row.append(html);


      // init DateRange picker
      $('.load_action_estimated_date_input').daterangepicker({
        locale: {
        format: 'YYYY-MM-DD'
        },
        showISOWeekNumbers: true,
        showDropdowns: true,
        autoApply: true,
        disabled: true,
        singleDatePicker: true
      });
      $(".load_action_select").select2({
      allowClear: false,
      minimumResultsForSearch: Infinity
      });
    });


    // LOAD ACTIONS

    // LOAD

    // Hide closed
    $('#switch_actions_closed').on('change', function() {
      if ($(this).is(':checked')) {
        hide_closed = true;
      } else {
        hide_closed = false;
      }
      //console.log(hide_closed);
      $("table.actions").each(function (index, value) {
        loadActions($(this).attr('id'));
      });
    });
    // Hide closed

  } );
  </script>
  @stop
