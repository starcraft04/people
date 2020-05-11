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
<!-- Prime info -->
<link rel="stylesheet" href="{{ asset('/css/datatables.css') }}">
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
<!-- Some functions made by John -->
<script src="{{ asset('/js/people_general_functions.js') }}" type="text/javascript"></script>
@stop

@section('content')
<!-- Selections -->
  <div class="form-group row">
    <div class="col-xs-2">
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
    <div class="col-xs-2">
      <label for="closed" class="control-label">Hide closed actions</label>
      <input name="closed" type="checkbox" id="switch_actions_closed" class="form-group js-switch-small" checked />
    </div>
  </div>
<!-- Selections -->
<div class="clearfix"></div>

<!-- Window -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <!-- Window content -->
      <div class="x_content">
        <!-- Tab pannels -->
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
          <!-- Tab titles -->
          <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
          <li role="presentation" class="active"> <a href="#tab_content1" id="general-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a>
          </li>
          <li role="presentation" class="">       <a href="#tab_content2" id="delivery-tab" role="tab" data-toggle="tab" aria-expanded="false">Projects <small>Delivery</small></a>
          </li>
          <li role="presentation" class="">       <a href="#tab_content3" id="pipeline-tab" role="tab" data-toggle="tab" aria-expanded="false">Projects <small>Pipeline</small></a>
          </li>
          <li role="presentation" class="">       <a href="#tab_content4" id="presales-tab" role="tab" data-toggle="tab" aria-expanded="false">Projects <small>Pre-sales</small></a>
          </li>
          <li role="presentation" class="">       <a href="#tab_content5" id="orange-tab" role="tab" data-toggle="tab" aria-expanded="false">Projects <small>Orange</small></a>
          </li>
          <li role="presentation" class="">       <a href="#tab_content6" id="closed-tab" role="tab" data-toggle="tab" aria-expanded="false">Projects <small>Closed</small></a>
          </li>
          </ul>
          <!-- Tab titles -->
          <!-- Tab content -->
          <div id="myTabContent" class="tab-content">
            <!-- Tab General -->
            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="general-tab">
              <div class="row">
                <h3>General</h3>
                <h4>Load</h4>
                <table id="loadTable" class="table table-striped table-hover table-bordered" width="100%">
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
              @permission('action-view')
              <div class="row">
                <h4>Actions</h4>
                  <div id="actions_general" class="action">
                    <table id="general" data-project_id="" data-section="general" class="table table-striped table-hover table-bordered action" width="100%">
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
              </div>
              @endpermission
            </div>
            <!-- Tab General -->
            <!-- Tab Delivery -->
            <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="delivery-tab">
              <div class="row">
                <div id="projects_delivery"></div>
              </div>
            </div>
            <!-- Tab Delivery -->
            <!-- Tab Pipeline -->
            <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="pipeline-tab">
              <div class="row">
                <div id="projects_pipeline"></div>
              </div>
            </div>
            <!-- Tab Pipeline -->
            <!-- Tab Pre-sales -->
            <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="presales-tab">
              <div class="row">
                <div id="projects_pre-sales"></div>
              </div>
            </div>
            <!-- Tab Pre-sales -->
            <!-- Tab Orange -->
            <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="orange-tab">
              <div class="row">
                <div id="projects_orange"></div>
              </div>
            </div>
            <!-- Tab Orange -->
            <!-- Tab Closed -->
            <div role="tabpanel" class="tab-pane fade" id="tab_content6" aria-labelledby="closed-tab">
              <div class="row">
                <div id="projects_closed"></div>
              </div>
            </div>
            <!-- Tab Closed -->
          </div>
          <!-- Tab content -->
        </div>
        <!-- Tab pannels -->
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
  var project_months_title = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  var project_months = ['jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec'];
  var user_id = {{ $user_id }};
  var loadActionsTable;
  var hide_closed = true;
  var project_ids = [];

  // Here we are going to get from PHP the list of roles and their value for the logged in customer
  // Roles check
  <?php
          // Permissions for actions
          $options = [
              'validate_all' => true,
              'return_type' => 'both'
          ];
          list($validate, $allValidations) = Entrust::ability(null,['action-create','action-edit','action-delete','action-all','comment-create','comment-edit','comment-delete','comment-all'],$options);
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

    // Then we define what happens when the selection changes

    $('#year').on('change', function() {
      Cookies.set('year', $('#year').val());
      year = [];
      $("#year option:selected").each(function()
      {
        // log the value and text of each option
        year.push($(this).val());
        load();
        loadProjects();
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
        loadProjects();
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
    };

    // LOAD DATA

    // LOAD ACTIONS

    function loadActions() {
      $.ajax({
        url: "{!! route('actionList') !!}",
        type: "POST",
        data: {'user[]': user,'hide_closed':hide_closed},
        dataType: "JSON",
        success:function(data){
          //console.log(data);
          $("table.action").each(function(){
            $(this).find("tbody").empty();
          });
          data.forEach(function (item, index) { 
            var markup = "";
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
            
            if (item['action_section'] != 'project') {
              $("#"+item['action_section']).find("tbody").append(markup);
            } else {
              $("#"+item['action_section']+"_"+item['project_id']).find("tbody").append(markup);
            }
          });
        }
      });
    };

    $(document).on('click', '.new_action', function(){
      var table = $(this).closest('table').attr('id');
      var section = $(this).closest('table').attr('data-section');
      var project_id = $(this).closest('table').attr('data-project_id');
      var project_name = $(this).closest('table').attr('data-project_name');
      var assigned_id = $('#user option:selected').val();
      var assigned_name = $('#user option:selected').text();
      //console.log(project_id);
      $(this).hide();
      var html = '<tr>';
      html += '<td style="{{ $extra_info_display }}"></td>';
      html += '<td name="user_id" style="{{ $extra_info_display }}">{{ $user_id }}</td>';
      html += '<td name="user_name">{{ $user_name }}</td>';
      html += '<td name="assigned_user_id" style="{{ $extra_info_display }}">'+assigned_id+'</td>';
      html += '<td name="assigned_user_name" style="{{ $extra_info_display }}">'+assigned_name+'</td>';
      html += '<td><input type="text" name="action_name"></td>';
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
      var table_id = $(this).closest('table').attr('id');
      button = $('#'+table_id).find('.new_action');
      button.show();
      $("#"+table_id+" > tbody > tr:first-child").remove();
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
      var table_id = $(this).closest('table').attr('id');
      var table_section = $(this).closest('table').attr('data-section');
      var table_project_id = $(this).closest('table').attr('data-project_id');
      var div_id = $(this).closest('div.action').attr('id');

      $.ajax({
        url: "{!! route('actionInsertUpdate') !!}",
        type: "POST",
        data: {'id': id,'user_id': created_user_id,'assigned_user_id': assigned_user_id,'name': name,'section': section,'project_id': project_id,
          'status': status,'severity': severity,'description': description,
          'estimated_start_date': action_start_date,'estimated_end_date': action_end_date},
        dataType: "JSON",
        success:function(data){
          //console.log(data);
          
          button = $('#'+table_id).find('.new_action');
          button.show();
          loadActions();

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
      var table_id = $(this).closest('table').attr('id');
      var table_section = $(this).closest('table').attr('data-section');
      var table_project_id = $(this).closest('table').attr('data-project_id');
      var div_id = $(this).closest('div.action').attr('id');

      $.ajax({
        url: "{!! route('actionDelete') !!}",
        type: "POST",
        data: {'id': id},
        dataType: "JSON",
        success:function(data){
          //console.log(data);
          loadActions();

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
      var table_id = $(this).closest('table').attr('id');
      button = $('#'+table_id).find('.new_action');
      button.hide();

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

    $(document).on('click', '.buttonProjectEdit', function(){
      user_id_edit = user[0];
      year_edit = year[0];
      project_id_edit = $(this).attr('data-project_id');
      window.location.href = "{!! route('toolsFormUpdate',['','','']) !!}/"+user_id_edit+"/"+project_id_edit+"/"+year_edit;
    });

    // LOAD ACTIONS

    // COMMENTS

    function loadComments() {
      $.ajax({
        url: "{!! route('commentList') !!}",
        type: "POST",
        data: {'project_ids[]': project_ids},
        dataType: "JSON",
        success:function(data){
          //console.log(data);
          $("table.comment").each(function(){
            $(this).find("tbody").empty();
          });
          data.forEach(function (item, index) { 
            var markup = "";
            markup += '<tr>';
            markup += '<td name="created">'+item['created_at']+'</td>';
            markup += '<td name="created_by">'+item['user_summary']['name']+'</td>';
            markup += '<td name="comment_id" style="{{ $extra_info_display }}">'+item['id']+'</td>';
            markup += '<td name="user_id" style="{{ $extra_info_display }}">'+item['user_summary']['id']+'</td>';
            markup += '<td name="project_id" style="{{ $extra_info_display }}">'+item['project_id']+'</td>';
            markup += '<td name="comment">'+item['comment']+'</td>';
            markup += '<td>';
            delete_permission = false;
            edit_permission = false;
            if (permissions['comment-delete'] && item['user_id'] == {!! $user_id !!}) {
              delete_permission = true;
            }
            if (permissions['comment-edit'] && item['user_id'] == {!! $user_id !!}) {
              edit_permission = true;
            }
            if (permissions['comment-all']) {
              delete_permission = true;
              edit_permission = true;
            }
            
            if (edit_permission) {
              markup += '<button type="button" class="buttonCommentEdit btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></button>';
            }
            if (delete_permission) {
              markup += '<button type="button" class="buttonCommentDelete btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></button>';
            }
            markup += '</td>';
            markup += '</tr>';
            $("#comments_project_"+item['project_id']).find("tbody").append(markup);
          });
        }
      });
    };

    $(document).on('click', '.new_comment', function(){
      var table = $(this).closest('table').attr('id');
      var project_id = $(this).closest('table').attr('data-project_id');
      //console.log(project_id);
      $(this).hide();
      var today = new Date();
      var dd = String(today.getDate()).padStart(2, '0');
      var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
      var yyyy = today.getFullYear();

      today = yyyy + '-' + mm + '-' + dd;
      var markup = "";
      markup += '<tr>';
      markup += '<td name="created">'+today+'</td>';
      markup += '<td name="created_by">{{ $user_name }}</td>';
      markup += '<td name="comment_id" style="{{ $extra_info_display }}"></td>';
      markup += '<td name="user_id" style="{{ $extra_info_display }}">{{ $user_id }}</td>';
      markup += '<td name="project_id" style="{{ $extra_info_display }}">'+project_id+'</td>';
      markup += '<td><textarea rows="4" name="comment"></textarea></td>';
      markup += '<td>';
      markup += '<button type="button" class="btn btn-success btn-xs comment_insert"><span class="glyphicon glyphicon-log-in"></span></button>';
      markup += '<button type="button" class="btn btn-success btn-xs comment_insert_cancel"><span class="glyphicon glyphicon-remove"></span></button>';
      markup += '</td>';
      markup += '</tr>';
      
      $('#'+table+' tbody').prepend(markup);

    });

    $(document).on('click', '.comment_insert_cancel', function(){
      var table_id = $(this).closest('table').attr('id');
      button = $('#'+table_id).find('.new_comment');
      button.show();
      $("#"+table_id+" > tbody > tr:first-child").remove();
    });

    $(document).on('click', '.comment_update_cancel', function(){
      var table_id = $(this).closest('table').attr('id');
      button = $('#'+table_id).find('.new_comment');
      button.show();
      loadComments();
    });

    $(document).on('click', '.comment_insert', function(){
      var table_id = $(this).closest('table').attr('id');
      var button = $('#'+table_id).find('.new_comment');
      var user_id = {{ $user_id }}
      var $row = $(this).closest("tr");
      var project_id = Number($row.find('td[name="project_id"]').text());
      var comment = $row.find('textarea[name="comment"]').val();

      values = {'id':null,'user_id':user_id,'project_id':project_id,'comment':comment};
      //console.log(values);

      $.ajax({
        url: "{!! route('commentInsert') !!}",
        type: "POST",
        data: values,
        dataType: "JSON",
        success:function(data){
          //console.log(data);
          button.show();
          loadComments();

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

    $(document).on('click', '.comment_update', function(){
      var table_id = $(this).closest('table').attr('id');
      var button = $('#'+table_id).find('.new_comment');

      var $row = $(this).closest("tr");
      var id = $row.find('td[name="comment_id"]').text();
      var comment = $row.find('textarea[name="comment"]').val();

      values = {'comment':comment};
      //console.log(values);

      $.ajax({
        url: "{!! route('comment_edit','') !!}/"+id,
        type: "POST",
        data: values,
        dataType: "JSON",
        success:function(data){
          //console.log(data);
          button.show();
          loadComments();

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

    $(document).on('click', '.buttonCommentDelete', function(){
      var $row = $(this).closest("tr");
      var comment_id = $row.find('td[name="comment_id"]').text();
      var table = $(this).closest('table').attr('id');

      $.ajax({
        url: "{!! route('comment_delete','') !!}/"+comment_id,
        type: "GET",
        dataType: "JSON",
        success:function(data){
          //console.log(data);
          loadComments();

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

    $(document).on('click', '.buttonCommentEdit', function(){
      var table_id = $(this).closest('table').attr('id');
      button = $('#'+table_id).find('.new_comment');
      button.hide();

      var $row = $(this).closest("tr");
      var id = $row.find('td[name="comment_id"]').text();
      var created_at = $row.find('td[name="created"]').text();
      var created_by = $row.find('td[name="created_by"]').text();
      var comment_user_id = $row.find('td[name="user_id"]').text();
      var project_id = $row.find('td[name="project_id"]').text();
      var comment = $row.find('td[name="comment"]').text();
      

      var markup = "";
      markup += '<td name="created">'+created_at+'</td>';
      markup += '<td name="created_by">'+created_by+'</td>';
      markup += '<td name="comment_id" style="{{ $extra_info_display }}">'+id+'</td>';
      markup += '<td name="user_id" style="{{ $extra_info_display }}">'+comment_user_id+'</td>';
      markup += '<td name="project_id" style="{{ $extra_info_display }}">'+project_id+'</td>';
      markup += '<td><textarea rows="4" name="comment">'+comment+'</textarea></td>';
      markup += '<td>';
      markup += '<button type="button" class="btn btn-success btn-xs comment_update"><span class="glyphicon glyphicon-log-in"></span></button>';
      markup += '<button type="button" class="btn btn-success btn-xs comment_update_cancel"><span class="glyphicon glyphicon-remove"></span></button>';
      markup += '</td>';

      $row.empty();
      $row.append(markup);
    });

    // COMMENTS

    // LOAD

    // Hide closed
    $('#switch_actions_closed').on('change', function() {
      if ($(this).is(':checked')) {
        hide_closed = true;
      } else {
        hide_closed = false;
      }
      //console.log(hide_closed);
      loadProjects();
    });

    // Hide closed
    

    // LOAD PROJECTS
    // DELIVERY

    function loadProjects() {
      $.ajax({
        url: "{!! route('userSummaryProjects') !!}",
        type: "POST",
        data: {'year[]': year,'user[]': user,'no_datatables': true},
        dataType: "JSON",
        success:function(data){
          //console.log(data);
          $("#projects_delivery").empty();
          $("#projects_pipeline").empty();
          $("#projects_pre-sales").empty();
          
          data.forEach(function (item, index) { 
            project_ids.push(item['project_id']);
            var markup = '';
            markup += '<div class="row">';
              markup += '<div class="col-xs-12">';
              markup += '<h3>';
              markup += '<button type="button" data-project_id="'+item['project_id']+'" class="buttonProjectEdit btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></button>';
              markup += item['customer_name']+' / <small>'+item['project_name']+'</small>';
              markup += '</h3></div>';
            markup += '</div>';

            if ((item['project_type'] == 'Project' || item['project_type'] == 'Baseline')) {
              markup += '<div class="row">';
                markup += '<div class="col-xs-4">';
                markup += 'GO: '+print_null(item['gold_order_number']);
                markup += '</div>';
              markup += '</div>';
            } else if (item['project_type'] == 'Pre-sales') {
              markup += '<div class="row">';
                markup += '<div class="col-xs-4">';
                  markup += 'CL ID: '+print_null(item['samba_id']);
                markup += '</div>';
                markup += '<div class="col-xs-4">';
                  markup += 'Owner: '+print_null(item['samba_opportunit_owner']);
                markup += '</div>';
                markup += '<div class="col-xs-4">';
                if (item['samba_stage'] == 'Closed Lost') {
                  markup += 'Stage: <button type="button" class="btn btn-round btn-danger btn-xs">'+print_null(item['samba_stage'])+'</button>';
                } else if (item['samba_stage'] == 'Closed Won') {
                  markup += 'Stage: <button type="button" class="btn btn-round btn-success btn-xs">'+print_null(item['samba_stage'])+'</button>';
                } else if (item['samba_stage'] == null) {
                  markup += 'Stage: '+print_null(item['samba_stage']);
                } else {
                  markup += 'Stage: <button type="button" class="btn btn-round btn-default btn-xs">'+print_null(item['samba_stage'])+'</button>';
                }
                markup += '</div>';
              markup += '</div>';
              markup += '<div class="row">';
                markup += '<div class="col-xs-4">';
                  markup += 'Order intake: '+toCurrency(item['project_revenue']);
                markup += '</div>';
                markup += '<div class="col-xs-4">';
                  markup += 'Cons. rev.: '+toCurrency(item['samba_consulting_product_tcv']);
                markup += '</div>';
                markup += '<div class="col-xs-4">';
                  markup += 'PullThru rev.: '+toCurrency(item['samba_pullthru_tcv']);
                markup += '</div>';
              markup += '</div>';
            }
            
            markup += '<div class="row">';
            markup += '<table class="table table-striped table-hover table-bordered work" width="100%">';
            markup += '<thead>';
              markup += '<th></th>';
              markup += '<th></th>';
              project_months_title.forEach(function (month, index) 
                { 
                  markup += '<th>'+month+'</th>';
                });
            markup += '</thead>';
            markup += '<tbody>';
              // Working days
              markup += '<tr>';
              markup += '<td>Working days</td>';
              markup += '<td></td>';
              project_months.forEach(function (month, index) 
                { 
                  if (item[month+'_from_otl'] == 1) {
                    markup += '<td class = "otl">'+item[month+'_otl']+'</td>';
                  } else {
                    markup += '<td class = "forecast">'+item[month+'_user']+'</td>';
                  }
                });
              markup += '</tr>';

              // Revenue forecast
              if ((item['project_type'] == 'Project' || item['project_type'] == 'Baseline')) {
                if (item['revenue_forecast'].length > 0) {
                  
                  item['revenue_forecast'].forEach(function (rev, index) 
                  { 
                    markup += '<tr>';
                    markup += '<td>Revenue</td>';
                    markup += '<td>'+rev['product_code']+'</td>';
                    project_months.forEach(function (month, index) 
                      { 
                        markup += '<td>'+toCurrency(rev[month])+'</td>';
                      });
                    markup += '</tr>';
                  });
                } else {
                  markup += '<tr>';
                    markup += '<td>Revenue</td>';
                    markup += '<td></td>';
                    project_months.forEach(function (month, index) 
                      { 
                        markup += '<td></td>';
                      });
                    markup += '</tr>';
                }
              }
            markup += '</tbody>';
            markup += '</table>';
            markup += '</div>';

            // Comments
            @permission('tools-projects-comments')
            markup += '<div class="row">';
            markup += '<h4>Comments</h4>';
            markup += '<div id="comments_project_'+item['project_id']+'" data-project_id="'+item['project_id']+'" class="comment">';
            markup += '<table id="comments_project_'+item['project_id']+'" data-project_id="'+item['project_id']+'" class="table table-striped table-hover table-bordered comment" width="100%">';
            markup += '<thead>';
            markup += '<tr>';
            markup += '<th>Created</th>';
            markup += '<th>Created by</th>';
            markup += '<th style="{{ $extra_info_display }}">Comment ID</th>';
            markup += '<th style="{{ $extra_info_display }}">User ID</th>';
            markup += '<th style="{{ $extra_info_display }}">Project ID</th>';
            markup += '<th>Comment</th>';
            markup += '<th>';
            @permission('comment-create')
              markup += '<button type="button" class="btn btn-info btn-xs new_comment"><span class="glyphicon glyphicon-plus"></span></button>';
            @endpermission
            markup += '</th>';
            markup += '</tr>';
            markup += '</thead>';
            markup += '<tbody>';
            markup += '</tbody>';
            markup += '</table>';
            markup += '</div>';
            markup += '</div>';
            @endpermission
            // Comments

            // Actions
            @permission('action-view')
            markup += '<div class="row">';
            markup += '<h4>Actions</h4>';
            markup += '<div id="actions_project_'+item['project_id']+'" data-project_id="'+item['project_id']+'" class="action">';
            markup += '<table id="project_'+item['project_id']+'" data-project_id="'+item['project_id']+'" data-section="project" class="table table-striped table-hover table-bordered action" width="100%">';
            markup += '<thead>';
            markup += '<tr>';
            markup += '<th style="{{ $extra_info_display }}">Action ID</th>';
            markup += '<th style="{{ $extra_info_display }}">Created by ID</th>';
            markup += '<th>Created by</th>';
            markup += '<th style="{{ $extra_info_display }}">Assigned to ID</th>';
            markup += '<th style="{{ $extra_info_display }}">Assigned to</th>';
            markup += '<th>Name</th>';
            markup += '<th style="{{ $extra_info_display }}">Section</th>';
            markup += '<th style="{{ $extra_info_display }}">Project ID</th>';
            markup += '<th style="{{ $extra_info_display }}">Project Name</th>';
            markup += '<th>Status</th>';
            markup += '<th>Severity</th>';
            markup += '<th>Description</th>';
            markup += '<th>Start</th>';
            markup += '<th>End</th>';
            markup += '<th>';
            @permission('action-create')
              markup += '<button type="button" class="btn btn-info btn-xs new_action"><span class="glyphicon glyphicon-plus"></span></button>';
            @endpermission
            markup += '</th>';
            markup += '</tr>';
            markup += '</thead>';
            markup += '<tbody>';
            markup += '</tbody>';
            markup += '</table>';
            markup += '</div>';
            markup += '</div>';
            @endpermission
            // Actions

            markup += '<hr>';
            if (item['project_status'] == 'Closed') {
              $("#projects_closed").append(markup);
            } else if (item['customer_name'] == 'Orange Business Services') {
              $("#projects_orange").append(markup);
            } else if ((item['project_type'] == 'Project' || item['project_type'] == 'Baseline') && item['project_status'] == 'Started') {
              $("#projects_delivery").append(markup);
            } else if ((item['project_type'] == 'Project' || item['project_type'] == 'Baseline') && item['project_status'] == 'Pipeline') {
              $("#projects_pipeline").append(markup);
            }  else if (item['project_type'] == 'Pre-sales') {
              $("#projects_pre-sales").append(markup);
            }
          });
          //console.log(project_ids);
          @permission('tools-projects-comments')
            loadComments();
          @endpermission
          @permission('action-view')
            loadActions();
          @endpermission
        }
      });
    };

    // DELIVERY

    // LOAD PROJECTS

    // INIT
    load();
    loadProjects();
    // INIT

  } );
  </script>
  @stop
