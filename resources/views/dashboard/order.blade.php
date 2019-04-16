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
    <h3>Order dashboard</h3>
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

        <div class="form-group row">
          <div class="col-xs-6">
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
          <div class="col-xs-6">
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
        <div class="row">
          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <!-- Tab titles -->
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
              <li role="presentation" class="active"><a href="#tab_content1" id="order-tab" role="tab" data-toggle="tab" aria-expanded="true">Orders(€)</a>
              </li>
            </ul>
            <!-- Tab titles -->

            <!-- Tab content -->
            <div id="myTabContent" class="tab-content">
              <!-- Tab order -->
              <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="order-tab">
                <table id="orderTable" class="table table-striped table-hover table-bordered mytable" width="100%">
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
                      <th>Pull-thru Samba ID</th>
                      <th>Samba opportunity owner</th>
                      <th>User ID</th>
                      <th>User name</th>
                      <th>Win ratio (%)</th>
                      <th>Samba lead domain</th>
                      <th>Samba stage</th>
                      <th>Order intake</th>
                      <th>Consulting TCV</th>
                      <th>Pull-Thru TCV</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($all_orders as $key => $order)
                    <tr>
                      <td>{!! $order->cluster_owner !!}</td>
                      <td>{!! $order->customer_name !!}</td>
                      <td>{!! $order->project_id !!}</td>
                      <td>{!! $order->project_name !!}</td>
                      <td>{!! $order->project_type !!}</td>
                      <td>{!! $order->project_subtype !!}</td>
                      <td>{!! $order->project_status !!}</td>
                      <td>{!! $order->gold_order !!}</td>
                      <td>{!! $order->samba_id !!}</td>
                      <td>{!! $order->pullthru_samba_id !!}</td>
                      <td>{!! $order->samba_opportunit_owner !!}</td>
                      <td>{!! $order->user_id !!}</td>
                      <td>{!! $order->user_name !!}</td>
                      <td>{!! $order->win_ratio !!}</td>
                      <td>{!! $order->samba_lead_domain !!}</td>
                      <td>{!! $order->samba_stage !!}</td>
                      <td>{!! number_format($order->revenue, 1, '.', ',') !!}</td>
                      <td>{!! number_format($order->samba_consulting_product_tcv, 1, '.', ',') !!}</td>
                      <td>{!! number_format($order->samba_pullthru_tcv, 1, '.', ',') !!}</td>
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
                    </tr>
                  </tfoot>
                </table>
                </br></br>
                <div style="font-size: 150%;">
                  Grand Total Full Value</br>
                </div>
                <div style="font-size: 100%;">
                  Order Intake: €{!! number_format($grand_total['revenue'], 1, '.', ',') !!}</br>
                  Consulting TCV: €{!! number_format($grand_total['samba_consulting_product_tcv'], 1, '.', ',') !!} / 
                  @if(isset($order_target))My order target: €{!! number_format($order_target, 1, '.', ',') !!} / Diff: €{!! number_format($order_target-$grand_total['revenue'], 1, '.', ',') !!}
                  @else My order target: - / Diff: - 
                  @endif</br>
                  Pull-Thru TCV: €{!! number_format($grand_total['samba_pullthru_tcv'], 1, '.', ',') !!}</br>
                </div>
                <div style="font-size: 150%;">
                  Grand Total Weighted Value</br>
                </div>
                <div style="font-size: 100%;">
                    Order Intake: €{!! number_format($grand_total_weighted['revenue'], 1, '.', ',') !!}</br>
                    Consulting TCV: €{!! number_format($grand_total_weighted['samba_consulting_product_tcv'], 1, '.', ',') !!} / 
                    @if(isset($order_target))My order target: €{!! number_format($order_target, 1, '.', ',') !!} / Diff: €{!! number_format($order_target-$grand_total_weighted['revenue'], 1, '.', ',') !!}
                    @else My order target: - / Diff: - 
                    @endif</br>
                    Pull-Thru TCV: €{!! number_format($grand_total_weighted['samba_pullthru_tcv'], 1, '.', ',') !!}</br>
                </div>
              </div>
              <!-- Tab order -->
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
    window.location.href = "{!! route('orderdashboard') !!}/"+year+"/"+manager;
  });

  var sum_col = [16,17,18];

  orderTable = $('#orderTable').DataTable({
    scrollX: true,
    @if(isset($table_height))
    scrollY: '{!! $table_height !!}vh',
    scrollCollapse: true,
    @endif
    stateSave: true,
    order: [[0, 'asc']],
    columns: [
        { name: 'cluster_owner', data: 'cluster_owner' , searchable: true , visible: true, className: "dt-nowrap"},
        { name: 'customer_name', data: 'customer_name' , searchable: true , visible: true, className: "dt-nowrap"},
        { name: 'project_id', data: 'project_id' , searchable: false , visible: false},
        { name: 'project_name', data: 'project_name' , searchable: true , visible: true, className: "dt-nowrap"},
        { name: 'project_type', data: 'project_type' , searchable: true , visible: true, className: "dt-nowrap"},
        { name: 'project_subtype', data: 'project_subtype' , searchable: true , visible: true, className: "dt-nowrap"},
        { name: 'project_status', data: 'project_status' , searchable: true , visible: true, className: "dt-nowrap"},
        { name: 'gold_order', data: 'gold_order' , searchable: true , visible: true, className: "dt-nowrap"},
        { name: 'samba_id', data: 'samba_id' , searchable: true , visible: true, className: "dt-nowrap"},
        { name: 'pullthru_samba_id', data: 'pullthru_samba_id' , searchable: true , visible: true, className: "dt-nowrap"},
        { name: 'samba_opportunit_owner', data: 'samba_opportunit_owner' , searchable: true , visible: true, className: "dt-nowrap"},
        { name: 'user_id', data: 'user_id' , searchable: false , visible: false, className: "dt-nowrap"},
        { name: 'user_name', data: 'user_name' , searchable: true , visible: true, className: "dt-nowrap"},
        { name: 'win_ratio', data: 'win_ratio' , searchable: true , visible: true, className: "dt-nowrap"},
        { name: 'samba_lead_domain', data: 'samba_lead_domain' , searchable: true , visible: true, className: "dt-nowrap"},
        { name: 'samba_stage', data: 'samba_stage' , searchable: true , visible: true, className: "dt-nowrap"},
        { name: 'order', data: 'order' , searchable: true , visible: true, className: "dt-nowrap"},
        { name: 'samba_consulting_product_tcv', data: 'samba_consulting_product_tcv' , searchable: true , visible: true, className: "dt-nowrap"},
        { name: 'samba_pullthru_tcv', data: 'samba_pullthru_tcv' , searchable: true , visible: true, className: "dt-nowrap"}
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
        columns: [0,1,3,4,5,6,7,8,9,10,12,13,14,15,16,17,18]
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

      $.each(sum_col, function( index, value ) {
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

  $('#orderTable').on('click', 'tbody td', function() {
    var table = orderTable;
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