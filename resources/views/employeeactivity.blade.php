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
                    <label for="Search_All" class="control-label">Search all</label>
                    <input type="text" id="Search_All" class="form-control" placeholder="Search">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-2">
                    <label for="domain" class="control-label">Domain</label>
                    <select class="form-control select2" style="width: 100%;" id="domain" name="domain" multiple="multiple" data-placeholder="Select a domain">
                    </select>
                </div>
                <div class="form-group col-xs-2">
                    <label for="subdomain" class="control-label">Subdomain</label>
                    <select class="form-control select2" style="width: 100%;" id="subdomain" name="subdomain" multiple="multiple" data-placeholder="Select a subdomain">
                    </select>
                </div>
                <div class="form-group col-xs-2">
                    <label for="jobrole" class="control-label">Job role</label>
                    <select class="form-control select2" style="width: 100%;" id="jobrole" name="jobrole" multiple="multiple" data-placeholder="Select a job role">
                    </select>
                </div>
                <div class="form-group col-xs-2">
                    <label for="month" class="control-label">Month</label>
                    <select class="form-control select2" style="width: 100%;" id="month" name="month" multiple="multiple" data-placeholder="Select a month">
                    </select>
                </div>
                <div class="form-group col-xs-2">
                    <label for="metaactivity" class="control-label">Meta activity</label>
                    <select class="form-control select2" style="width: 100%;" id="metaactivity" name="metaactivity" multiple="multiple" data-placeholder="Select a meta-activity">
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
            <i class="fa fa-cloud-download"></i>
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
    <script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>

    <script>
        var domain = [];
        var subdomain = [];
        var job_role = [];
        var month = [];
        var meta_activity = [];
        var employeeActivityTable;
        var projectActivityTable;

        function ajaxData(){
            var obj = {
                'domain[]': domain,
                'subdomain[]': subdomain,
                'job_role[]': job_role,
                'month[]': month,
                'meta_activity[]': meta_activity
                };
            return obj;
            }
        
        $.fn.dataTableExt.oApi.fnFilterAll = function (oSettings, sInput, iColumn, bRegex, bSmart) {
            var settings = $.fn.dataTableSettings;

            for (var i = 0; i < settings.length; i++) {
                settings[i].oInstance.fnFilter(sInput, iColumn, bRegex, bSmart);
            }
        };

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            //Init select2 boxes
            $("#domain").select2({
                allowClear: true,
                ajax: {
                    url: "{!! route('ajaxlistdomain') !!}",
                    dataType: 'json',
                    type: "GET",
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.text,
                                    id: item.text
                                }
                            })
                        };
                    }
                }
            });
            //Init select2 boxes
            $("#subdomain").select2({
                allowClear: true,
                ajax: {
                    url: "{!! route('ajaxlistsubdomain') !!}",
                    dataType: 'json',
                    type: "GET",
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.text,
                                    id: item.text
                                }
                            })
                        };
                    }
                }
            });
            //Init select2 boxes
            $("#jobrole").select2({
                allowClear: true,
                ajax: {
                    url: "{!! route('ajaxlistjobrole') !!}",
                    dataType: 'json',
                    type: "GET",
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.text,
                                    id: item.text
                                }
                            })
                        };
                    }
                }
            });
            //Init select2 boxes
            $("#month").select2({
                allowClear: true,
                data:[
                    { id: 'Jan', text: 'Jan' },
                    { id: 'Feb', text: 'Feb' },
                    { id: 'Mar', text: 'Mar' },
                    { id: 'Apr', text: 'Apr' },
                    { id: 'May', text: 'May' },
                    { id: 'Jun', text: 'Jun' },
                    { id: 'Jul', text: 'Jul' },
                    { id: 'Aug', text: 'Aug' },
                    { id: 'Sep', text: 'Sep' },
                    { id: 'Oct', text: 'Oct' },
                    { id: 'Nov', text: 'Nov' },
                    { id: 'Dec', text: 'Dec' }
                ]
            });
            //Init select2 boxes
            $("#metaactivity").select2({
                allowClear: true,
                ajax: {
                    url: "{!! route('ajaxlistmetaactivity') !!}",
                    dataType: 'json',
                    type: "GET",
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.text,
                                    id: item.text
                                }
                            })
                        };
                    }
                }
            });
            
            $("#update").click(function()
                {
                    domain = [];
                    subdomain = [];
                    job_role = [];
                    month = [];
                    meta_activity = [];
                
                    $("#domain option:selected").each(function()
                        {
                        // log the value and text of each option
                        domain.push($(this).val());
                    });
                    $("#subdomain option:selected").each(function()
                        {
                        // log the value and text of each option
                        subdomain.push($(this).val());
                    });
                    $("#jobrole option:selected").each(function()
                        {
                        // log the value and text of each option
                        job_role.push($(this).val());
                    });
                    $("#month option:selected").each(function()
                        {
                        // log the value and text of each option
                        month.push($(this).val());
                    });
                    $("#metaactivity option:selected").each(function()
                        {
                        // log the value and text of each option
                        meta_activity.push($(this).val());
                    });

                    employeeActivityTable.ajax.reload();
                    projectActivityTable.ajax.reload();
                }
            );
            
            employeeActivityTable = $('#employeeActivityTable').DataTable({
                ajax: {
                        url: "{!! route('ajaxactivityperemployee') !!}",
                        type: "POST",
                        data: ajaxData,
                        dataType: "JSON"
                    },
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

            projectActivityTable = $('#projectActivityTable').DataTable( {
                ajax: {
                        "url": "{!! route('ajaxactivityperproject') !!}",
                        "type": "POST",
                        data: ajaxData,
                        dataType: "JSON"
                },
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
                        "targets": [ 4 ],
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