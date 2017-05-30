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
            <h3 class="box-title">Employee skill</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box-tools -->
        </div>

        <div class="box-body">
            <table id="employeeSkillTable" class="display table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Skill ID</th>
                        <th>Skill Type</th>
                        <th>Skill Category</th>
                        <th>Skill</th>
                        <th>Rank</th>
                        <th>Target Rank</th>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Domain</th>
                        <th>Sub Domain</th>
                        <th>Job Role</th>
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
        var employeeSkillTable;


        function ajaxData(){
            var obj = {
                'domain[]': domain,
                'subdomain[]': subdomain,
                'job_role[]': job_role
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
            
            $("#update").click(function()
                {
                    domain = [];
                    subdomain = [];
                    job_role = [];
                
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

                    employeeSkillTable.ajax.reload();
                }
            );
            
            employeeSkillTable = $('#employeeSkillTable').DataTable({
                ajax: {
                        url: "{!! route('ajaxskillperemployee') !!}",
                        type: "POST",
                        data: ajaxData,
                        dataType: "JSON"
                    },
                columns: [
                    { data: 'skill_id', name: 'skill_id' },
                    { data: 'skill_type', name: 'skill_type' },
                    { data: 'skill_category_name', name: 'skill_category_name' },
                    { data: 'skill', name: 'skill' },
                    { data: 'rank', name: 'rank' },
                    { data: 'target_rank', name: 'target_rank' },
                    { data: 'employee_id', name: 'employee_id' },
                    { data: 'employee_name', name: 'employee_name' },
                    { data: 'domain', name: 'domain' },
                    { data: 'subdomain', name: 'subdomain' },
                    { data: 'job_role', name: 'job_role' },
                    ],
                columnDefs: [
                    {
                        "targets": [ 0,1,6,8,9,10 ],
                        "visible": false,
                        "searchable": false
                    }
                    ]
            } );
            
            $('#employeeSkillTable').on( 'click', 'tr', function () {
                var rowData = employeeSkillTable.row(this).data();
                var employee_id = rowData.employee_id;
                window.location.href = "{!! route('employee') !!}/"+employee_id;
            } );
            
        } );
    </script> 
@stop