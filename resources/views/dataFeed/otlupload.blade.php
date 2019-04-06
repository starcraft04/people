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
    <h3>OTL upload</h3>
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
              <div class="col-md-4">
                Download 
                <a href="{{ asset('/Samples/otl_upload_sample.xls') }}" style="text-decoration: underline;">this file</a> to get the structure needed. Click
                <a href="{{route('otluploadhelp')}}" style="text-decoration: underline;">here</a> for help.
              </div>
              <div class="col-md-5"><input name="create_in_db" type="checkbox" id="create_in_db" class="form-group js-switch-small" /> Create new record in DB if no OTL code found</div>
            </div>
          </div>

          <div class="row">
            <div class="form-group {!! $errors->has('uploadfile') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-2">
                {!! Form::label('uploadfile', 'OTL excel file', ['class' => 'control-label']) !!}
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
          @if(isset($create_records) && $create_records)
            <small>Only records where all select boxes are filled in will be added</small>
          @endif
        </h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
          <table id="error_table" class="table table-striped table-hover table-bordered" width="100%">
            <thead>
              <tr>
                <th>Manager</th>
                <th>User</th>
                <th>Customer (Prime)</th>
                <th>Prime code</th>
                <th>Meta</th>
                @if (isset($create_records) && $create_records)
                <th>User projects</th>
                <th>Customer (Dolphin)</th>
                <th>Project name (Dolphin)</th>
                @endif
                <th>Message</th>
              </tr>
            </thead>
            <tbody>
            @foreach($messages as $key => $project)
              <tr>
                <td>@if(isset($project['mgr'])) {!! $project['mgr'] !!} @endif</td>
                <td>@if(isset($project['user'])) {!! $project['user'] !!} @endif</td>
                <td>@if(isset($project['customer_prime'])) {!! $project['customer_prime'] !!} @endif</td>
                <td>@if(isset($project['prime_code'])) {!! $project['prime_code'] !!} @endif</td>
                <td>@if(isset($project['meta'])) {!! $project['meta'] !!} @endif</td>
                @if (isset($create_records) && $create_records)
                <td>
                  @if(isset($project['user_projects']))
                  <select class="user_projects select2" style="width: 200px;" data-placeholder="Select a project">
                    @foreach($project['user_projects'] as $key => $value)
                    <option value="{{ $value['project_id'] }}">
                      {{ $value['customer_name']  }} -- {{ $value['project_name']  }}
                    </option>
                    @endforeach
                  </select>
                  @endif
                </td>
                <td>
                  @if(isset($project['user_projects']))
                  <select class="customers select2" style="width: 100%;" data-placeholder="Select a customer name">
                    @foreach($customers_list as $key => $value)
                    <option value="{{ $key }}" @if ($value == $project['customer_prime']) selected @endif>
                      {{ $value }}
                    </option>
                    @endforeach
                  </select>
                  @endif
                </td>
                <td>
                {!! Form::text('project_name','', ['class' => 'form-control', 'placeholder' => 'Project name']) !!}
                </td>
                @endif
                <td>@if(isset($project['msg'])) {!! $project['msg'] !!} @endif</td>
              </tr>
            @endforeach
            </tbody>
          </table>
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
    var error_table;
    var array_of_data = [];

    // switchery
    var small = document.querySelector('.js-switch-small');
    var switchery = new Switchery(small, { size: 'small' });

    $(document).ready(function() {
      error_table = $('#error_table').DataTable({
        scrollX: true,
        stateSave: true,
        order: [[0,1, 'asc']],
        lengthMenu: [
                    [ 10, 25, 50, -1 ],
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
          @if (isset($create_records) && $create_records),
          {
            text: 'Update DB',
            className: "btn-sm",
            action: function ( e, dt, node, config ) {
              error_table.rows().every(function () {
                prime_code = $(this.node()).find('td:eq(3)').text();
                meta = $(this.node()).find('td:eq(3)').text();
                project_id = $(this.node()).find('td:eq(5) option:selected').val();
                if (project_id != null) {
                  array_of_data.push({'project_id':project_id,'prime_code':prime_code,'meta':meta});
                }
              });
              var parameters = {
                "data": JSON.stringify(array_of_data)
              };

              $.ajax({
                type: 'post',
                url: "{!! route('otluploadcreatePOST') !!}",
                data: parameters,
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
                }
              });

              array_of_data = [];
            }
          }
          @endif
        ],
        drawCallback: function() {
          $(".user_projects").select2({
          allowClear: true
          });
          $(".customers").select2({
                  allowClear: true
          });
          $('.user_projects').val(null).trigger('change');
        }
      });

      @if (isset($create_records) && $create_records)
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

        $('.user_projects').on('change', function() {
          if ($(this).find(":selected").val() != null) {
            alert('something');
          } else {
            alert('nothing');
          }
        });
      @endif
    });
  </script>
@stop