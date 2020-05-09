@extends('layouts.app')

@section('style')
    <!-- CSS -->
    <!-- DataTables -->
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('/css/datatables.css') }}">
    <!-- Select2 -->
    <link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Switchery -->
    <link href="{{ asset('/plugins/gentelella/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
@stop

@section('scriptsrc')
    <!-- JS -->
    <!-- DataTables -->
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/buttons.colVis.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/jszip/dist/jszip.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/pdfmake/build/pdfmake.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/pdfmake/build/vfs_fonts.js') }}" type="text/javascript"></script>
    <!-- Select2 -->
    <script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
    <!-- Bootbox -->
    <script src="{{ asset('/plugins/bootbox/bootbox.min.js') }}"></script>
    <!-- Switchery -->
    <script src="{{ asset('/plugins/gentelella/vendors/switchery/dist/switchery.min.js') }}" type="text/javascript"></script>
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Activities <small>(in days)</small></h3><button id="legendButton" class="btn btn-success btn-sm">legend</button>
  </div>
</div>
<div class="clearfix"></div>
<!-- Page title -->

<!-- Window -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window content -->
      <div class="x_content">

        <!-- Selections for the table -->

        <div class="form-group row">
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
            <label for="manager" class="control-label">Manager</label>
            <select class="form-control select2" id="manager" name="manager" data-placeholder="Select a manager" multiple="multiple">
              @foreach($authUsersForDataView->manager_list as $key => $value)
              <option value="{{ $key }}"
                @if(isset($authUsersForDataView->manager_selected) && $key == $authUsersForDataView->manager_selected) selected
                @endif>
                {{ $value }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-xs-3">
            <label for="user" class="control-label">User</label>
            <select class="form-control select2" id="user" name="user" data-placeholder="Select a user" multiple="multiple">
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
            <label for="closed" class="control-label">Hide closed</label>
            <input name="closed" type="checkbox" id="closed" class="form-group js-switch-small" checked /> 
          </div>
        </div>

        <!-- Selections for the table -->

        <!-- Create new button -->
        @permission('tools-activity-new')
        <div class="row button_in_row">
          <div class="col-md-12">
            <button id="new_project" class="btn btn-info btn-xs" align="right"><span class="glyphicon glyphicon-plus"> New Project</span></button>
          </div>
        </div>
        @endpermission
        <!-- Create new button -->

        <!-- Main table -->
        <table id="activitiesTable" class="table table-striped table-hover table-bordered mytable" width="100%">
          <thead>
            <tr>
              <th>Manager ID</th>
              <th>Manager name</th>
              <th>User ID</th>
              <th>User name</th>
              <th>User domain</th>
              <th>User country</th>
              <th>Employee type</th>
              <th>Customer name</th>
              <th>Customer cluster</th>
              <th>Customer country</th>
              <th>Project ID</th>
              <th>Project name</th>
              <th>Project type</th>
              <th>Activity type</th>
              <th>Project status</th>
              <th>Prime code</th>
              <th>Meta activity</th>
              <th>Project subtype</th>
              <th>Technology</th>
              <th>CL ID</th>
              <th>Pullthru CL ID</th>
              <th>Order intake inc. CS</th>
              <th>Consulting TCV</th>
              <th>Pullthru TCV</th>
              <th>CL Owner</th>
              <th>CL lead domain</th>
              <th>CL stage</th>
              <th>Start date</th>
              <th>End date</th>
              <th>Gold order</th>
              <th>Win ratio (%)</th>
              <th>Year</th>
              <th>Jan</th>
              <th>Jan user</th>
              <th>Jan otl</th>
              <th>Feb</th>
              <th>Feb user</th>
              <th>Feb otl</th>
              <th>Mar</th>
              <th>Mar user</th>
              <th>Mar otl</th>
              <th>Apr</th>
              <th>Apr user</th>
              <th>Apr otl</th>
              <th>May</th>
              <th>May user</th>
              <th>May otl</th>
              <th>Jun</th>
              <th>Jun user</th>
              <th>Jun otl</th>
              <th>Jul</th>
              <th>Jul user</th>
              <th>Jul otl</th>
              <th>Aug</th>
              <th>Aug user</th>
              <th>Aug otl</th>
              <th>Sep</th>
              <th>Sep user</th>
              <th>Sep otl</th>
              <th>Oct</th>
              <th>Oct user</th>
              <th>Oct otl</th>
              <th>Nov</th>
              <th>Nov user</th>
              <th>Nov otl</th>
              <th>Dec</th>
              <th>Dec user</th>
              <th>Dec otl</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
            </tr>
          </tfoot>
        </table>
        <!-- Main table -->

      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->

<!-- Modal -->
<div class="modal fade" id="legendModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
              <button type="button" class="close" 
                  data-dismiss="modal">
                      <span aria-hidden="true">&times;</span>
                      <span class="sr-only">Close</span>
              </button>
              <h4 class="modal-title" id="myModalLabel">
                  Legend
              </h4>
          </div>
            
          <!-- Modal Body -->
          <div class="modal-body">
              
                <table class="table borderless">
                  <thead>
                    <th>Color</th><th>Meaning</th>
                  </thead>
                  <tbody>
                    <tr><td style="color: green;">Green</td><td>Validated by OTL</td></tr>
                    <tr><td style="color: blue;">Blue</td><td>Forecast entered by consultant</td></tr>
                  </tbody>
                </table>
              
          </div>
            
          <!-- Modal Footer -->
          <div class="modal-footer">
              <button type="button" class="btn btn-default"
                      data-dismiss="modal">
                          Close
              </button>
          </div>
        </div>
    </div>
</div>
<!-- Modal -->

  @stop

  @section('script')
  <script>
  var activitiesTable;
  var year = [];
  var manager = [];
  var user = [];
  var checkbox_closed = 1;
  var month_col = [];

  // switchery
  var small = document.querySelector('.js-switch-small');
  var switchery = new Switchery(small, { size: 'small' });

  function ajaxData(){
    var obj = {
      'year[]': year,
      'manager[]': manager,
      'user[]': user,
      'checkbox_closed':checkbox_closed
    };
    return obj;
  }

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

  //Assign color
  function assign_color(row,value,otl,month){
    if(value <= 0){
      $(row).find('td.'+month).addClass('zero');
    }
    else if(otl > 0){
      $(row).find('td.'+month).addClass('otl');
    }
    else {
      $(row).find('td.'+month).addClass('forecast');
    }
  }

  $(document).ready(function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // SELECTIONS START
    // ________________
    // First we define the select2 boxes

    //Init select2 boxes
    $("#year").select2({
      allowClear: false,
      disabled: {{ $authUsersForDataView->year_select_disabled }}
    });
    //Init select2 boxes
    $("#manager").select2({
      allowClear: false,
      disabled: {{ $authUsersForDataView->manager_select_disabled }}
    });
    //Init select2 boxes
    $("#user").select2({
      allowClear: false,
      disabled: {{ $authUsersForDataView->user_select_disabled }}
    });

    // Then we need to get back the information from the cookie

    year = fill_select('year');
    manager = fill_select('manager');
    user = fill_select('user');
    if (Cookies.get('checkbox_closed') != null) {
      if (Cookies.get('checkbox_closed') == 0) {
        checkbox_closed = 0;
        $('#closed').click();
      } else {
        checkbox_closed = 1;
      }
    }

    //alert($.fn.dataTable.version);

    // Then we define what happens when the selection changes

    $('#year').on('change', function() {
      Cookies.set('year', $('#year').val());
      year = [];
      $("#year option:selected").each(function()
      {
        // log the value and text of each option
        year.push($(this).val());

      });
      activitiesTable.ajax.reload();
    });

    $('#manager').on('change', function() {
      Cookies.set('manager', $('#manager').val());
      manager = [];
      $("#manager option:selected").each(function()
      {
        // log the value and text of each option
        manager.push($(this).val());

      });
      activitiesTable.ajax.reload();
    });

    $('#user').on('change', function() {
      Cookies.set('user', $('#user').val());
      user = [];
      $("#user option:selected").each(function()
      {
        // log the value and text of each option
        user.push($(this).val());

      });
      activitiesTable.ajax.reload();
    });

    $('#closed').on('change', function() {
      if ($(this).is(':checked')) {
        Cookies.set('checkbox_closed', 1);
        checkbox_closed = 1;
      } else {
        Cookies.set('checkbox_closed', 0);
        checkbox_closed = 0;
      }
      //console.log(checkbox_closed);
      activitiesTable.ajax.reload();
    });

    // SELECTIONS END

    month_col = [32,35,38,41,44,47,50,53,56,59,62,65];
  

    activitiesTable = $('#activitiesTable').DataTable({
      scrollX: true,
      @if(isset($table_height))
      scrollY: '{!! $table_height !!}vh',
      scrollCollapse: true,
      @endif
      serverSide: true,
      processing: true,
      stateSave: true,
      ajax: {
        url: "{!! route('listOfActivitiesPerUserAjax') !!}",
        type: "POST",
        data: function ( d ) {
          $.extend(d,ajaxData());
        },
        dataType: "JSON"
      },
      columns: [
        { name: 'uu.manager_id', data: 'manager_id' , searchable: false , visible: false},
        { name: 'm.name', data: 'manager_name' , className: "dt-nowrap", visible: false},
        { name: 'activities.user_id', data: 'user_id' , searchable: false , visible: false},
        { name: 'u.name', data: 'user_name' , className: "dt-nowrap"},
        { name: 'u.domain', data: 'user_domain' , searchable: true, visible: false, className: "dt-nowrap"},
        { name: 'u.country', data: 'user_country' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'u.employee_type', data: 'user_employee_type' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'c.name', data: 'customer_name' , className: "dt-nowrap"},
        { name: 'c.cluster_owner', data: 'customer_cluster_owner' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'c.country_owner', data: 'customer_country_owner' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'activities.project_id', data: 'project_id' , searchable: false , visible: false},
        { name: 'p.project_name', data: 'project_name', className: "dt-nowrap"},
        { name: 'p.project_type', data: 'project_type', visible: true, className: "dt-nowrap"},
        { name: 'p.activity_type', data: 'activity_type', visible: false, className: "dt-nowrap"},
        { name: 'p.project_status', data: 'project_status' , visible: true, className: "dt-nowrap"},
        { name: 'p.otl_project_code', data: 'otl_project_code' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'p.meta_activity', data: 'meta_activity' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'p.project_subtype', data: 'project_subtype' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'p.technology', data: 'technology' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'p.samba_id', data: 'samba_id' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'p.pullthru_samba_id', data: 'pullthru_samba_id' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'p.revenue', data: 'project_revenue' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'p.samba_consulting_product_tcv', data: 'samba_consulting_product_tcv' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'p.samba_pullthru_tcv', data: 'samba_pullthru_tcv' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'p.samba_opportunit_owner', data: 'samba_opportunit_owner' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'p.samba_lead_domain', data: 'samba_lead_domain' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'p.samba_stage', data: 'samba_stage' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'p.estimated_start_date', data: 'estimated_start_date' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'p.estimated_end_date', data: 'estimated_end_date' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'p.gold_order_number', data: 'gold_order_number' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'p.win_ratio', data: 'win_ratio' , searchable: true , visible: false, className: "dt-nowrap"},
        { name: 'activities.year', data: 'year' , searchable: false , visible: false, className: "dt-nowrap"},
        { data: function ( row, type, val, meta ) {
          if (row.jan_otl != null){return row.jan_otl;}else if(row.jan_user != null){return row.jan_user;}else{return 0;}
            }, 
          createdCell: function (td, cellData, rowData, row, col) {
            if (cellData == 0) {
              $(td).addClass("zero");
            } else if(rowData.jan_otl != null){
              $(td).addClass("otl");
            } else {
              $(td).addClass("forecast");
            }
          }, width: '30px', searchable: false},
        { name: 'jan_user', data: 'jan_user', width: '30px', searchable: false , visible: false},
        { name: 'jan_otl', data: 'jan_otl', width: '10px', searchable: false , visible: false},
        { data: function ( row, type, val, meta ) {
          if (row.feb_otl != null){return row.feb_otl;}else if(row.feb_user != null){return row.feb_user;}else{return 0;}
            }, 
          createdCell: function (td, cellData, rowData, row, col) {
            if (cellData == 0) {
              $(td).addClass("zero");
            } else if(rowData.feb_otl != null){
              $(td).addClass("otl");
            } else {
              $(td).addClass("forecast");
            }
          }, width: '30px', searchable: false},
        { name: 'feb_user', data: 'feb_user', width: '30px', searchable: false , visible: false},
        { name: 'feb_otl', data: 'feb_otl', width: '10px', searchable: false , visible: false},
        { data: function ( row, type, val, meta ) {
          if (row.mar_otl != null){return row.mar_otl;}else if(row.mar_user != null){return row.mar_user;}else{return 0;}
            }, 
          createdCell: function (td, cellData, rowData, row, col) {
            if (cellData == 0) {
              $(td).addClass("zero");
            } else if(rowData.mar_otl != null){
              $(td).addClass("otl");
            } else {
              $(td).addClass("forecast");
            }
          }, width: '30px', searchable: false},
        { name: 'mar_user', data: 'mar_user', width: '30px', searchable: false , visible: false},
        { name: 'mar_otl', data: 'mar_otl', width: '10px', searchable: false , visible: false},
        { data: function ( row, type, val, meta ) {
          if (row.apr_otl != null){return row.apr_otl;}else if(row.apr_user != null){return row.apr_user;}else{return 0;}
            }, 
          createdCell: function (td, cellData, rowData, row, col) {
            if (cellData == 0) {
              $(td).addClass("zero");
            } else if(rowData.apr_otl != null){
              $(td).addClass("otl");
            } else {
              $(td).addClass("forecast");
            }
          }, width: '30px', searchable: false},
        { name: 'apr_user', data: 'apr_user', width: '30px', searchable: false , visible: false},
        { name: 'apr_otl', data: 'apr_otl', width: '10px', searchable: false , visible: false},
        { data: function ( row, type, val, meta ) {
          if (row.may_otl != null){return row.may_otl;}else if(row.may_user != null){return row.may_user;}else{return 0;}
            }, 
          createdCell: function (td, cellData, rowData, row, col) {
            if (cellData == 0) {
              $(td).addClass("zero");
            } else if(rowData.may_otl != null){
              $(td).addClass("otl");
            } else {
              $(td).addClass("forecast");
            }
          }, width: '30px', searchable: false},
        { name: 'may_user', data: 'may_user', width: '30px', searchable: false , visible: false},
        { name: 'may_otl', data: 'may_otl', width: '10px', searchable: false , visible: false},
        { data: function ( row, type, val, meta ) {
          if (row.jun_otl != null){return row.jun_otl;}else if(row.jun_user != null){return row.jun_user;}else{return 0;}
            }, 
          createdCell: function (td, cellData, rowData, row, col) {
            if (cellData == 0) {
              $(td).addClass("zero");
            } else if(rowData.jun_otl != null){
              $(td).addClass("otl");
            } else {
              $(td).addClass("forecast");
            }
          }, width: '30px', searchable: false},
        { name: 'jun_user', data: 'jun_user', width: '30px', searchable: false , visible: false},
        { name: 'jun_otl', data: 'jun_otl', width: '10px', searchable: false , visible: false},
        { data: function ( row, type, val, meta ) {
          if (row.jul_otl != null){return row.jul_otl;}else if(row.jul_user != null){return row.jul_user;}else{return 0;}
          }, 
          createdCell: function (td, cellData, rowData, row, col) {
            if (cellData == 0) {
              $(td).addClass("zero");
            } else if(rowData.jul_otl != null){
              $(td).addClass("otl");
            } else {
              $(td).addClass("forecast");
            }
          },
          width: '30px', searchable: false}, 
        { name: 'jul_user', data: 'jul_user', width: '30px', searchable: false , visible: false},
        { name: 'jul_otl', data: 'jul_otl', width: '10px', searchable: false , visible: false},
        { data: function ( row, type, val, meta ) {
          if (row.aug_otl != null){return row.aug_otl;}else if(row.aug_user != null){return row.aug_user;}else{return 0;}
            }, 
          createdCell: function (td, cellData, rowData, row, col) {
            if (cellData == 0) {
              $(td).addClass("zero");
            } else if(rowData.aug_otl != null){
              $(td).addClass("otl");
            } else {
              $(td).addClass("forecast");
            }
          }, width: '30px', searchable: false},
        { name: 'aug_user', data: 'aug_user', width: '30px', searchable: false , visible: false},
        { name: 'aug_otl', data: 'aug_otl', width: '10px', searchable: false , visible: false},
        { data: function ( row, type, val, meta ) {
          if (row.sep_otl != null){return row.sep_otl;}else if(row.sep_user != null){return row.sep_user;}else{return 0;}
            }, 
          createdCell: function (td, cellData, rowData, row, col) {
            if (cellData == 0) {
              $(td).addClass("zero");
            } else if(rowData.sep_otl != null){
              $(td).addClass("otl");
            } else {
              $(td).addClass("forecast");
            }
          }, width: '30px', searchable: false},
        { name: 'sep_user', data: 'sep_user', width: '30px', searchable: false , visible: false},
        { name: 'sep_otl', data: 'sep_otl', width: '10px', searchable: false , visible: false},
        { data: function ( row, type, val, meta ) {
          if (row.oct_otl != null){return row.oct_otl;}else if(row.oct_user != null){return row.oct_user;}else{return 0;}
            }, 
          createdCell: function (td, cellData, rowData, row, col) {
            if (cellData == 0) {
              $(td).addClass("zero");
            } else if(rowData.oct_otl != null){
              $(td).addClass("otl");
            } else {
              $(td).addClass("forecast");
            }
          }, width: '30px', searchable: false},
        { name: 'oct_user', data: 'oct_user', width: '30px', searchable: false , visible: false},
        { name: 'oct_otl', data: 'oct_otl', width: '10px', searchable: false , visible: false},
        { data: function ( row, type, val, meta ) {
          if (row.nov_otl != null){return row.nov_otl;}else if(row.nov_user != null){return row.nov_user;}else{return 0;}
            }, 
          createdCell: function (td, cellData, rowData, row, col) {
            if (cellData == 0) {
              $(td).addClass("zero");
            } else if(rowData.nov_otl != null){
              $(td).addClass("otl");
            } else {
              $(td).addClass("forecast");
            }
          }, width: '30px', searchable: false},
        { name: 'nov_user', data: 'nov_user', width: '30px', searchable: false , visible: false},
        { name: 'nov_otl', data: 'nov_otl', width: '10px', searchable: false , visible: false},
        { data: function ( row, type, val, meta ) {
          if (row.dec_otl != null){return row.dec_otl;}else if(row.dec_user != null){return row.dec_user;}else{return 0;}
            }, 
          createdCell: function (td, cellData, rowData, row, col) {
            if (cellData == 0) {
              $(td).addClass("zero");
            } else if(rowData.dec_otl != null){
              $(td).addClass("otl");
            } else {
              $(td).addClass("forecast");
            }
          }, width: '30px', searchable: false},
        { name: 'dec_user', data: 'dec_user', width: '30px', searchable: false , visible: false},
        { name: 'dec_otl', data: 'dec_otl', width: '10px', searchable: false , visible: false},
      ],
      order: [[1, 'asc'],[3, 'asc'],[7, 'asc'],[12, 'asc']],

      lengthMenu: [
          [ 10, 25, 50, -1 ],
          [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      dom: 'Bfrtip',
      buttons: [
        {
          extend: "colvis",
          className: "btn-sm",
          collectionLayout: "three-column",
          columns: [  ]
        },
        {
          extend: "pageLength",
          className: "btn-sm"
        },
        {
          extend: "csv",
          className: "btn-sm",
          exportOptions: {
              columns: ':visible'
          }
        },
        {
          extend: "excel",
          className: "btn-sm",
          exportOptions: {
              columns: ':visible'
          }
        },
        {
          extend: "print",
          className: "btn-sm",
          exportOptions: {
              columns: ':visible'
          }
        },
      ],
      footerCallback: function ( row, data, start, end, display ) {
        var api = this.api(), data;

        $.each(month_col, function( index, value ) {
          // Total over this page
          pageTotal = api
            .column( value, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
              return parseFloat(a)+parseFloat(b);
            }, 0 );

          // Update footer
          $( api.column( value ).footer() ).html(
              '<div style="font-size: 120%;">'+pageTotal.toFixed(1)+'</div>'
          );
        });
      },
      initComplete: function () {
        var columns = this.api().init().columns;
        this.api().columns().every(function () {
          var column = this;
          // this will get us the index of the column
          index = column[0][0];
          //console.log(columns[index].searchable);

          // Now we need to skip the column if it is not searchable and we return true, meaning we go to next iteration
          if (columns[index].searchable == false) {
            return true;
          }
          else {
            var input = document.createElement("input");
            $(input).appendTo($(column.footer()).empty())
            .on('keyup change', function () {
              column.search($(this).val(), false, false, true).draw();
            });
          };
        });
        // Restore state
        var state = activitiesTable.state.loaded();
        if (state) {
            activitiesTable.columns().eq(0).each(function (colIdx) {
                var colSearch = state.columns[colIdx].search;

                if (colSearch.search) {
                    $('input', activitiesTable.column(colIdx).footer()).val(colSearch.search);
                }
            });

            activitiesTable.draw();
        }
      }
    });

    @permission('tools-activity-edit')
    $('#activitiesTable').on('click', 'tbody td', function() {
      var table = activitiesTable;
      var tr = $(this).closest('tr');
      var row = table.row(tr);
      //get the initialization options
      var columns = table.settings().init().columns;
      //get the index of the clicked cell
      var colIndex = table.cell(this).index().column;
      //console.log('you clicked on the column with the name '+columns[colIndex].name);
      //console.log('the user id is '+row.data().user_id);
      //console.log('the project id is '+row.data().project_id);
      // If we click on the name, then we create a new project
      year = [];
      $("#year option:selected").each(function()
      {
        // log the value and text of each option
        year.push($(this).val());
      });
      window.location.href = "{!! route('toolsFormUpdate',['','','']) !!}/"+row.data().user_id+"/"+row.data().project_id+"/"+year[0];
    });
    @endpermission

    @permission('tools-activity-new')
    $('#new_project').on('click', function() {
      window.location.href = "{!! route('toolsFormCreate',['']) !!}/"+year[0];
    });
    @endpermission

    $(document).on('click', '#legendButton', function () {
    $('#legendModal').modal();
  });

  } );
  </script>
  @stop
