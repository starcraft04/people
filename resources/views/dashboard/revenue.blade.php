@extends('layouts.app')

@section('style')
    <!-- CSS -->
    <!-- Select2 -->
    <link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('/css/datatables.css') }}">

@stop

@section('scriptsrc')
    <!-- JS -->
    <!-- Select2 -->
    <script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
    <!-- Bootbox -->
    <script src="{{ asset('/plugins/bootbox/bootbox.min.js') }}"></script>
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
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Revenue dashboard</h3>
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
        <h2>Tools</h2>
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
              <label for="year" class="control-label">Year</label>
              <select class="form-control select2" style="width: 100%;" id="year" name="year" data-placeholder="Select a year">
                @foreach($authUsersForDataView->year_list as $key => $value)
                <option value="{{ $key }}"
                  @if($key == $year) selected
                  @endif>
                  {{ $value }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-xs-2">
              <label for="manager" class="control-label">Manager</label>
              <select class="form-control select2" style="width: 100%;" id="manager" name="manager" data-placeholder="Select a manager">
                @foreach($authUsersForDataView->manager_list as $key => $value)
                <option value="{{ $key }}"
                  @if($key == $user_id) selected
                  @endif>
                  {{ $value }}
                </option>
                @endforeach
              </select>
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

      <!-- Window content -->
      <div class="x_content">
        <div class="row">
          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <!-- Tab titles -->
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
              <li role="presentation" class="active"><a href="#tab_content1" id="revenue-tab" role="tab" data-toggle="tab" aria-expanded="true">Revenue(€)</a>
              </li>
              <li role="presentation" class=""><a href="#tab_content2" id="missingRevenue-tab" role="tab" data-toggle="tab" aria-expanded="true">Projects missing revenue</a>
              </li>
            </ul>
            <!-- Tab titles -->

            <!-- Tab content -->
            <div id="myTabContent" class="tab-content">
              <!-- Tab Revenue -->
              <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="revenue-tab">
                <table id="revenueTable" class="table table-striped table-hover table-bordered" width="100%">
                  <thead>
                    <tr>
                      <th>Cluster</th>
                      <th>Customer</th>
                      <th>Project ID</th>
                      <th>Project name</th>
                      <th>Project type</th>
                      <th>Project subtype</th>
                      <th>Project status</th>
                      <th>Gold Order</th>
                      <th>Samba ID</th>
                      <th>User ID</th>
                      <th>User name</th>
                      <th>FPC</th>
                      <th>Win ratio (%)</th>
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
                  @foreach($all_revenues as $key => $revenue)
                    <tr>
                      <td>{!! $revenue->cluster_owner !!}</td>
                      <td>{!! $revenue->customer_name !!}</td>
                      <td>{!! $revenue->project_id !!}</td>
                      <td>{!! $revenue->project_name !!}</td>
                      <td>{!! $revenue->project_type !!}</td>
                      <td>{!! $revenue->project_subtype !!}</td>
                      <td>{!! $revenue->project_status !!}</td>
                      <td>{!! $revenue->gold_order !!}</td>
                      <td>{!! $revenue->samba_id !!}</td>
                      <td>{!! $revenue->user_id !!}</td>
                      <td>{!! $revenue->user_name !!}</td>
                      <td>{!! $revenue->product_code !!}</td>
                      <td>{!! $revenue->win_ratio !!}</td>
                      <td>{!! number_format($revenue->jan, 1, '.', ',') !!}</td>
                      <td>{!! number_format($revenue->feb, 1, '.', ',') !!}</td>
                      <td>{!! number_format($revenue->mar, 1, '.', ',') !!}</td>
                      <td>{!! number_format($revenue->apr, 1, '.', ',') !!}</td>
                      <td>{!! number_format($revenue->may, 1, '.', ',') !!}</td>
                      <td>{!! number_format($revenue->jun, 1, '.', ',') !!}</td>
                      <td>{!! number_format($revenue->jul, 1, '.', ',') !!}</td>
                      <td>{!! number_format($revenue->aug, 1, '.', ',') !!}</td>
                      <td>{!! number_format($revenue->sep, 1, '.', ',') !!}</td>
                      <td>{!! number_format($revenue->oct, 1, '.', ',') !!}</td>
                      <td>{!! number_format($revenue->nov, 1, '.', ',') !!}</td>
                      <td>{!! number_format($revenue->dece, 1, '.', ',') !!}</td>
                    </tr>
                  @endforeach
                  </tbody>
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
                    </tr>
                  </tfoot>
                </table>
                </br></br>
                <div style="font-size: 150%;" class="row">
                  Grand Total: €{!! number_format($grand_total, 1, '.', ',') !!} / 
                  @if(isset($revenue_target))My revenue target: €{!! number_format($revenue_target, 1, '.', ',') !!} / Diff: €{!! number_format($revenue_target-$grand_total, 1, '.', ',') !!}
                  @else My revenue target: - / Diff: - 
                  @endif
                </div>
              </div>
              <!-- Tab Revenue -->

              <!-- Tab Missing Revenue -->
              <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="missingRevenue-tab">
                <table id="revenueMissingTable" class="table table-striped table-hover table-bordered" width="100%">
                  <thead>
                    <tr>
                      <th>Cluster</th>
                      <th>Customer</th>
                      <th>Project ID</th>
                      <th>Project name</th>
                      <th>Project type</th>
                      <th>Project subtype</th>
                      <th>Project status</th>
                      <th>Gold Order</th>
                      <th>Samba ID</th>
                      <th>User ID</th>
                      <th>User name</th>
                      <th>Win ratio (%)</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($projects_without_revenue as $key => $revenueMissing)
                      <tr>
                        <td>{!! $revenueMissing->cluster_owner !!}</td>
                        <td>{!! $revenueMissing->customer_name !!}</td>
                        <td>{!! $revenueMissing->project_id !!}</td>
                        <td>{!! $revenueMissing->project_name !!}</td>
                        <td>{!! $revenueMissing->project_type !!}</td>
                        <td>{!! $revenueMissing->project_subtype !!}</td>
                        <td>{!! $revenueMissing->project_status !!}</td>
                        <td>{!! $revenueMissing->gold_order !!}</td>
                        <td>{!! $revenueMissing->samba_id !!}</td>
                        <td>{!! $revenueMissing->user_id !!}</td>
                        <td>{!! $revenueMissing->user_name !!}</td>
                        <td>{!! $revenueMissing->win_ratio !!}</td>
                      </tr>
                    @endforeach
                  </tbody>
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
                    </tr>
                  </tfoot>
                </table>
              </div>
              <!-- Tab Missing Revenue -->
            </div>
            <!-- Tab content -->

          </div>
        </div>
      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->
@stop

@section('script')
<script>
var month_col = [];

// Remove the formatting to get integer data for summation
var intVal = function ( i ) {
  return typeof i === 'string' ?
    i.replace(/[\$,]/g, '')*1 :
    typeof i === 'number' ?
        i : 0;
};

$(document).ready(function() {
  //Init select2 boxes
  $("#year").select2({
    allowClear: false,
    disabled: {{ $authUsersForDataView->year_select_disabled }}
  });
  $("#manager").select2({
    allowClear: false,
    disabled: {{ $authUsersForDataView->manager_select_disabled }}
  });

  $('#year,#manager').on('change', function() {
    year = $('#year').val();
    manager = $('#manager').val();
    window.location.href = "{!! route('revenuedashboard') !!}/"+year+"/"+manager;
  });

  month_col = [13,14,15,16,17,18,19,20,21,22,23,24];

  revenueTable = $('#revenueTable').DataTable({
    scrollX: true,
    stateSave: true,
    order: [[0, 'asc']],
    columns: [
        { name: 'cluster_owner', data: 'cluster_owner' , searchable: true , visible: true},
        { name: 'customer_name', data: 'customer_name' , searchable: true , visible: true},
        { name: 'project_id', data: 'project_id' , searchable: false , visible: false},
        { name: 'project_name', data: 'project_name' , searchable: true , visible: true},
        { name: 'project_type', data: 'project_type' , searchable: true , visible: true},
        { name: 'project_subtype', data: 'project_subtype' , searchable: true , visible: true},
        { name: 'project_status', data: 'project_status' , searchable: true , visible: true},
        { name: 'gold_order', data: 'gold_order' , searchable: true , visible: true},
        { name: 'samba_id', data: 'samba_id' , searchable: true , visible: true},
        { name: 'user_id', data: 'user_id' , searchable: false , visible: false},
        { name: 'user_name', data: 'user_name' , searchable: true , visible: true},
        { name: 'product_code', data: 'product_code' , searchable: true , visible: true},
        { name: 'win_ratio', data: 'win_ratio' , searchable: true , visible: true},
        { name: 'jan', data: 'jan' , searchable: true , visible: true},
        { name: 'feb', data: 'feb' , searchable: true , visible: true},
        { name: 'mar', data: 'mar' , searchable: true , visible: true},
        { name: 'apr', data: 'apr' , searchable: true , visible: true},
        { name: 'may', data: 'may' , searchable: true , visible: true},
        { name: 'jun', data: 'jun' , searchable: true , visible: true},
        { name: 'jul', data: 'jul' , searchable: true , visible: true},
        { name: 'aug', data: 'aug' , searchable: true , visible: true},
        { name: 'sep', data: 'sep' , searchable: true , visible: true},
        { name: 'oct', data: 'oct' , searchable: true , visible: true},
        { name: 'nov', data: 'nov' , searchable: true , visible: true},
        { name: 'dec', data: 'dec' , searchable: true , visible: true}
    ],
    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
    ],
    dom: 'Bfrtip',
    buttons: [
      {
        extend: "colvis",
        className: "btn-sm",
        columns: [0,1,3,4,5,6,7,8,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
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
        // Total over all pages
        total = api
          .column( value )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

        // Total over this page
        pageTotal = api
          .column( value, { page: 'current'} )
          .data()
          .reduce( function (a, b) {
            return intVal(a) + intVal(b);
          }, 0 );

        // Update footer
        $( api.column( value ).footer() ).html(
            '<div style="font-size: 120%;">'+pageTotal+'('+total+')</div>'
        );
      });
      
    }

  });

  revenueMissingTable = $('#revenueMissingTable').DataTable({
    scrollX: true,
    stateSave: true,
    order: [[0, 'asc']],
    columns: [
        { name: 'cluster_owner', data: 'cluster_owner' , searchable: true , visible: true},
        { name: 'customer_name', data: 'customer_name' , searchable: true , visible: true},
        { name: 'project_id', data: 'project_id' , searchable: false , visible: false},
        { name: 'project_name', data: 'project_name' , searchable: true , visible: true},
        { name: 'project_type', data: 'project_type' , searchable: true , visible: true},
        { name: 'project_subtype', data: 'project_subtype' , searchable: true , visible: true},
        { name: 'project_status', data: 'project_status' , searchable: true , visible: true},
        { name: 'gold_order', data: 'gold_order' , searchable: true , visible: true},
        { name: 'samba_id', data: 'samba_id' , searchable: true , visible: true},
        { name: 'user_id', data: 'user_id' , searchable: true , visible: true},
        { name: 'user_name', data: 'user_name' , searchable: true , visible: true},
        { name: 'win_ratio', data: 'win_ratio' , searchable: true , visible: true}
    ],
    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
    ],
    dom: 'Bfrtip',
    buttons: [
      {
        extend: "colvis",
        className: "btn-sm",
        columns: [0,1,3,4,5,6,7,8,10,11]
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
    ]
  });

  $('#revenueMissingTable').on('click', 'tbody td', function() {
      var table = revenueMissingTable;
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

    $('#revenueTable').on('click', 'tbody td', function() {
      var table = revenueTable;
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

    // This part is to make sure that datatables can adjust the columns size when it is hidden because on non active tab when created
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
    $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust();
    });

});


</script>
@stop