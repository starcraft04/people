@extends('layouts.app')

@section('style')
    <!-- CSS -->
    <!-- Select2 -->
    <link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/plugins/datatables/dataTables.bootstrap.css') }}">

    <style>
        td.details-control {
        background: url("{{ asset('/plugins/datatables/details_open.png') }}") no-repeat center center;
        cursor: pointer;
        }
        tr.shown td.details-control {
            background: url("{{ asset('/plugins/datatables/details_close.png') }}") no-repeat center center;
        }
    </style>
@stop

@section('scriptsrc')
    <!-- JS -->
    <!-- Select2 -->
    <script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
    <!-- DataTables -->
    <script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/datatables/handlebars.js') }}"></script>
@stop

@section('content')
    <!-- table widget -->
    <div class="box box-info">

        <div class="box-header">
            <i class="fa fa-cloud-download"></i>
            <h3 class="box-title">Employee List</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box-tools -->
        </div>

        <div class="box-body">
            <table id="employeeTable" class="display table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Manager name</th>
                        <th>Name</th>
                        <th>Manager ID</th>
                        <th>Is Manager</th>
                        <th>Region</th>
                        <th>Country</th>
                        <th>Domain</th>
                        <th>Subdomain</th>
                        <th>Management Code</th>
                        <th>Job role</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Manager name</th>
                        <th>Name</th>
                        <th>Manager ID</th>
                        <th>Is Manager</th>
                        <th>Region</th>
                        <th>Country</th>
                        <th>Domain</th>
                        <th>Subdomain</th>
                        <th>Management Code</th>
                        <th>Job role</th>
                        <th>Type</th>
                    </tr>
                </tfoot>
            </table>
            <script id="details-template" type="text/x-handlebars-template">
            <table class="extra_info table-bordered" cellspacing="0" width="90%" align="right">
                <thead>
                    <th width="10%"></th>
                    <th></th>
                </thead>
                    
                </tr>
                <tr>
                    <td>Manager name:</td>
                    <td>@{{ manager_name }}</td>
                </tr>
                <tr>
                    <td>Name:</td>
                    <td>@{{ name }}</td>
                </tr>
                <tr>
                    <td>Management code:</td>
                    <td>@{{ management_code }}</td>
                </tr>
                <tr>
                    <td>Domain:</td>
                    <td>@{{ domain }}</td>
                </tr>
                <tr>
                    <td>Subdomain:</td>
                    <td>@{{ subdomain }}</td>
                </tr>
                <tr>
                    <td>Region:</td>
                    <td>@{{ region }}</td>
                </tr>
                <tr>
                    <td>Job role:</td>
                    <td>@{{ job_role }}</td>
                </tr>
                <tr>
                    <td>Employee type:</td>
                    <td>@{{ employee_type }}</td>
                </tr>
            </table>
            </script>
        </div>
    </div>

@stop

@section('script')
    <script>
        $(document).ready(function() {
            var employeeTable;
            var template = Handlebars.compile($("#details-template").html());
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            employeeTable = $('#employeeTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                        url: "{!! route('ajaxlistemployee') !!}",
                        type: "POST"
                    },
                columns: [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "searchable":     false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    { data: 'id', name: 'employee.id'},
                    { data: 'manager_name', name: 'manager.name'},
                    { data: 'name', name: 'employee.name'},
                    { data: 'manager_id', name: 'employee.manager_id'},
                    { data: 'is_manager', name: 'employee.is_manager'},
                    { data: 'region', name: 'employee.region'},
                    { data: 'country', name: 'employee.country'},
                    { data: 'domain', name: 'employee.domain'},
                    { data: 'subdomain', name: 'employee.subdomain'},
                    { data: 'management_code', name: 'employee.management_code'},
                    { data: 'job_role', name: 'employee.job_role'},
                    { data: 'employee_type', name: 'employee.employee_type'},
                    ],
                columnDefs: [
                    {
                        "targets": [1, 4, 5, 6, 9, 11, 12], "visible": false, "searchable": false
                    }
                    ],
                order: [[2, 'asc']],
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        // Now we need to skip the first column as it is used for the drawer...
                        if(column[0][0] == '0'){return true;};
                        var input = document.createElement("input");
                        $(input).appendTo($(column.footer()).empty())
                        .on('keyup change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    });
                }
            } );
            
            // Add event listener for opening and closing details
            $('#employeeTable tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = employeeTable.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( template(row.data()) ).show();
                    tr.addClass('shown');
                }
            });
            
        } );
    </script> 
@stop