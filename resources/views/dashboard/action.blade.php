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
<!-- Progressbar -->
<link href="{{ asset('/plugins/gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
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
<!-- Progressbar -->
<script src="{{ asset('/plugins/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}" type="text/javascript"></script>
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Action dashboard</h3>
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
          <h2>Actions</small></h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <div class="row">
          <!-- Tab action -->
          <table id="actionTable" class="table table-striped table-hover table-bordered mytable" width="100%">
            <thead>
                <tr>
                  <th>Project ID</th>
                  <th>Assigned to user id</th>
                  <th>Customer name</th>
                  <th>Project name</th>
                  <th>Created by</th>
                  <th>Assigned to</th>
                  <th>Action name</th>
                  <th>Requestor</th>
                  <th>Status</th>
                  <th>Percent complete</th>
                  <th>Priority</th>
                  <th>Start date</th>
                  <th>End date</th>
                  <th>Description</th>
                  <th>Next action desc</th>
                  <th>Next action dependency</th>
                  <th>Next action due date</th>
                  <th>Created at</th>
                  <th>Updated at</th>
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
              </tr>
            </tfoot>
          </table>
          <!-- Tab action -->
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

$(document).ready(function() {
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

  var actionTable = $('#actionTable').DataTable({
        serverSide: true,
        processing: true,
        scrollX: true,
        stateSave: true,
        responsive: false,
        ajax: {
                url: "{!! route('actionListAjax') !!}",
                type: "GET",
                dataType: "JSON"
            },
        columns: [
          { name: 'actions.project_id', data: 'project_id' , searchable: false , visible: false },
          { name: 'assigned.id', data: 'assigned_to_user_id' , searchable: false , visible: false },
          { name: 'customers.name', data: 'customer_name' , searchable: true , visible: true },
          { name: 'projects.project_name', data: 'project_name' , searchable: true , visible: true },
          { name: 'created_by.name', data: 'created_by_name' , searchable: true , visible: true },
          { name: 'assigned.name', data: 'assigned_to_name' , searchable: true , visible: true },
          { name: 'actions.name', data: 'action_name' , searchable: true , visible: true },
          { name: 'actions.requestor', data: 'action_requestor' , searchable: true , visible: true },
          { name: 'actions.status', data: 'action_status' , searchable: true , visible: true },
          { 
            name: 'actions.percent_complete', 
            data: 'percent_complete', 
            searchable: true, 
            visible: true,
            render: function (data, type, row) {
                  //console.log(data);
                  var actions = '';
                  actions += '<small>'+data+'% Complete</small>';
                  actions += '<div class="progress">';
                  actions += '<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="'+data+'" aria-valuemin="0" aria-valuemax="100" style="width:'+data+'%">';
                  actions += '</div>';
                  actions += '</div>';
                  return type === 'export' ? data : actions;
                },
            width: '150px'
          },
          { name: 'actions.severity', data: 'action_severity' , searchable: true , visible: true },
          { name: 'actions.estimated_start_date', data: 'action_start_date' , searchable: true , visible: true },
          { name: 'actions.estimated_end_date', data: 'action_end_date' , searchable: true , visible: true },
          { name: 'actions.description', data: 'action_description' , searchable: true , visible: true },
          { name: 'actions.next_action_description', data: 'next_action_description' , searchable: true , visible: true },
          { name: 'actions.next_action_dependency', data: 'next_action_dependency' , searchable: true , visible: true },
          { name: 'actions.next_action_due_date', data: 'next_action_due_date' , searchable: true , visible: true },
          { name: 'actions.created_at', data: 'created_at' , searchable: true , visible: true },
          { name: 'actions.updated_at', data: 'updated_at' , searchable: true , visible: true }
          ],
        order: [[2, 'desc']],
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        dom: 'Bfrtip',
        buttons: [
          {
            extend: "colvis",
            className: "btn-sm",
            columns: [ 2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18]
          },
          {
            extend: "pageLength",
            className: "btn-sm"
          },
          {
            extend: "csv",
            className: "btn-sm",
            exportOptions: {
                columns: ':visible',
                orthogonal: 'export'
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
                }
            });
            // Restore state or get actions for auth user
            user_name = "{{ $user_name }}";
            if (user_name != '') {
              $('input', actionTable.column(5).footer()).val(user_name);
            } else {
              var state = actionTable.state.loaded();
              if (state) {
                actionTable.columns().eq(0).each(function (colIdx) {
                      var colSearch = state.columns[colIdx].search;

                      if (colSearch.search) {
                          $('input', actionTable.column(colIdx).footer()).val(colSearch.search);
                      }
                  });
              }
            }
            
        }
    });


  // Click on the project name to open the project in edit mode
  $('#actionTable').on('click', 'tbody td', function() {
    year = {{ date('Y') }};
    user_id = {{ Auth::user()->id }};
    var table = actionTable;
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    //get the initialization options
    var columns = table.settings().init().columns;
    //get the index of the clicked cell
    var colIndex = table.cell(this).index().column;

    window.location.href = "{!! route('toolsFormUpdate',['','','','']) !!}/"+user_id+"/"+row.data().project_id+"/"+year+"/"+'tab_action';
  });

  // This part is to make sure that datatables can adjust the columns size when it is hidden because on non active tab when created
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
    $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust();
  });
});


</script>
@stop