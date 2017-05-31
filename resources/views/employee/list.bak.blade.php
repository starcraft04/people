@extends('layouts.app')

@section('style')
    <!-- Select2 -->
    <link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/plugins/datatables/dataTables.bootstrap.css') }}">
@stop

@section('content')
    <!-- table widget -->
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-wrench"></i>
            <h3 class="box-title">Tools</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box-tools -->
        </div>
        <div class="box-body">
            <div class="row">
                <div class="form-group col-xs-2">
                    <label for="manager" class="control-label">Manager</label>
                    <select class="form-control select2" style="width: 100%;" id="manager" name="manager" multiple="multiple" data-placeholder="Select a manager">
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-2">
                    <button class="pull-left btn btn-default" id="update">Update <i class="fa fa-arrow-circle-right"></i></button>
                </div>
            </div>
        </div>
    </div>

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
                        <th>ID</th>
                        <th>Name</th>
                        <th>Manager ID</th>
                        <th>Manager</th>
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
            </table>
        </div>
    </div>

@stop

@section('script')

    <!-- Select2 -->
    <script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
    <!-- DataTables -->
    <script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>

    <script>
        var manager = [];
        var employeeTable;
        
        function ajaxData(){
            var obj = {
                'manager[]': manager
                };
            return obj;
            }
        
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            //Init select2 boxes
            $("#manager").select2({
                allowClear: true,
                ajax: {
                    url: "{!! route('ajaxlistmanager') !!}",
                    dataType: 'json',
                    type: "GET",
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.text,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });

            $("#update").click(function()
                {
                    manager = [];
                
                    $("#manager option:selected").each(function()
                        {
                        // log the value and text of each option
                        manager.push($(this).val());
                    });
                    employeeTable.ajax.reload();
                }
            );
            
            employeeTable = $('#employeeTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                        url: "{!! route('ajaxlistemployee') !!}",
                        type: "POST"
                    },
                columns: [
                    { data: 'id', name: 'id'},
                    { data: 'name', name: 'name'},
                    { data: 'manager_id', name: 'manager_id'},
                    { data: 'manager_name', name: 'manager_name'},
                    { data: 'is_manager', name: 'is_manager'},
                    { data: 'region', name: 'region'},
                    { data: 'country', name: 'country'},
                    { data: 'domain', name: 'domain'},
                    { data: 'subdomain', name: 'subdomain'},
                    { data: 'management_code', name: 'management_code'},
                    { data: 'job_role', name: 'job_role'},
                    { data: 'employee_type', name: 'employee_type'},
                    ],
                columnDefs: [
                    {
                        "targets": [0, 2], "visible": false, "searchable": false
                    }
                    ]
            } );

            $('#employeeTable').on( 'click', 'tr', function () {
                var rowData = employeeTable.row(this).data();
                var id = rowData.id;
                window.location.href = "{!! route('employee') !!}/"+id;
            } );
            
        } );
    </script> 
@stop