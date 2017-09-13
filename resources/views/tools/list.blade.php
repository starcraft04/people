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
    <h3>Activities</h3>
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
        <h2>Tools</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <br />
          <div class="row">
            <div class="form-group col-xs-2">
              <label for="month" class="control-label">Year</label>
              <select class="form-control select2" style="width: 100%;" id="year" name="year" data-placeholder="Select a year">
                @foreach($authUsersForDataView->year_list as $key => $value)
                <option value="{{ $key }}"
                  @if(isset($authUsersForDataView->year_selected) && $key == $authUsersForDataView->year_selected) selected
                  @endif>
                  {{ $value }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-xs-2">
              <label for="manager" class="control-label">Manager</label>
              <select class="form-control select2" style="width: 100%;" id="manager" name="manager" data-placeholder="Select a manager" multiple="multiple">
                @foreach($authUsersForDataView->manager_list as $key => $value)
                <option value="{{ $key }}"
                  @if(isset($authUsersForDataView->manager_selected) && $key == $authUsersForDataView->manager_selected) selected
                  @endif>
                  {{ $value }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-xs-2">
              <label for="user" class="control-label">User</label>
              <select class="form-control select2" style="width: 100%;" id="user" name="user" data-placeholder="Select a user" multiple="multiple">
                @foreach($authUsersForDataView->user_list as $key => $value)
                <option value="{{ $key }}"
                  @if(isset($authUsersForDataView->user_selected) && $key == $authUsersForDataView->user_selected) selected
                  @endif>
                  {{ $value }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-xs-1">
              <label for="closed" class="control-label">Hide closed</label>
              <input name="closed" type="checkbox" id="closed" class="form-group js-switch" checked /> 
            </div>
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
        <h2>List (activities in days)</small></h2>
        <button id="legendButton" class="btn btn-success btn-sm" style="margin-left: 10px;">legend</button>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
          @permission('tools-activity-new')
          <div class="row button_in_row">
            <div class="col-md-12">
              <button id="new_project" class="btn btn-info btn-xs" align="right"><span class="glyphicon glyphicon-plus"> New Project</span></button>
            </div>
          </div>
          @endpermission

          <table id="activitiesTable" class="table table-striped table-hover table-bordered" width="100%">
              <thead>
                <tr>
                  <th>Manager ID</th>
                  <th>Manager name</th>
                  <th>User ID</th>
                  <th>User name</th>
                  <th>Customer name</th>
                  <th>Project ID</th>
                  <th>Project name</th>
                  <th>Project type</th>
                  <th>Activity type</th>
                  <th>Project status</th>
                  <th>Year</th>
                  <th>Jan</th>
                  <th>OTL</th>
                  <th>Feb</th>
                  <th>OTL</th>
                  <th>Mar</th>
                  <th>OTL</th>
                  <th>Apr</th>
                  <th>OTL</th>
                  <th>May</th>
                  <th>OTL</th>
                  <th>Jun</th>
                  <th>OTL</th>
                  <th>Jul</th>
                  <th>OTL</th>
                  <th>Aug</th>
                  <th>OTL</th>
                  <th>Sep</th>
                  <th>OTL</th>
                  <th>Oct</th>
                  <th>OTL</th>
                  <th>Nov</th>
                  <th>OTL</th>
                  <th>Dec</th>
                  <th>OTL</th>
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
                </tr>
              </tfoot>
            </table>
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

    activitiesTable = $('#activitiesTable').DataTable({
      scrollX: true,
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
        { name: 'manager_id', data: 'manager_id' , searchable: false , visible: false},
        { name: 'manager_name', data: 'manager_name', width: '150px' },
        { name: 'user_id', data: 'user_id' , searchable: false , visible: false},
        { name: 'user_name', data: 'user_name' , width: '150px'},
        { name: 'customer_name', data: 'customer_name' , width: '200px'},
        { name: 'project_id', data: 'project_id' , searchable: false , visible: false},
        { name: 'project_name', data: 'project_name', width: '200px'},
        { name: 'project_type', data: 'project_type', visible: false},
        { name: 'activity_type', data: 'activity_type', visible: false},
        { name: 'project_status', data: 'project_status' , visible: false},
        { name: 'year', data: 'year' , searchable: false , visible: false},
        { name: 'jan_com', data: 'jan_com', width: '30px', searchable: false , className: "jan_com"},
        { name: 'jan_otl', data: 'jan_otl', width: '10px', searchable: false , visible: false},
        { name: 'feb_com', data: 'feb_com', width: '30px', searchable: false , className: "feb_com"},
        { name: 'feb_otl', data: 'feb_otl', width: '10px', searchable: false , visible: false},
        { name: 'mar_com', data: 'mar_com', width: '30px', searchable: false , className: "mar_com"},
        { name: 'mar_otl', data: 'mar_otl', width: '10px', searchable: false , visible: false},
        { name: 'apr_com', data: 'apr_com', width: '30px', searchable: false , className: "apr_com"},
        { name: 'apr_otl', data: 'apr_otl', width: '10px', searchable: false , visible: false},
        { name: 'may_com', data: 'may_com', width: '30px', searchable: false , className: "may_com"},
        { name: 'may_otl', data: 'may_otl', width: '10px', searchable: false , visible: false},
        { name: 'jun_com', data: 'jun_com', width: '30px', searchable: false , className: "jun_com"},
        { name: 'jun_otl', data: 'jun_otl', width: '10px', searchable: false , visible: false},
        { name: 'jul_com', data: 'jul_com', width: '30px', searchable: false , className: "jul_com"},
        { name: 'jul_otl', data: 'jul_otl', width: '10px', searchable: false , visible: false},
        { name: 'aug_com', data: 'aug_com', width: '30px', searchable: false , className: "aug_com"},
        { name: 'aug_otl', data: 'aug_otl', width: '10px', searchable: false , visible: false},
        { name: 'sep_com', data: 'sep_com', width: '30px', searchable: false , className: "sep_com"},
        { name: 'sep_otl', data: 'sep_otl', width: '10px', searchable: false , visible: false},
        { name: 'oct_com', data: 'oct_com', width: '30px', searchable: false , className: "oct_com"},
        { name: 'oct_otl', data: 'oct_otl', width: '10px', searchable: false , visible: false},
        { name: 'nov_com', data: 'nov_com', width: '30px', searchable: false , className: "nov_com"},
        { name: 'nov_otl', data: 'nov_otl', width: '10px', searchable: false , visible: false},
        { name: 'dec_com', data: 'dec_com', width: '30px', searchable: false , className: "dec_com"},
        { name: 'dec_otl', data: 'dec_otl', width: '10px', searchable: false , visible: false}
      ],
      order: [[1, 'asc'],[3, 'asc'],[4, 'asc'],[6, 'asc']],

      lengthMenu: [
          [ 10, 25, 50, -1 ],
          [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      dom: 'Bfrtip',
      buttons: [
        {
          extend: "colvis",
          className: "btn-sm",
          columns: [ 1, 3, 4, 6, 7, 8, 9, 10, 11, 13, 15,17,19,21,23,25,27,29,31,33 ]
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
      },
      rowCallback: function(row, data, index){
        assign_color(row,data.jan_com,data.jan_otl,'jan_com');
        assign_color(row,data.feb_com,data.feb_otl,'feb_com');
        assign_color(row,data.mar_com,data.mar_otl,'mar_com');
        assign_color(row,data.apr_com,data.apr_otl,'apr_com');
        assign_color(row,data.may_com,data.may_otl,'may_com');
        assign_color(row,data.jun_com,data.jun_otl,'jun_com');
        assign_color(row,data.jul_com,data.jul_otl,'jul_com');
        assign_color(row,data.aug_com,data.aug_otl,'aug_com');
        assign_color(row,data.sep_com,data.sep_otl,'sep_com');
        assign_color(row,data.oct_com,data.oct_otl,'oct_com');
        assign_color(row,data.nov_com,data.nov_otl,'nov_com');
        assign_color(row,data.dec_com,data.dec_otl,'dec_com');
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
