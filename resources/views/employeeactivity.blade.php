@extends('layouts.app')

@section('style')
    <!-- Select2 -->
    <link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/plugins/datatables/dataTables.bootstrap.css') }}">
@stop

@section('content')

    <!-- table widget -->
    <div class="box box-info">

        <div class="box-header">
            <i class="fa fa-wrench"></i>
            <h3 class="box-title">Tools</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box-tools -->
        </div>

        <div class="box-body">
            <label for="Search_All">Search all: </label>
            <input type="text" id="Search_All">
        </div>
    </div>

    <!-- table widget -->
    <div class="box box-info">

        <div class="box-header">
            <i class="fa fa-cloud-upload"></i>
            <h3 class="box-title">Employee activity</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box-tools -->
        </div>

        <div class="box-body">
            <table id="employeeActivityTable" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Month</th>
                        <th>Hours</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- table widget -->
    <div class="box box-warning">

        <div class="box-header">
            <i class="fa fa-cloud-upload"></i>
            <h3 class="box-title">Project activity</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box-tools -->
        </div>

        <div class="box-body">
            <table id="projectActivityTable" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Project ID</th>
                        <th>Customer name</th>
                        <th>Project name</th>
                        <th>Meta activity</th>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Month</th>
                        <th>Hours</th>
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
    <script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();
        });
        
        $.fn.dataTableExt.oApi.fnFilterAll = function (oSettings, sInput, iColumn, bRegex, bSmart) {
            var settings = $.fn.dataTableSettings;

            for (var i = 0; i < settings.length; i++) {
                settings[i].oInstance.fnFilter(sInput, iColumn, bRegex, bSmart);
            }
        };

        $(document).ready(function() {
            $('#employeeActivityTable').DataTable( {
                ajax: "{!! route('home') !!}/activityperemployee/employee_id/all/month/all",
                columns: [
                    { data: 'employee_id', name: 'employee_id' },
                    { data: 'employee_name', name: 'employee_name' },
                    { data: 'month', name: 'month' },
                    { data: 'sum_task_hour', name: 'sum_task_hour' }
                    ],
                columnDefs: [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                        "searchable": false
                    }
                    ]
            } );
        
            var oTable0 = $("#table1").dataTable();

            $("#Search_All").keyup(function () {
               // Filter on the column (the index) of this element
               oTable0.fnFilterAll(this.value);
            });
        } );
        
        $(document).ready(function() {
            $('#projectActivityTable').DataTable( {
                ajax: "{!! route('home') !!}/activityperproject/employee_id/all/month/all",
                columns: [
                    { data: 'project_id', name: 'project_id' },
                    { data: 'customer_name', name: 'customer_name' },
                    { data: 'project_name', name: 'project_name' },
                    { data: 'meta_activity', name: 'meta_activity' },
                    { data: 'employee_id', name: 'employee_id' },
                    { data: 'employee_name', name: 'employee_name' },
                    { data: 'month', name: 'month' },
                    { data: 'sum_task_hour', name: 'sum_task_hour' }
                    ],
                columnDefs: [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": [ 3 ],
                        "visible": false,
                        "searchable": false
                    }
                    ]
            } );
 
            var oTable1 = $("#table1").dataTable();

            $("#Search_All").keyup(function () {
               // Filter on the column (the index) of this element
               oTable1.fnFilterAll(this.value);
            });

        } );
    </script> 
@stop