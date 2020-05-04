@extends('layouts.app')

@section('style')
<!-- CSS -->
<!-- Switchery -->
<link href="{{ asset('/plugins/gentelella/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
<!-- Select2 -->
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/css/forms.css') }}" rel="stylesheet" />
<!-- DataTables -->
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
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
<!-- Switchery -->
<script src="{{ asset('/plugins/gentelella/vendors/switchery/dist/switchery.min.js') }}" type="text/javascript"></script>
<!-- Select2 -->
<script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
<!-- DataTables -->
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/buttons.colVis.min.js') }}" type="text/javascript"></script>
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
    <h3>Prime upload</h3>
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
        <h2>Form</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
          {!! Form::open(['url' => 'otlupload', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}

          <div class="row">
            <div class="form-group col-md-12">
              <div class="col-md-2">
                {!! Form::label('sample', 'Sample file', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-8">
                Download <a href="{{ asset('/Samples/otl_upload_sample.xls') }}" style="text-decoration: underline;">this file (.xls)</a> to get the structure needed for CTV.</br>
                Download <a href="{{ asset('/Samples/prime_upload_sample.csv') }}" style="text-decoration: underline;">this file (.csv)</a> to get the structure needed for Prime.</br> Click
                <a href="{{route('otluploadhelp')}}" style="text-decoration: underline;">here</a> for help.
              </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group {!! $errors->has('uploadfile') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-2">
                {!! Form::label('uploadfile', 'Prime excel file', ['class' => 'control-label']) !!}
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
@if (isset($messages))
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
        <div class="row">
          <div class="col-md-12">
            Attention, when you have finished adding the projects in dolphin, you will need to reupload the excel file for the changes to be taken into account...
          </div>
        </div>
        <table id="error_table" class="table table-striped table-hover table-bordered mytable" width="100%">
          <thead>
            <tr>
              <th>Manager</th>
              <th>User</th>
              <th>Prime code</th>
              <th>Meta</th>
              <th>Message</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          @foreach($messages as $key => $project)
            <tr data-row_id="{{ $key }}">
              <td>@if(isset($project['mgr'])){!! $project['mgr'] !!}@endif</td>
              <td class="table_user">@if(isset($project['user'])){!! $project['user'] !!}@endif</td>
              <td class="table_prime_code">@if(isset($project['prime_code'])){!! $project['prime_code'] !!}@endif</td>
              <td class="table_meta">@if(isset($project['meta'])){!! $project['meta'] !!}@endif</td>
              <td>@if(isset($project['msg'])){!! $project['msg'] !!}@endif</td>
              <td class="buttonHolder">@if(isset($project['msg']) && strpos($project['msg'], 'Prime') !== false)<button type="button" class="btn btn-info btn-xs new_project"><span class="glyphicon glyphicon-plus"></span></button>@endif</td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>

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
                  Select from the list below for user <span id="table_user_modal">test</span> to add the Prime code to the project selected
                </div>
              </div>
              <div class="form-group">
                  <label  class="control-label" for="year_modal">Year</label>
                  <div>
                    <select class="form-control select2" style="width: 100%;" name="year_modal" data-placeholder="Select a year">
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
              <table id="user_project_table" class="table table-striped table-hover table-bordered mytable" width="100%">
                <thead>
                  <tr>
                    <th>Customer name</th>
                    <th>Project name</th>
                    <th>Project type</th>
                    <th>Project status</th>
                    <th>Prime code</th>
                    <th>Meta activity</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
              </BR>
              <h3>OR</h3>
              </BR>
              <h4>Create new project</h4>
              <div class="row">
                <div class="col-sm-11">
                  Fill in the information then click create
                </div>
              </div>
              <div class="row">
                <div class="col-sm-11">
                  Prime code: <span id="prime_code_text_modal"></span>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-11">
                  Meta: <span id="meta_text_modal"></span>
                </div>
              </div>
              <form id="form_addProject_modal" role="form" method="POST" action="">
                <div class="form-group">
                  <label id="label_project_name" class="control-label" for="form_addProject_project_name_modal">Project name *</label>
                  <div>
                      <input type="text" name="form_addProject_project_name_modal" class="form-control" placeholder="Project name"></input>
                  </div>
                </div>
                <div class="form-group">
                  <label id="label_customer_name" class="control-label" for="form_addProject_customer_name_modal">Customer name *</label>
                  <div>
                    <select class="form-control select2" style="width: 100%;" name="form_addProject_customer_name_modal" data-placeholder="Select a location">
                        <option value="" ></option>
                        @foreach($customers_list as $key => $value)
                        <option value="{{ $key }}">
                          {{ $value }}
                        </option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label  class="control-label" for="form_addProject_project_type_modal">Project type</label>
                  <div>
                    <select class="form-control select2" style="width: 100%;" name="form_addProject_project_type_modal" data-placeholder="Select a location">
                        <option value="" ></option>
                        @foreach(config('select.project_type') as $key => $value)
                        <option value="{{ $key }}">
                          {{ $value }}
                        </option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label  class="control-label" for="form_addProject_project_status_modal">Project status</label>
                  <div>
                    <select class="form-control select2" style="width: 100%;" name="form_addProject_project_status_modal" data-placeholder="Select a location">
                        <option value="" ></option>
                        @foreach(config('select.project_status') as $key => $value)
                        <option value="{{ $key }}">
                          {{ $value }}
                        </option>
                        @endforeach
                    </select>
                  </div>
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

@stop

@section('script')
  <script>
    var error_table;

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

      //region table with results from upload
      error_table = $('#error_table').DataTable({
        serverSide: false,
        scrollX: true,
        responsive: false,
        order: [[0,1, 'asc']],
        lengthMenu: [
                    [ 25, 50, -1 ],
                    [ '10', '25', '50', 'all' ]
                ],
        dom: 'Bfrtip',
        buttons: [
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
          }
        ],
      });
      //endregion

      //region Adding new project modal
      // Function to load the table with all the projects
      function loadProjects(user,year) {
        $.ajax({
          url: "{!! route('listOfProjectsNotUsedInPrimeAjax',['','']) !!}"+'/'+user+'/'+year,
          type: "GET",
          success:function(data){
            //console.log(data);
            var body_of_table = $("#user_project_table").find("tbody");
            body_of_table.empty();
            data.forEach(function (item, index) { 
              var markup = "";
              markup += '<tr>';
              markup += '<td>'+(item['customer_name'] || "")+'</td>';
              markup += '<td>'+(item['project_name'] || "")+'</td>';
              markup += '<td>'+(item['project_type'] || "")+'</td>';
              markup += '<td>'+(item['project_status'] || "")+'</td>';
              markup += '<td>'+(item['prime_code'] || "")+'</td>';
              markup += '<td>'+(item['meta_activity'] || "")+'</td>';
              markup += '<td>';  
              markup += '<button type="button" data-project_id="'+item['project_id']+'" class="buttonProjecttEdit btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></button>';
              markup += '</td>';
              markup += '</tr>';
              body_of_table.append(markup);
            });
          }
        });
      };

      // Year change in modal
      $('select[name="year_modal"]').on('change', function() {
        year = $(this).val();
        user = $(this).attr("data-user_name");
        loadProjects(user,year);
      });

      // Click plus button from Prime upload result
      $(document).on('click', '.new_project', function () {
        // Getting the info from the row
        user = $(this).closest('tr').children("td.table_user").text();
        prime_code = $(this).closest('tr').children("td.table_prime_code").text();
        meta = $(this).closest('tr').children("td.table_meta").text();
        row_id = $(this).closest('tr').attr("data-row_id");
        year = $('select[name="year_modal"] option:selected').val();
        // Setting user in the year select
        $('select[name="year_modal"]').attr("data-user_name",user);

        // init Project from user table
        loadProjects(user,year);

        // init form
        $('span#table_user_modal').text(user);
        $('span#prime_code_text_modal').text(prime_code);
        $('span#meta_text_modal').text(meta);
        $('#addProject_hidden').empty();
        var hidden = '';
        hidden += '<input class="form-control" name="table_user" type="hidden" value="'+user+'">';
        hidden += '<input class="form-control" name="table_prime_code" type="hidden" value="'+prime_code+'">';
        hidden += '<input class="form-control" name="table_meta" type="hidden" value="'+meta+'">';
        hidden += '<input class="form-control" name="table_row_id" type="hidden" value="'+row_id+'">';
        $('#addProject_hidden').append(hidden);
        $('#label_project_name').removeClass('label_error');
        $('#label_customer_name').removeClass('label_error');

        // Setting input values with info from Prime file upload
        $('input[name="form_addProject_project_name_modal"]').val(prime_code);
        $('select[name="form_addProject_customer_name_modal"]').val('');
        $('select[name="form_addProject_customer_name_modal"]').select2().trigger('change');
        if (meta == 'BILLABLE') {
          $('select[name="form_addProject_project_type_modal"]').val('Project');
          $('select[name="form_addProject_project_type_modal"]').select2().trigger('change');
          $('select[name="form_addProject_project_status_modal"]').val('Started');
          $('select[name="form_addProject_project_status_modal"]').select2().trigger('change');
        } else if (meta == 'OTHER') {
          $('select[name="form_addProject_project_type_modal"]').val('Pre-sales');
          $('select[name="form_addProject_project_type_modal"]').select2().trigger('change');
          $('select[name="form_addProject_project_status_modal"]').val('');
          $('select[name="form_addProject_project_status_modal"]').select2().trigger('change');
        }

        $('#addProjectModal').modal();
      });

      // Click edit button in modal
      $(document).on('click', '.buttonProjecttEdit', function () {
        // project id from button
        project_id = $(this).attr('data-project_id');
        // hidden input
        prime_code = $('input[name=table_prime_code]').val();
        meta = $('input[name=table_meta]').val();
        var row_id = $('input[name=table_row_id]').val();

        data = {
          'prime_code':prime_code,'meta':meta,'project_id':project_id
        }

        $.ajax({
          url: "{!! route('editProjectFromPrimeUpload') !!}",
          type: "POST",
          data: data,
          dataType: "JSON",
          success:function(data){
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
            if (data.result == 'success'){
              //console.log(row_id);
              $('tr[data-row_id="'+row_id+'"] td.buttonHolder').empty();
              $('tr[data-row_id="'+row_id+'"] td.buttonHolder').append('Added');
              $('#addProjectModal').modal('hide');
            }
          }
        });
      });

      // Click create button in modal
      $(document).on('click', '#addProject_create_button_modal', function () {
        
        // hidden input
        prime_code = $('input[name=table_prime_code]').val();
        meta = $('input[name=table_meta]').val();
        row_id = $('input[name=table_row_id]').val();
        // filled in
        project_name = $('input[name="form_addProject_project_name_modal"]').val();
        customer_id = $('select[name="form_addProject_customer_name_modal"] option:selected').val();
        project_type = $('select[name="form_addProject_project_type_modal"] option:selected').val();
        project_status = $('select[name="form_addProject_project_status_modal"] option:selected').val();

        data = {
          'prime_code':prime_code,'meta':meta,'project_name':project_name,'customer_id':customer_id,'project_type':project_type,'project_status':project_status
        }

        $.ajax({
          url: "{!! route('createProjectFromPrimeUpload') !!}",
          type: "POST",
          data: data,
          dataType: "JSON",
          success:function(data){
            //console.log(data);
            if (data.result == 'success'){
                box_type = 'success';
                message_type = 'success';
            }
            else {
                $('#label_project_name').addClass('label_error');
                $('#label_customer_name').addClass('label_error');
                box_type = 'danger';
                message_type = 'error';
            }

            $('#flash-message').empty();
            var box = $('<div id="delete-message" class="alert alert-'+box_type+' alert-dismissible flash-'+message_type+'" role="alert"><button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>'+data.msg+'</div>');
            $('#flash-message').append(box);
            $('#delete-message').delay(2000).queue(function () {
                $(this).addClass('animated flipOutX')
            });
            if (data.result == 'success'){
              //console.log(row_id);
              $('tr[data-row_id="'+row_id+'"] td.buttonHolder').empty();
              $('tr[data-row_id="'+row_id+'"] td.buttonHolder').append('Added');
              $('#addProjectModal').modal('hide');
            }
          }
        });
      });
      //endregion
    
    });
  </script>
@stop