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
        th {
            padding-top: 5 px;
            padding-bottom: 5px;
        }
        table .extra_info {
            margin-bottom: 10px;
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
    <!-- Bootbox -->
    <script src="{{ asset('/plugins/bootbox/bootbox.min.js') }}"></script>
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
            @if(session()->has('ok'))
            <div class="alert alert-success alert-dismissible">
                <button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
                {!! session('ok') !!}
            </div>
            @endif
            <div id="delete_message">
            </div>
            <table id="employeeTable" class="display table-bordered table-hover table-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="10px"></th>
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
                        <th width="10px"><a data-toggle="tooltip" title="Create new" href="{{ route('employeeFormCreate') }}" class="btn btn-info btn-xs" align="right"><span class="glyphicon glyphicon-plus"> New</span></a></th>
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
                        <th></th>
                    </tr>
                </tfoot>
            </table>
            <script id="details-template" type="text/x-handlebars-template">
            <table class="extra_info table-bordered" cellspacing="0" width="100%" align="left">
                <thead>
                    <th width="20px"></th>
                    <th width="100px"></th>
                    <th></th>
                </thead>

                </tr>
                <tr>
                    <td></td>
                    <td><b>Manager name</b>:</td>
                    <td>@{{ manager_name }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Name</b>:</td>
                    <td>@{{ name }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Management code</b>:</td>
                    <td>@{{ management_code }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Domain</b>:</td>
                    <td>@{{ domain }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Subdomain</b>:</td>
                    <td>@{{ subdomain }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Region</b>:</td>
                    <td>@{{ region }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Job role</b>:</td>
                    <td>@{{ job_role }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Employee type</b>:</td>
                    <td>@{{ employee_type }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Is a Manager</b>:</td>
                    <td>@{{ is_manager }}</td>
                </tr>
            </table>
            </script>
        </div>
    </div>

@stop

@section('script')
    <script>
        var employeeTable;
        var record_id;

        $(document).ready(function() {
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
                        type: "POST",
                        dataSrc: function ( json ) {
                            for ( var i=0, ien=json.data.length ; i<ien ; i++ ) {
                                if (json.data[i].is_manager == 1){
                                    json.data[i].is_manager = 'true';
                                }
                                else {
                                    json.data[i].is_manager = 'false';
                                }
                            }
                            return json.data;
                        }
                    },
                columns: [
                    {
                        className:      'details-control',
                        orderable:      false,
                        searchable:     false,
                        data:           null,
                        defaultContent: ''
                    },
                    { name: 'employee.id', data: 'id' },
                    { name: 'manager.name', data: 'manager_name' },
                    { name: 'employee.name', data: 'name' },
                    { name: 'employee.manager_id', data: 'manager_id' },
                    { name: 'employee.is_manager', data: 'is_manager'},
                    { name: 'employee.region', data: 'region' },
                    { name: 'employee.country', data: 'country' },
                    { name: 'employee.domain', data: 'domain' },
                    { name: 'employee.subdomain', data: 'subdomain' },
                    { name: 'employee.management_code', data: 'management_code' },
                    { name: 'employee.job_role', data: 'job_role' },
                    { name: 'employee.employee_type', data: 'employee_type' },
                    {
                        name: 'actions',
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function (data) {
                            var actions = '';
                            actions += '<div class="btn-group btn-group-xs">';
                            actions += '<button data-toggle="tooltip" title="edit" id="'+data.id+'" class="buttonUpdate btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></button>';
                            actions += '<button data-toggle="tooltip" title="delete" id="'+data.id+'" class="buttonDelete btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>';
                            actions += '</div>';
                            return actions;
                        }
                    }
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
                        if(column[0][0] == '0' || column[0][0] == '13'){return true;};
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

            $(document).on('click', '.buttonUpdate', function () {
                window.location.href = "{!! route('employeeFormUpdate','') !!}/"+this.id;
            } );

            $(document).on('click', '.buttonDelete', function () {
                record_id = this.id;
                bootbox.confirm("Are you sure want to delete this record?", function(result) {
                    if (result){
                        $.ajax({
                            type: 'get',
                            url: "{!! route('employeeDelete','') !!}/"+record_id,
                            dataType: 'json',
                            success: function(data) {
                                //console.log(data);
                                if (data.result){
                                    box_type = 'success';
                                }
                                else {
                                    box_type = 'danger';
                                }
                                $('#delete_message').empty();
                                var box = $('<div class="alert alert-'+box_type+' alert-dismissible"><button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>'+data.msg+'</div>');
                                $('#delete_message').append(box);
                                employeeTable.ajax.reload();
                            }
                        });
                    }
                });
            } );

        } );
    </script>
@stop
