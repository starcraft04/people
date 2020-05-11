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
    <h3>LoE dashboard</h3>
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
        </div>
        <div class="row">
          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <!-- Tab titles -->
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
              <li role="presentation" class="active"><a href="#tab_content1" id="loe-tab" role="tab" data-toggle="tab" aria-expanded="true">LoE</a>
              </li>
            </ul>
            <!-- Tab titles -->

            <!-- Tab content -->
            <div id="myTabContent" class="tab-content">
              <!-- Tab loe -->
              <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="loe-tab">
                <table id="loeTable" class="table table-striped table-hover table-bordered mytable" width="100%">
                  <thead>
                      <tr>
                        <th>ID</th>
                        <th>Project ID</th>
                        <th>Cluster</th>
                        <th>Customer</th>
                        <th>Project</th>
                        <th>CL ID</th>
                        <th>Manager</th>
                        <th>Created by</th>
                        <th>Start date</th>
                        <th>End date</th>
                        <th>Domain</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Man days</th>
                        <th>Description</th>
                        <th>History</th>
                        <th>Signoff</th>
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
                        <th></th>
                    </tr>
                </tfoot>
                </table>
              </div>
              <!-- Tab loe -->
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

<?php
  list($validate, $allValidations) = Entrust::ability(null,['projectLoe-signoff'],['validate_all' => true,'return_type' => 'both']);
  echo "var permissions = jQuery.parseJSON('".json_encode($allValidations['permissions'])."');";
?>

$(document).ready(function() {
  var year = "{!! $year !!}";

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

  //Init select2 boxes
  $("#year").select2({
    allowClear: false,
    disabled: {{ $authUsersForDataView->year_select_disabled }}
  });

  $('#year').on('change', function() {
    year = $('#year').val();
    window.location.href = "{!! route('loedashboard') !!}/"+year;
  });

  var projectLoe = $('#loeTable').DataTable({
        serverSide: true,
        processing: true,
        scrollX: true,
        stateSave: true,
        responsive: false,
        ajax: {
                url: "{!! route('listOfAllProjectsLoeAjax','') !!}/"+year,
                type: "GET",
                dataType: "JSON"
            },
        columns: [
            { name: 'project_loe.id', data: 'loe_id' , searchable: false , visible: false },
            { name: 'project_loe.project_id', data: 'p_id' , searchable: false , visible: false },
            { name: 'customers.cluster_owner', data: 'cluster_owner' , searchable: true , visible: true },
            { name: 'customers.name', data: 'customer_name' , searchable: true , visible: true },
            { name: 'projects.project_name', data: 'project_name' , searchable: true , visible: true },
            { name: 'projects.samba_id', data: 'samba_id' , searchable: true , visible: true },
            { name: 'm.name', data: 'manager_name' , searchable: true , visible: true },
            { name: 'users.name', data: 'user_name' , searchable: true , visible: true },
            { name: 'project_loe.start_date', data: 'start_date' , searchable: true , visible: true },
            { name: 'project_loe.end_date', data: 'end_date' , searchable: true , visible: true },
            { name: 'project_loe.domain', data: 'domain' , searchable: true , visible: true },
            { name: 'project_loe.type', data: 'type' , searchable: true , visible: true },
            { name: 'project_loe.location', data: 'location' , searchable: true , visible: true },
            { name: 'project_loe.mandays', data: 'mandays' , searchable: true , visible: true },
            { name: 'project_loe.description', data: 'description' , searchable: true , visible: true },
            { name: 'project_loe.history', data: 'history' , searchable: false , visible: false },
            { 
              name: 'project_loe.signoff',
              data: 'signoff',
              sortable: true,
              searchable: true,
              visible: true,
              render: function (data, type, row) {
                  var actions = '';
                  // Getting the status of signoff for the color
                  if (data == 1) {
                    signoff_button_icon = 'ok';
                    signoff_button_color = 'success';
                  } else {
                    signoff_button_icon = 'remove';
                    signoff_button_color = 'danger';
                  }
                  actions += '<div class="btn-group btn-group-xs">';
                  actions += '<button type="button" data-id="'+data.loe_id+'" class="buttonLoeSignoff btn btn-'+signoff_button_color+'"><span class="glyphicon glyphicon-'+signoff_button_icon+'"></span></button>';
                  actions += '</div>';
                  return type === 'export' ? data : actions;
                },
                width: '70px'
            },
            { name: 'project_loe.created_at', data: 'created_at' , searchable: true , visible: false },
            { name: 'project_loe.updated_at', data: 'updated_at' , searchable: true , visible: false }
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
            // Restore state
            var state = projectLoe.state.loaded();
            if (state) {
              projectLoe.columns().eq(0).each(function (colIdx) {
                    var colSearch = state.columns[colIdx].search;

                    if (colSearch.search) {
                        $('input', projectLoe.column(colIdx).footer()).val(colSearch.search);
                    }
                });
            }
        }
    });


  // Click on the project name to open the project in edit mode
  $('#loeTable').on('click', 'tbody td', function() {
    year = $('#year').val();
    var table = projectLoe;
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    //get the initialization options
    var columns = table.settings().init().columns;
    //get the index of the clicked cell
    var colIndex = table.cell(this).index().column;
    columns_can_forward = [4]

    if (columns_can_forward.includes(colIndex)) {
      window.location.href = "{!! route('toolsFormUpdate',['','','','']) !!}/"+"0"+"/"+row.data().p_id+"/"+year+"/"+'tab_loe';
    }
  });


  // Click on the signoff button to change its status
  $(document).on('click', '.buttonLoeSignoff', function () {
      var table = projectLoe;
      var tr = $(this).closest('tr');
      var row = table.row(tr);
      var loe_id = row.data().loe_id;
      // console.log('the loe id is '+row.data().loe_id);
      //console.log(permissions['projectLoe-signoff']);
      if (permissions['projectLoe-signoff']) {
        data = {};
        $.ajax({
            type: 'get',
            url: "{!! route('listOfProjectsLoeSignoffAjax',['']) !!}/"+loe_id,
            data:data,
            dataType: 'json',
            success: function(data) {
              console.log(data);
              if (data.result == 'success'){
                  box_type = 'success';
                  message_type = 'success';
              }
              else {
                  box_type = 'danger';
                  message_type = 'error';
              }

              $('#flash-message').empty();
              var box = $('<div id="delete-message" class="alert alert-'+box_type+' alert-dismissible flash-'+message_type+'" role="alert"><button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>'+data.msg+'</div>');
              $('#flash-message').append(box);
              $('#delete-message').delay(2000).queue(function () {
                  $(this).addClass('animated flipOutX')
              });
              projectLoe.ajax.reload();
            }
        });
      }
    });

  // This part is to make sure that datatables can adjust the columns size when it is hidden because on non active tab when created
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
  $($.fn.dataTable.tables(true)).DataTable()
      .columns.adjust();
  });

});


</script>
@stop