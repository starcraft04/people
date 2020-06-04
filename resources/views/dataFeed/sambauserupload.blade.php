@extends('layouts.app')

@section('style')
<!-- CSS -->
<!-- Select2 -->
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/css/forms.css') }}" rel="stylesheet" />
<!-- DataTables -->
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('/css/datatables.css') }}">
<!-- Loader -->
<link href="{{ asset('/css/loader.css') }}" rel="stylesheet">
<!-- Document styling -->
<style>
h3 {
  overflow: hidden;
  text-align: center;
}

h3:before,
h3:after {
  background-color: #000;
  content: "";
  display: inline-block;
  height: 1px;
  position: relative;
  vertical-align: middle;
  width: 50%;
}

h3:before {
  right: 0.5em;
  margin-left: -50%;
}

h3:after {
  left: 0.5em;
  margin-right: -50%;
}
.label_error {
  color: red;
}
</style>
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
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>CL user synch</h3>
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
        <h2>Form</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
          {!! Form::open(['url' => 'sambauserupload', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}

          <div class="row">
            <div class="form-group {!! $errors->has('uploadfile') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-2">
                {!! Form::label('uploadfile', 'CL excel file', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-10">
                {!! Form::file('uploadfile', ['class' => 'form-control']) !!}
                {!! $errors->first('uploadfile', '<small class="help-block">:message</small>') !!}
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-offset-11 col-md-1">
              {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
            </div>
          </div>
          {!! Form::close() !!}
      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->

<!-- Window -->
@if (isset($create_records) && $create_records)
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window title -->
      <div class="x_title">
        <h2>Create records</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <div class="loader" id="loader-6">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
        </br>
        <table id="samba_table" class="table table-striped table-hover table-bordered mytable" width="100%" style="display: none;">
          <thead>
            <tr>
              <th>Action</th>
              <th>Cluster</th>
              <th>Customer (CL)</th>
              <th>Customer ID (dolphin)</th>
              <th>Customer (dolphin)</th>
              <th>Project name</th>
              <th>Assigned User ID</th>
              <th>Assigned User</th>
              <th>CL ID</th>
              <th>Created date</th>
              <th>Close date</th>
              <th>CL stage</th>
              <th>Order Intake (€)</th>
            </tr>
          </thead>
          <tbody id="table_content">
          @foreach($ids as $key => $project)
            <tr class="item {!! $project['color'] !!}">
              <td>
                @if($project['user_id'] == 0)
                  <button type="button" id="button_user_{{ $project['public_opportunity_id'] }}" class="btn btn-warning btn-xs add_user"><span class="glyphicon glyphicon-plus"></span></button>
                @elseif(!$project['user_assigned'])
                  <button type="button" id="button_{{ $project['public_opportunity_id'] }}" class="btn btn-info btn-xs add_samba"><span class="glyphicon glyphicon-plus"></span></button>
                @endif
              </td>
              <td class="owners_sales_cluster">{!! $project['owners_sales_cluster'] !!}</td>
              <td class="account_name">{!! $project['account_name'] !!}</td>
              <td>{!! $project['account_name_modified_id'] !!}</td>
              <td>{!! $project['account_name_modified'] !!}</td>
              <td class="opportunity_name">{!! $project['opportunity_name'] !!}</td>
              <td class="user_id">{{ $project['user_id'] }}</td>
              <td class="users_name" style="width: 200px;">{{ $project['user_name'] }}</td>
              <td class="public_opportunity_id">@if($project['user_id'] != 0){!! $project['public_opportunity_id'] !!}@endif</td>
              <td class="created_date">{!! $project['created_date'] !!}</td>
              <td class="close_date">{!! $project['close_date'] !!}</td>
              <td class="stage">{!! $project['stage'] !!}</td>
              <td class="amount_tcv">{!! $project['amount_tcv'] !!}</td>
            </tr>
          @endforeach
          </tbody>
          <tfoot>
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
          </tfoot>
        </table>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="addUserModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="display:table;">
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add user link from CL user</h4>
            </div>
            <!-- Modal Header -->
              
            <!-- Modal Body -->
            <div class="modal-body">            
              <form id="form_addUser_modal" role="form" method="POST" action="">
                <div id="modal_addUser_formgroup_user_id" class="form-group">
                  <label class="control-label" for="form_addUser_user_name_modal">User in CL: <span id="user_name_title_addUserModal"></span></label>
                  <select class="form-control select2" id="form_addUser_user_name_modal" name="form_addUser_user_name_modal" style="width: 100%;" data-placeholder="Select a user">
                    <option value="">
                    </option>
                    @foreach($users_select as $key => $value)
                    <option value="{{ $key }}">
                      {{ $value }}
                    </option>
                    @endforeach
                  </select>
                  <span id="modal_addUser_form_user_id_error" class="help-block"></span>
                </div>
                <div class="form-group">
                  <div id="addUser_hidden">
                  </div>
                </div>
              </form>  
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="addUser_create_button_modal" class="btn btn-success">Create</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal -->

      <!-- Modal -->
      <div class="modal fade" id="addProjectModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="display:table;">
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add project</h4>
            </div>
            <!-- Modal Header -->
              
            <!-- Modal Body -->
            <div class="modal-body">
              <h4>Update existing project</h4>
              <div class="row">
                <div class="col-sm-11">
                  Select from the project below where your team is working to add to the project selected
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4">
                  Customer: <span id="customer_name_title_modal"></span>
                </div>
                <div class="col-sm-4">
                  Project: <span id="project_name_title_modal"></span>
                </div>
                <div class="col-sm-4">
                  CL ID: <span id="CL_ID_title_modal"></span>
                </div>
              </div>
              
              <div class="form-group">
                  <label  class="control-label" for="year_modal">Year</label>
                  <div>
                    <select class="form-control select2" style="width: 100%;" id="year_modal" name="year_modal" data-placeholder="Select a year">
                        @foreach(config('select.year') as $key => $value)
                        <option value="{{ $key }}"
                          @if (date('Y') == $key) selected
                          @endif
                        >
                          {{ $value }}
                        </option>
                        @endforeach
                    </select>
                  </div>
                </div>
              <table id="project_table" class="table table-striped table-hover table-bordered mytable" width="100%">
                <thead>
                  <tr>
                    <th>Customer name</th>
                    <th>Project id</th>
                    <th>Project name</th>
                    <th>User</th>
                    <th>Project type</th>
                    <th>Project status</th>
                    <th>CL ID</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
              </BR></BR></BR>
              <h3>OR</h3>
              </BR>
              <h4>Create new project</h4>
              <div class="row">
                <div class="col-sm-11">
                  Fill in the information then click create
                </div>
              </div>
              <form id="form_addProject_modal" role="form" method="POST" action="">
                <div id="modal_action_formgroup_project_name" class="form-group">
                  <label id="label_project_name" class="control-label" for="form_addProject_project_name_modal">Project name *</label>
                  <input type="text" id="form_addProject_project_name_modal" name="form_addProject_project_name_modal" class="form-control" placeholder="Project name"></input>
                  <span id="modal_action_form_project_name_error" class="help-block"></span>
                </div>
                <div id="modal_action_formgroup_customer_id" class="form-group">
                  <label id="label_customer_name" class="control-label" for="form_addProject_customer_name_modal">Customer name (CL customer name: <span id="form_customer_title_modal"></span>) *</label>
                  <select class="form-control select2" id="form_addProject_customer_name_modal" name="form_addProject_customer_name_modal" style="width: 100%;" data-placeholder="Select a customer name">
                    @foreach($customers_list as $key => $value)
                    <option value="{{ $key }}">
                      {{ $value }}
                    </option>
                    @endforeach
                  </select>
                  <span id="modal_action_form_customer_id_error" class="help-block"></span>
                </div>
                <div id="modal_action_formgroup_user_id" class="form-group">
                  <label id="label_user_name" class="control-label" for="form_addProject_user_name_modal">Assign to user *</label>
                  <select class="form-control select2" id="form_addProject_user_name_modal" name="form_addProject_user_name_modal" style="width: 100%;" data-placeholder="Select a user">
                    <option value="">
                    </option>
                    @foreach($users_select as $key => $value)
                    <option value="{{ $key }}">
                      {{ $value }}
                    </option>
                    @endforeach
                  </select>
                  <span id="modal_action_form_user_id_error" class="help-block"></span>
                </div>
                <div class="form-group">
                  <div id="addProject_hidden">
                  </div>
                </div>
              </form>  
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="addProject_create_button_modal" class="btn btn-success">Create</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal -->
      <!-- Window content -->

    </div>
  </div>
</div>
@endif
<!-- Window -->

<!-- Window -->
@if (isset($messages) && !isset($create_records))
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window title -->
      <div class="x_title">
        <h2>Results
        </h2>

        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <br />
          <div class="text-danger"><H2>Errors</H2></div>
          </BR>
          @foreach($messages_only_errors as $m)
          <div class="row">
            <div class="col-md-1 text-danger">
              {!! $m['status'] !!}
            </div>
            <div class="col-md-offset-1 col-md-10 {!! isset($color[$m['status']]) ? $color[$m['status']] : '' !!}">
              {!! isset($m['msg']) ? $m['msg'] : '' !!}
            </div>
          </div>
          @endforeach
      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
@endif
<!-- Window -->

@stop

@section('script')
  <script>

    var cluster;
    var samba_lead_domain;
    var customer_samba;
    var customer_dolphin;
    var project_name;
    var assigned_user;
    var samba_id;
    var opportunity_owner;
    var create_date;
    var close_date;
    var samba_stage;
    var win_ratio;
    var order_intake;
    var consulting_tcv;
    var array_of_data = [];
    var samba_table;
    var year;

    @if (isset($create_records) && $create_records)
      $(document).ready(function() {
        //region Page setup
        //CSRF for ajax
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        // This code will make any modal window draggable
        $(".modal-header").on("mousedown", function(mousedownEvt) {
          var $draggable = $(this);
          var x = mousedownEvt.pageX - $draggable.offset().left,
              y = mousedownEvt.pageY - $draggable.offset().top;
          $("body").on("mousemove.draggable", function(mousemoveEvt) {
              $draggable.closest(".modal-dialog").offset({
                  "left": mousemoveEvt.pageX - x,
                  "top": mousemoveEvt.pageY - y
              });
          });
          $("body").one("mouseup", function() {
              $("body").off("mousemove.draggable");
          });
          $draggable.closest(".modal").one("bs.modal.hide", function() {
              $("body").off("mousemove.draggable");
          });
        });
        //endregion

        //region Init select2 boxes
        $(".select2").select2({
          allowClear: false
        });
        //endregion

        $('#samba_table').show();
        $('#loader-6').hide();


        samba_table = $('#samba_table').DataTable({
          scrollX: true,
          @if(isset($table_height))
          scrollY: '{!! $table_height !!}vh',
          scrollCollapse: true,
          @endif
          stateSave: true,
          order: [[0, 'asc']],
          columns: [
              { name: 'action', data: 'null' , searchable: false , visible: true},
              { name: 'owners_sales_cluster', data: 'owners_sales_cluster' , searchable: true , visible: true},
              { name: 'account_name', data: 'account_name' , searchable: true , visible: true},
              { name: 'account_name_modified_id', data: 'account_name_modified_id' , searchable: false , visible: false},
              { name: 'account_name_modified', data: 'account_name_modified' , searchable: false , visible: false},
              { name: 'opportunity_name', data: 'opportunity_name' , searchable: true , visible: true},
              { name: 'user_id', data: 'user_id' , searchable: false , visible: false},
              { name: 'users_name', data: 'users_name' , searchable: true , visible: true},
              { name: 'public_opportunity_id', data: 'public_opportunity_id' , searchable: true , visible: true},
              { name: 'created_date', data: 'created_date' , searchable: true , visible: false},
              { name: 'close_date', data: 'close_date' , searchable: true , visible: false},
              { name: 'stage', data: 'stage' , searchable: true , visible: true},
              { name: 'amount_tcv', data: 'amount_tcv' , searchable: true , visible: true},
            ],
          lengthMenu: [
              [ 10, 25, 50, -1 ],
              [ '10 rows', '25 rows', '50 rows', 'Show all' ]
          ],
          dom: 'Bfrtip',
          buttons: [
            {
              extend: "colvis",
              className: "btn-sm",
              columns: [1,2,5,7,8,9,10,11,12]
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
              };
            });
          }
        });

        // Click plus button from CL upload result for new user link
        $(document).on('click', '.add_user', function () {
          var table = samba_table;
          var tr = $(this).closest('tr');
          var row = table.row(tr);

          // Getting the info from the row
          var cl_user_name = row.data().users_name;
          var button_id = $(this).attr('id');
          //console.log(year);

          // Clean all select
          $("#form_addUser_user_name_modal").val('');
          $("#form_addUser_user_name_modal").select2().trigger('change');

          // init form
          $('span#user_name_title_addUserModal').text(cl_user_name);

          $('#addUser_hidden').empty();
          var hidden = '';
          hidden += '<input class="form-control" id="cl_user_name_hidden" name="customer_cl" type="hidden" value="'+cl_user_name+'">';
          hidden += '<input class="form-control" id="button_id_user_hidden" name="button_id" type="hidden" value="'+button_id+'">';

          $('#addUser_hidden').append(hidden);
          
          modal_form_user_error_clean();
          $('#addUserModal').modal();
        });

        

        // Click plus button from CL upload result
        $(document).on('click', '.add_samba', function () {
          var table = samba_table;
          var tr = $(this).closest('tr');
          var row = table.row(tr);

          // Getting the info from the row
          var customer_cl = row.data().account_name;
          var customer_dolphin = row.data().account_name_modified;
          var customer_dolphin_id = row.data().account_name_modified_id;
          var user_dolphin_id = row.data().user_id;
          var project_name = row.data().opportunity_name;
          var cl_id = row.data().public_opportunity_id;
          var button_id = $(this).attr('id');
          //console.log(customer_dolphin_id);

          // Clean all select
          $("#form_addProject_customer_name_modal").val('');
          $("#form_addProject_customer_name_modal").select2().trigger('change');
          $("#form_addProject_user_name_modal").val('');
          $("#form_addProject_user_name_modal").select2().trigger('change');

          // init form
          $('span#customer_name_title_modal').text(customer_cl);
          $('span#project_name_title_modal').text(project_name);
          $('span#CL_ID_title_modal').text(cl_id);
          $('span#form_customer_title_modal').text(customer_cl);
          $('input#form_addProject_project_name_modal').val(project_name);
          if (customer_dolphin_id != 0) {
            $("#form_addProject_customer_name_modal").val(customer_dolphin_id);
            $("#form_addProject_customer_name_modal").select2().trigger('change');
          }
          if (user_dolphin_id != 0) {
            $("#form_addProject_user_name_modal").val(user_dolphin_id);
            $("#form_addProject_user_name_modal").select2().trigger('change');
          }

          $('#addProject_hidden').empty();
          var hidden = '';
          hidden += '<input class="form-control" id="cl_id_hidden" name="cl_id" type="hidden" value="'+cl_id+'">';
          hidden += '<input class="form-control" id="cl_user_id_hidden" name="cl_id" type="hidden" value="'+user_dolphin_id+'">';
          hidden += '<input class="form-control" id="customer_cl_hidden" name="customer_cl" type="hidden" value="'+customer_cl+'">';
          hidden += '<input class="form-control" id="button_id_hidden" name="button_id" type="hidden" value="'+button_id+'">';

          $('#addProject_hidden').append(hidden);
          
          modal_form_error_clean();
          user_id = $("#cl_user_id_hidden").val();
          projectTable.ajax.url("{!! route('listOfProjectsNotUsedInCLAjax',['','']) !!}"+'/'+year+'/'+user_id).load();
          $('#addProjectModal').modal();
        });

        $(document).on('click', '.buttonProjectEdit', function () {
          var table = projectTable;
          var tr = $(this).closest('tr');
          var row = table.row(tr);

          var project_id = row.data().project_id;
          var cl_id = $("#cl_id_hidden").val();
          var button_id = $("#button_id_hidden").val();
          //console.log(button_id);

          var data = {'samba_id': cl_id};

          $.ajax({
            type: 'post',
            url: "{!! route('sambaUploadUpdateProject','') !!}/"+project_id,
            data:data,
            dataType: 'json',
            success: function(data) {
              //console.log(data);
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

              $('#addProjectModal').modal('hide');
              td = $("#"+button_id).parent();
              td.empty();
              td.append('Added');
            }
          });
          
        });

        $(document).on('click', '#addProject_create_button_modal', function () {

          var cl_id = $("#cl_id_hidden").val();
          var customer_cl = $("#customer_cl_hidden").val();
          var button_id = $("#button_id_hidden").val();
          var year_modal = $('select#year_modal').children("option:selected").val();
          var project_name = $('input#form_addProject_project_name_modal').val();
          var customer_id = $('select#form_addProject_customer_name_modal').children("option:selected").val();
          var user_id = $('select#form_addProject_user_name_modal').children("option:selected").val();

          var data = {'samba_id': cl_id,'customer_cl': customer_cl,'project_name': project_name,'customer_id': customer_id,'user_id': user_id,'year': year_modal};

          //console.log(data);return;

          $.ajax({
            type: 'post',
            url: "{!! route('sambaUploadCreateProject') !!}",
            data:data,
            dataType: 'json',
            success: function(data) {
              //console.log(data);
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

              $('#addProjectModal').modal('hide');
              td = $("#"+button_id).parent();
              td.empty();
              td.append('Added');
            },
            error: function (data, ajaxOptions, thrownError) {
              modal_form_error_clean();
              var errors = data.responseJSON.errors;
              var status = data.status;

              if (status === 422) {
                $.each(errors, function (key, value) {
                  $('#modal_action_formgroup_'+key).addClass('has-error');
                  $('#modal_action_form_'+key+'_error').text(value);
                });
              } else if (status === 403 || status === 500) {
                $('#modal_action_formgroup_'+key).addClass('has-error');
                $('#modal_action_form_'+key+'_error').text('No Authorization!');
              }
            }
          });
          
        });

        $(document).on('click', '#addUser_create_button_modal', function () {

          var cl_user_name_hidden = $("#cl_user_name_hidden").val();
          var button_id = $("#button_id_user_hidden").val();
          var user_id = $('select#form_addUser_user_name_modal').children("option:selected").val();

          var data = {'cl_user_name': cl_user_name_hidden,'user_id': user_id};

          //console.log(data);return;

          $.ajax({
            type: 'post',
            url: "{!! route('sambaUploadCreateUser') !!}",
            data:data,
            dataType: 'json',
            success: function(data) {
              //console.log(data);
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

              $('#addUserModal').modal('hide');
              td = $("#"+button_id).parent();
              td.empty();
              td.append('Added');
            },
            error: function (data, ajaxOptions, thrownError) {
              modal_form_user_error_clean();
              var errors = data.responseJSON.errors;
              var status = data.status;

              if (status === 422) {
                $.each(errors, function (key, value) {
                  $('#modal_addUser_formgroup_'+key).addClass('has-error');
                  $('#modal_addUser_form_'+key+'_error').text(value);
                });
              } else if (status === 403 || status === 500) {
                $('#modal_addUser_formgroup_'+key).addClass('has-error');
                $('#modal_addUser_form_'+key+'_error').text('No Authorization!');
              }
            }
          });

          });

        function modal_form_error_clean() {
          // Clean all error class
          $("form#form_addProject_modal  div.form-group").each(function(){
            $(this).removeClass('has-error');
          });
          // Clean all error message
          $("form#form_addProject_modal span.help-block").each(function(){
            $(this).empty();
          });
        }
        function modal_form_user_error_clean() {
          // Clean all error class
          $("form#form_addUser_modal  div.form-group").each(function(){
            $(this).removeClass('has-error');
          });
          // Clean all error message
          $("form#form_addUser_modal span.help-block").each(function(){
            $(this).empty();
          });
        }

        year = $('select[name="year_modal"] option:selected').val();
        var projectTable = $('#project_table').DataTable({
              serverSide: true,
              processing: true,
              scrollX: true,
              responsive: false,
              ajax: {
                      url: "{!! route('listOfProjectsNotUsedInCLAjax',['']) !!}"+'/'+year,
                      type: "GET",
                      dataType: "JSON"
                  },
              columns: [
                  { name: 'customers.name', data: 'customer_name' , searchable: true , visible: true },
                  { name: 'projects.id', data: 'project_id' , searchable: false , visible: false },
                  { name: 'projects.project_name', data: 'project_name' , searchable: true , visible: true },
                  { name: 'u.name', data: 'user_name' , searchable: true , visible: true },
                  { name: 'projects.project_type', data: 'project_type' , searchable: true , visible: true },
                  { name: 'projects.project_status', data: 'project_status' , searchable: true , visible: true },
                  { name: 'projects.samba_id', data: 'samba_id' , searchable: true , visible: false },
                  {
                      name: 'actions',
                      data: null,
                      sortable: false,
                      searchable: false,
                      render: function (data) {
                        var actions = '';
                        actions += '<div class="btn-group btn-group-xs">';
                        actions += '<button type="button" class="buttonProjectEdit btn btn-success"><span class="glyphicon glyphicon-pencil"></span></button>';
                        actions += '</div>';
                        return actions;
                      },
                      width: '70px'
                  }
                  ],
              order: [[0, 'asc']],
              lengthMenu: [
                  [ 10, 25, 50, -1 ],
                  [ '10 rows', '25 rows', '50 rows', 'Show all' ]
              ],
              dom: 'Bfrtip',
              buttons: [
                {
                  extend: "colvis",
                  className: "btn-sm",
                  columns: [ 0,2,3,4,5]
                },
                {
                  extend: "pageLength",
                  className: "btn-sm"
                }
              ]   
          });

        // This part is to make sure that datatables can adjust the columns size when it is hidden because of non active tab when created
        $('#addProjectModal').on('shown.bs.modal', function () {
          projectTable.columns.adjust();
        });

        // Year change in modal
        $('select[name="year_modal"]').on('change', function() {
          year = $(this).val();
          user_id = $("#cl_user_id_hidden").val();
          projectTable.ajax.url("{!! route('listOfProjectsNotUsedInCLAjax',['','']) !!}"+'/'+year+'/'+user_id).load();
        });
      });
    @endif
  </script>
@stop
