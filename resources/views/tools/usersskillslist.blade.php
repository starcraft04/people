@extends('layouts.app')

@section('style')
    <!-- CSS -->
    <!-- DataTables -->
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
    

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

    <!-- Bootbox -->
    <script src="{{ asset('/plugins/bootbox/bootbox.min.js') }}"></script>
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Users skills</h3>
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
        <h2>List</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="skill-tab" role="tab" data-toggle="tab" aria-expanded="true">Skills</a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2" id="certification-tab" role="tab" data-toggle="tab" aria-expanded="false">Certifications</a>
                </li>
            </ul>

            <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="skill-tab">
                    <table id="skillTable" class="table table-striped table-hover table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Domain</th>
                                <th>Sub Domain</th>
                                <th>technology</th>
                                <th>Skill</th>
                                <th>Manager Name</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Region</th>
                                <th>Country</th>
                                <th>Role</th>
                                <th>Type</th>
                                <th>Rating</th>
                                <th>Skill ID</th>
                                <th><button class="buttonCreate btn btn-success"><span class="glyphicon glyphicon-plus"></span></button>
                                </th>
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
                                <th class="last_column"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="certification-tab">
                    <table id="certificationTable" class="table table-striped table-hover table-bordered mytable" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Domain</th>
                                <th>Sub Domain</th>
                                <th>technology</th>
                                <th>Certification</th>
                                <th>Manager Name</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Region</th>
                                <th>Country</th>
                                <th>Role</th>
                                <th>Type</th>
                                <th>Rating</th>
                                <th>Skill ID</th>
                                <th><button class="buttonCreate btn btn-success"><span class="glyphicon glyphicon-plus"></span></button>
                                </th>
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
                                <th class="last_column"></th>
                            </tr>
                        </tfoot>
                    </table>
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
        var skillTable;
        var certificationTable;
        var record_id;

        //console.log(permissions);


        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            skillTable = $('#skillTable').DataTable({
                serverSide: true,
                processing: true,
                stateSave: true,
                ajax: {
                        url: "{!! route('listOfUsersSkills',['0']) !!}",
                        type: "POST",
                        dataType: "JSON"
                    },
                columns: [
                    { name: 'skill_user.id', data: 'id', searchable: false , visible: false },
                    { name: 'skills.domain', data: 'domain', searchable: true , visible: true },
                    { name: 'skills.subdomain', data: 'subdomain', searchable: true , visible: true },
                    { name: 'skills.technology', data: 'technology', searchable: true , visible: true },
                    { name: 'skills.skill', data: 'skill', searchable: true , visible: true },
                    { name: 'm.name', data: 'manager_name', searchable: true , visible: false },
                    { name: 'u.name', data: 'user_name', searchable: true , visible: true },
                    { name: 'u.email', data: 'user_email', searchable: true , visible: true },
                    { name: 'u.region', data: 'region', searchable: true , visible: false },
                    { name: 'u.country', data: 'country', searchable: true , visible: false },
                    { name: 'u.job_role', data: 'job_role', searchable: true , visible: false },
                    { name: 'u.employee_type', data: 'employee_type', searchable: true , visible: false },
                    { name: 'skill_user.rating', data: 'rating', searchable: true , visible: true },
                    { name: 'skills.id', data: 'skill_id', searchable: false , visible: false },
                    {
                        name: 'actions',
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function (data) {
                            var actions = '';
                            actions += '<div class="btn-group btn-group-xs">';
                            if (data.user_name) {
                                actions += '<button id="'+data.id+'" class="buttonUpdate btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></button>';
                            }
                            if (data.user_name) {
                            actions += '<button id="'+data.id+'" class="buttonDelete btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>';
                            }
                            actions += '</div>';
                            return actions;
                        },
                        width: '70px'
                    }
                    ],
                order: [[5, 'asc'],[1, 'asc'],[2, 'asc'],[3, 'asc'],[4, 'asc']],
                lengthMenu: [
                    [ 10, 25, 50, -1 ],
                    [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                    extend: "colvis",
                    className: "btn-sm",
                    columns: [ 1,2,3,4,5,6,7,8,9,10,11,12 ]
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
                    var state = skillTable.state.loaded();
                    if (state) {
                        skillTable.columns().eq(0).each(function (colIdx) {
                            var colSearch = state.columns[colIdx].search;

                            if (colSearch.search) {
                                $('input', skillTable.column(colIdx).footer()).val(colSearch.search);
                            }
                        });

                        skillTable.draw();
                    }
                }
            });

            certificationTable = $('#certificationTable').DataTable({
                serverSide: true,
                processing: true,
                stateSave: true,
                ajax: {
                        url: "{!! route('listOfUsersSkills',['1']) !!}",
                        type: "POST",
                        dataType: "JSON"
                    },
                columns: [
                    { name: 'skill_user.id', data: 'id', searchable: false , visible: false },
                    { name: 'skills.domain', data: 'domain', searchable: true , visible: true },
                    { name: 'skills.subdomain', data: 'subdomain', searchable: true , visible: true },
                    { name: 'skills.technology', data: 'technology', searchable: true , visible: true },
                    { name: 'skills.skill', data: 'skill', searchable: true , visible: true },
                    { name: 'm.name', data: 'manager_name', searchable: true , visible: false },
                    { name: 'u.name', data: 'user_name', searchable: true , visible: true },
                    { name: 'u.email', data: 'user_email', searchable: true , visible: true },
                    { name: 'u.region', data: 'region', searchable: true , visible: false },
                    { name: 'u.country', data: 'country', searchable: true , visible: false },
                    { name: 'u.job_role', data: 'job_role', searchable: true , visible: false },
                    { name: 'u.employee_type', data: 'employee_type', searchable: true , visible: false },
                    { name: 'skill_user.rating', data: 'rating', searchable: false , visible: false },
                    { name: 'skills.id', data: 'skill_id', searchable: false , visible: false },
                    {
                        name: 'actions',
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function (data) {
                            var actions = '';
                            actions += '<div class="btn-group btn-group-xs">';
                            if (data.user_name) {
                            actions += '<button id="'+data.id+'" class="buttonDelete btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>';
                            }
                            actions += '</div>';
                            return actions;
                        },
                        width: '70px'
                    }
                    ],
                order: [[5, 'asc'],[1, 'asc'],[2, 'asc'],[3, 'asc'],[4, 'asc']],
                lengthMenu: [
                    [ 10, 25, 50, -1 ],
                    [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                    extend: "colvis",
                    className: "btn-sm",
                    columns: [ 1,2,3,4,5,6,7,8,9,10,11,12 ]
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
                    var state = certificationTable.state.loaded();
                    if (state) {
                        certificationTable.columns().eq(0).each(function (colIdx) {
                            var colSearch = state.columns[colIdx].search;

                            if (colSearch.search) {
                                $('input', certificationTable.column(colIdx).footer()).val(colSearch.search);
                            }
                        });

                        certificationTable.draw();
                    }
                }
            });

            $(document).on('click', '.buttonCreate', function () {
                window.location.href = "{!! route('userskillFormCreate','') !!}";
            } );

            $(document).on('click', '.buttonUpdate', function () {
                window.location.href = "{!! route('userskillFormUpdate','') !!}/"+this.id;
            } );

            $(document).on('click', '.buttonDelete', function () {
                record_id = this.id;
                bootbox.confirm("Are you sure want to delete this record?", function(result) {
                    if (result){
                        $.ajax({
                            type: 'get',
                            url: "{!! route('userskillDelete','') !!}/"+record_id,
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
                                skillTable.ajax.reload();
                                certificationTable.ajax.reload();
                            }
                        });
                    }
                });
            } );
            
        } );

    </script>
@stop
