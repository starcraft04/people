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

  <link rel="stylesheet" href="{{ asset('/css/datatables.css') }}">
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
<!-- Switchery -->
<script src="{{ asset('/plugins/gentelella/vendors/switchery/dist/switchery.min.js') }}" type="text/javascript"></script>
<!-- Select2 -->
<script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Samba upload</h3>
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
          {!! Form::open(['url' => 'sambaupload', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}

          <div class="row">
            <div class="form-group col-md-12">
              <div class="col-md-2">
                {!! Form::label('sample', 'Sample file', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-3">
                Download 
                <a href="{{ asset('/Samples/samba_upload_sample.csv') }}" style="text-decoration: underline;">this file</a> to get the structure needed.
              </div>
              <div class="col-md-5"><input name="create_in_db" type="checkbox" id="create_in_db" class="form-group js-switch-small" /> Create new record in DB if no Samba ID found</div>
            </div>
          </div>

          <div class="row">
            <div class="form-group {!! $errors->has('uploadfile') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-2">
                {!! Form::label('uploadfile', 'Samba excel file', ['class' => 'control-label']) !!}
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
        <h2>Create records<small>Only records where all select boxes are filled in will be added</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <div class="row">
          <div class="col-xs-11">
            <label for="year" class="control-label">Year</label>
            <select style="width: 100px;" class="select2" id="year" name="year" data-placeholder="Select a year">
              @foreach(config('select.year') as $key => $value)
              <option value="{{ $key }}"
                @if($key == date('Y')) selected
                @endif>
                {{ $value }}
              </option>
              @endforeach
            </select>
          </div>
        </div>
        </br>
        <table id="samba_table" class="table table-striped table-hover table-bordered mytable" width="100%">
          <thead>
            <tr>
              <th>Action</th>
              <th>Cluster</th>
              <th>Samba lead domain</th>
              <th>Customer (samba)</th>
              <th>Customer (Dolphin)</th>
              <th>Project name</th>
              <th>Assigned User</th>
              <th>Samba ID</th>
              <th>Opportunity owner</th>
              <th>Created date</th>
              <th>Close date</th>
              <th>Samba stage</th>
              <th>Win ratio (%)</th>
              <th>Order Intake (€)</th>
              <th>Consulting (€)</th>
            </tr>
          </thead>
          <tbody>
          @foreach($ids as $key => $project)
            @if(!$project['in_db'])
              <tr class="item">
                <td><button type="button" class="btn btn-info btn-xs add_samba"><span class="glyphicon glyphicon-plus"></span></button></td>
                <td class="owners_sales_cluster">{!! $project['owners_sales_cluster'] !!}</td>
                <td class="opportunity_domain">{!! $project['opportunity_domain'] !!}</td>
                <td class="account_name">{!! $project['account_name'] !!}</td>
                <td class="customer_name">
                  <select class="customers dt-select2" style="width: 100%;" data-placeholder="Select a customer name">
                    @foreach($customers_list as $key => $value)
                    <option value="{{ $key }}" @if ($value == $project['account_name']) selected @endif>
                      {{ $value }}
                    </option>
                    @endforeach
                  </select>
                </td>
                <td class="opportunity_name"><div contenteditable>{!! $project['opportunity_name'] !!}</div></td>
                <td class="users_name" style="width: 200px;">
                  <select class="users dt-select2" style="width: 100%;" data-placeholder="Select a user name">
                    @foreach($users_select as $key => $value)
                    <option value="{{ $key }}">
                      {{ $value }}
                    </option>
                    @endforeach
                  </select>
                </td>
                <td class="public_opportunity_id">{!! $project['public_opportunity_id'] !!}</td>
                <td class="opportunity_owner">{!! $project['opportunity_owner'] !!}</td>
                <td class="created_date">{!! $project['created_date'] !!}</td>
                <td class="close_date">{!! $project['close_date'] !!}</td>
                <td class="stage">{!! $project['stage'] !!}</td>
                <td class="probability">{!! $project['probability'] !!}</td>
                <td class="amount_tcv">{!! $project['amount_tcv'] !!}</td>
                <td class="consulting_tcv">{!! $project['consulting_tcv'] !!}</td>
              </tr>
            @endif
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
            <th></th>
            <th></th>
          </tfoot>
        </table>
      </div>
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
    // switchery
    var small = document.querySelector('.js-switch-small');
    var switchery = new Switchery(small, { size: 'small' });

    var year;
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

    @if (isset($create_records) && $create_records)

      $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
      });

      $(document).ready(function() {

        $("#year").select2({
          allowClear: false
        });

        samba_table = $('#samba_table').DataTable({
          scrollX: true,
          @if(isset($table_height))
          scrollY: '{!! $table_height !!}vh',
          scrollCollapse: true,
          @endif
          stateSave: true,
          order: [[0, 'asc']],
          columns: [
              { name: 'action', data: 'null' , searchable: true , visible: true, className: "dt-nowrap"},
              { name: 'owners_sales_cluster', data: 'owners_sales_cluster' , searchable: true , visible: true, className: "dt-nowrap"},
              { name: 'opportunity_domain', data: 'opportunity_domain' , searchable: true , visible: false},
              { name: 'account_name', data: 'account_name' , searchable: true , visible: true, className: "dt-nowrap"},
              { name: 'customer_name', data: 'customer_name' , searchable: false , visible: true, className: "dt-nowrap"},
              { name: 'opportunity_name', data: 'opportunity_name' , searchable: true , visible: true, className: "dt-nowrap"},
              { name: 'users_name', data: 'users_name' , searchable: false , visible: true, className: "dt-nowrap"},
              { name: 'public_opportunity_id', data: 'public_opportunity_id' , searchable: true , visible: true, className: "dt-nowrap"},
              { name: 'opportunity_owner', data: 'opportunity_owner' , searchable: true , visible: true, className: "dt-nowrap"},
              { name: 'created_date', data: 'created_date' , searchable: true , visible: false, className: "dt-nowrap"},
              { name: 'close_date', data: 'close_date' , searchable: true , visible: false, className: "dt-nowrap"},
              { name: 'stage', data: 'stage' , searchable: true , visible: false, className: "dt-nowrap"},
              { name: 'probability', data: 'probability' , searchable: true , visible: true, className: "dt-nowrap"},
              { name: 'amount_tcv', data: 'amount_tcv' , searchable: true , visible: true, className: "dt-nowrap"},
              { name: 'consulting_tcv', data: 'consulting_tcv' , searchable: true , visible: true, className: "dt-nowrap"},
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
              columns: [1,2,3,5,7,8,9,10,11,12,13,14]
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
          drawCallback: function() {
            $('.dt-select2').select2({
              allowClear: true
            });
            $('.users').val(null).trigger('change');
          },
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

        $(".add_samba").click(function() {
          var array_of_data = [];
          year = $("#year option:selected").val();

          var $row = $(this).closest("tr");

          cluster = $row.find('.owners_sales_cluster').text();
          samba_lead_domain = $row.find('.opportunity_domain').text();
          customer_samba = $row.find('.account_name').text();
          customer_dolphin = $row.find('.customer_name option:selected').val();
          project_name = $row.find('.opportunity_name').text();
          assigned_user = $row.find('.users_name option:selected').val();
          samba_id = $row.find('.public_opportunity_id').text();
          opportunity_owner = $row.find('.opportunity_owner').text();
          create_date = $row.find('.created_date').text();
          close_date = $row.find('.close_date').text();
          samba_stage = $row.find('.stage').text();
          win_ratio = $row.find('.probability').text();
          order_intake = $row.find('.amount_tcv').text();
          consulting_tcv = $row.find('.consulting_tcv').text();

          if (customer_dolphin != '' && assigned_user != null) {
            array_of_data.push({'samba_lead_domain':samba_lead_domain,'customer_samba':customer_samba,'customer_dolphin':customer_dolphin,
              'project_name':project_name,'assigned_user':assigned_user,'samba_id':samba_id,
              'order_intake':order_intake,'opportunity_owner':opportunity_owner,'create_date':create_date,
              'close_date':close_date,'samba_stage':samba_stage,'win_ratio':win_ratio,'consulting_tcv':consulting_tcv});
          } else {
            box_type = 'danger';
            message_type = 'error';
            msg = '<b>Customer (Dolphin)</b> and <b>Assigned User</b> missing'
            $('#flash-message').empty();
            var box = $('<div id="delete-message" class="alert alert-'+box_type+' alert-dismissible flash-'+message_type+'" role="alert"><button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>'+msg+'</div>');
            $('#flash-message').append(box);
            $('#delete-message').delay(2000).queue(function () {
                $(this).addClass('animated flipOutX')
            });
            return;
          }


          var parameters = {
            "data": JSON.stringify(array_of_data),
            "year":year
          };

          
          console.log(parameters);

          $.ajax({
            type: 'post',
            url: "{!! route('sambauploadcreatePOST') !!}",
            data: parameters,
            dataType: 'json',
            success: function(data) {
              console.log(data);
              if (data.result == 'success'){
                  box_type = 'success';
                  message_type = 'success';
                  $row.remove();
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
          
        });
      });
    @endif
  </script>
@stop
