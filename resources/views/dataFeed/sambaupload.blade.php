@extends('layouts.app')

@section('style')
<!-- CSS -->
<!-- Switchery -->
<link href="{{ asset('/plugins/gentelella/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
<!-- Select2 -->
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/css/forms.css') }}" rel="stylesheet" />
@stop

@section('scriptsrc')
<!-- JS -->
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
                <a href="{{ asset('/Samples/samba_upload_sample.xlsx') }}" style="text-decoration: underline;">this file</a> to get the structure needed.
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
@if (isset($messages))
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window title -->
      <div class="x_title">
        <h2>Results
          <small>
            @if(isset($create_records) && $create_records)
              Create new records activated, please minimize this window to access the selection for creation
            @endif
          </small>
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
          </BR></BR></BR>
          <div class="text-info"><H2>Full result</H2></div>
          </BR>
          @foreach($messages as $m)
          <div class="row">
            <div class="col-md-1 {!! isset($color[$m['status']]) ? $color[$m['status']] : '' !!}">
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
          <div class="col-xs-1 text-right">
            <button type="button" id="create_project_button" class="text-right btn btn-info btn-xs">Create</button>
          </div>
        </div>
        </br>
        <table id="projects_table" class="table table-striped table-hover table-bordered" width="100%">
          <thead>
            <tr>
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
            </tr>
          </thead>
          <tbody>
          @foreach($messages_only_errors as $key => $project)
            <tr class="item">
              <td>{!! $project['opportunity_domain'] !!}</td>
              <td>{!! $project['account_name'] !!}</td>
              <td>
                <select class="customers select2" style="width: 100%;" data-placeholder="Select a customer name">
                  @foreach($customers_list as $key => $value)
                  <option value="{{ $key }}" @if ($value == $project['account_name']) selected @endif>
                    {{ $value }}
                  </option>
                  @endforeach
                </select>
              </td>
              <td><div contenteditable>{!! $project['opportunity_name'] !!}</div></td>
              <td style="width: 200px;">
                <select class="users select2" style="width: 100%;" data-placeholder="Select a user name">
                  @foreach($users_select as $key => $value)
                  <option value="{{ $key }}">
                    {{ $value }}
                  </option>
                  @endforeach
                </select>
              </td>
              <td>{!! $project['public_opportunity_id'] !!}</td>
              <td>{!! $project['opportunity_owner'] !!}</td>
              <td>{!! $project['created_date'] !!}</td>
              <td>{!! $project['close_date'] !!}</td>
              <td>{!! $project['stage'] !!}</td>
              <td>{!! $project['probability'] !!}</td>
              <td>{!! $project['amount_tcv'] !!}</td>
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
    // switchery
    var small = document.querySelector('.js-switch-small');
    var switchery = new Switchery(small, { size: 'small' });
    var year;
    var samba_lead_domain;
    var customer_samba;
    var customer_dolphin;
    var project_name;
    var assigned_user;
    var samba_id;
    var opportunity_owner;
    var creat_date;
    var close_date;
    var samba_stage;
    var win_ratio;
    var order_intake;
    var array_of_data = [];

    @if (isset($create_records) && $create_records)

      $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
      });

      $(document).ready(function() {
        $(".customers").select2({
                  allowClear: true
        });
        $(".users").select2({
          allowClear: true
        });
        $("#year").select2({
          allowClear: false
        });
        $('.users').val(null).trigger('change');

        $("#create_project_button").click(function() {
          year = $("#year option:selected").val();
          $("#projects_table tr.item").each(function() {
            samba_lead_domain = $(this).find('td:eq(0)').text();
            customer_samba = $(this).find('td:eq(1)').text();
            customer_dolphin = $(this).find('td:eq(2) option:selected').val();
            project_name = $(this).find('td:eq(3)').text();
            assigned_user = $(this).find('td:eq(4) option:selected').val();
            samba_id = $(this).find('td:eq(5)').text();
            opportunity_owner = $(this).find('td:eq(6)').text();
            creat_date = $(this).find('td:eq(7)').text();
            close_date = $(this).find('td:eq(8)').text();
            samba_stage = $(this).find('td:eq(9)').text();
            win_ratio = $(this).find('td:eq(10)').text();
            order_intake = $(this).find('td:eq(11)').text();
            
            if (customer_dolphin != '' && assigned_user != null) {
              array_of_data.push({'samba_lead_domain':samba_lead_domain,'customer_samba':customer_samba,'customer_dolphin':customer_dolphin,
                'project_name':project_name,'assigned_user':assigned_user,'samba_id':samba_id,
                'order_intake':order_intake,'opportunity_owner':opportunity_owner,'creat_date':creat_date,
                'close_date':close_date,'samba_stage':samba_stage,'win_ratio':win_ratio});
            }
          });

          var parameters = {
            "data[]": array_of_data,
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
          
        });
      });
    @endif
  </script>
@stop
