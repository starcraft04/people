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
@stop

@section('content')

<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Project assignment</h3>
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
        <h2>Unassigned projects</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <br />
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible">
                <button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
                {{ $message }}
            </div>
            @endif
            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible">
                <button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
                {{ $message }}
            </div>
            @endif

            <div id="delete_message">
            </div>
            <table id="projectTable_unassigned" class="table table-striped table-hover table-bordered" width="100%">
                <thead>
                    <tr>
                      <th>ID</th>
                      <th>Customer name</th>
                      <th>Project name</th>
                      <th>OTL project code</th>
                      <th>Meta-activity</th>
                      <th>Project type</th>
                      <th>Activity type</th>
                      <th>Project status</th>
                      <th>Region</th>
                      <th>Country</th>
                      <th>Technology</th>
                      <th>Description</th>
                      <th>Estimated start date</th>
                      <th>Estimated end date</th>
                      <th>Comments</th>
                      <th>LoE onshore</th>
                      <th>LoE nearshore</th>
                      <th>LoE offshore</th>
                      <th>LoE contractor</th>
                      <th>Gold order</th>
                      <th>FPC</th>
                      <th>Revenue (€)</th>
                      <th>Win ratio (%)</th>
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
                    </tr>
                </tfoot>
            </table>
        </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->
@stop

@section('script')
    <script>
        var projectTable_unassigned;
        var projectTable_assigned;

        function ajaxData_unassigned(){
          var obj = {
            'unassigned': 'true'
          };
          return obj;
        }

        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            projectTable_unassigned = $('#projectTable_unassigned').DataTable({
                scrollX: true,
                serverSide: true,
                processing: true,
                stateSave: true,
                ajax: {
                        url: "{!! route('listOfProjectsAjax') !!}",
                        type: "POST",
                        data: function ( d ) {
                          $.extend(d,ajaxData_unassigned());
                        },
                        dataType: "JSON"
                    },
                columns: [
                    { name: 'id', data: 'id', searchable: false , visible: false },
                    { name: 'customer_name', data: 'customer_name' },
                    { name: 'project_name', data: 'project_name' },
                    { name: 'otl_project_code', data: 'otl_project_code' , visible: false },
                    { name: 'meta_activity', data: 'meta_activity' , visible: false },
                    { name: 'project_type', data: 'project_type'},
                    { name: 'activity_type', data: 'activity_type'},
                    { name: 'project_status', data: 'project_status'},
                    { name: 'region', data: 'region' , visible: false},
                    { name: 'country', data: 'country'  , visible: false},
                    { name: 'technology', data: 'technology' },
                    { name: 'description', data: 'description' , visible: false },
                    { name: 'estimated_start_date', data: 'estimated_start_date' },
                    { name: 'estimated_end_date', data: 'estimated_end_date' },
                    { name: 'comments', data: 'comments' , visible: false },
                    { name: 'LoE_onshore', data: 'LoE_onshore' , visible: false },
                    { name: 'LoE_nearshore', data: 'LoE_nearshore', visible: false},
                    { name: 'LoE_offshore', data: 'LoE_offshore', visible: false },
                    { name: 'LoE_contractor', data: 'LoE_contractor' , visible: false },
                    { name: 'gold_order_number', data: 'gold_order_number' , visible: false },
                    { name: 'product_code', data: 'product_code' , visible: false },
                    { name: 'revenue', data: 'revenue', visible: false},
                    { name: 'win_ratio', data: 'win_ratio' , visible: false }
                    ],
                order: [[1, 'asc'],[2, 'asc']],
                lengthMenu: [
                    [ 5, 10, 25, 50, -1 ],
                    [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
                ],
                dom: 'Bfrtip',
                buttons: [
                  {
                    extend: "colvis",
                    className: "btn-sm",
                    columns: ':gt(0)'
                  },
                  {
                    extend: "pageLength",
                    className: "btn-sm"
                  },
                  {
                    extend: "csv",
                    className: "btn-sm",
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6 ]
                    }
                  },
                  {
                    extend: "excel",
                    className: "btn-sm",
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6 ]
                    }
                  },
                  {
                    extend: "print",
                    className: "btn-sm",
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6 ]
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
                    // Restore state
                    var state = projectTable_unassigned.state.loaded();
                    if (state) {
                        projectTable_unassigned.columns().eq(0).each(function (colIdx) {
                            var colSearch = state.columns[colIdx].search;

                            if (colSearch.search) {
                                $('input', projectTable_unassigned.column(colIdx).footer()).val(colSearch.search);
                            }
                        });

                        projectTable_unassigned.draw();
                    }
                }
            });

            $('#projectTable_unassigned').on('click', 'tbody td', function() {
              var table = projectTable_unassigned;
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
              window.location.href = "{!! route('toolsFormUpdate',[$user_id_for_update,'','']) !!}/"+row.data().id+"/"+{{ $year }};
            });

        } );
    </script>
@stop
