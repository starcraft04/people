@extends('layouts.app')

@section('style')
<!-- CSS -->
<!-- Select2 -->
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/css/forms.css') }}" rel="stylesheet" />
@stop

@section('scriptsrc')
<!-- JS -->
<!-- Select2 -->
<script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
<!-- Form validator -->
<script src="{{ asset('/plugins/gentelella/vendors/parsleyjs/dist/parsley.min.js') }}" type="text/javascript"></script>
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Revenue upload</h3>
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
          {!! Form::open(['url' => 'revenueupload', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}

          <div class="row">
            <div class="form-group col-md-12">
              <div class="col-md-2">
                {!! Form::label('sample', 'Sample file', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-10">
                The file needs to to have minimum 2 columns with name Customer name and FPC and the other columns need to be named with 3 letters for the month and two digit for the year.
              </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group {!! $errors->has('uploadfile') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-2">
                {!! Form::label('uploadfile', 'File', ['class' => 'control-label']) !!}
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

@if (isset($customers_missing) && !empty($customers_missing))
<!-- Window -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window title -->
      <div class="x_title">
        <h2>Missing customers</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        Here you can create a link between the name in Dolphin and the name coming from the Revenue file. When done, please reupload the xls file for the changes to take effect.
          <table id="ot_table" class="table table-striped table-hover table-bordered mytable" width="100%">
            <thead>
              <th>Customer (Revenue)</th>
              <th>Customer (Dolphin)</th>
              <th>Action</th>
            </thead>
            <tbody id="table_content">
              @foreach($customers_missing as $customer)
                <tr>
                  <td class="customer_upload_name">{!! $customer !!}</td>
                  <td class="customer_dolphin_name">
                    <form role="form" method="POST" action="" data-parsley-validate>
                      <div class="form-group">
                        <select class="form-control select2" style="width: 100%;" name="customer_dolphin" data-placeholder="Select a customer" required>
                            <option value="" ></option>
                            @foreach($customers_list as $key => $value)
                            <option value="{{ $key }}">
                              {{ $value }}
                            </option>
                            @endforeach
                        </select>
                      </div>  
                    </form>
                  </td>
                  <td class="buttonAdd" style="width: 40px;"><button type="button" class="btn btn-info btn-xs add_customer"><span class="glyphicon glyphicon-plus"></span></button></td>
                </tr>
              @endforeach
            </tbody>
          </table>
      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->
@endif

@if (isset($messages) && !empty($messages))
<!-- Window -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window title -->
      <div class="x_title">
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
          <div class="text-info"><H2>Error messages</H2></div>
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
<!-- Window -->
@endif


@stop

@section('script')
@if (isset($customers_missing) && !empty($customers_missing))
<script>
$(document).ready(function() {

  // Ajax setup needed in case there is an update for revenue, comment, loe, ... tabs
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  //Init select2 boxes
  $(".select2").select2({
      allowClear: true
    });

  // Click plus button for customer assignment
  $(document).on('click', '.add_customer', function () {
    // Checking validation rules
    if (!$(this).closest('tr').find('form').parsley().validate()) {
      return;
    }

    var row = $(this).closest('tr');
    var select = row.find('select[name="customer_dolphin"]');

    // Getting the info from the row
    customer_upload_name = row.children("td.customer_upload_name").text();
    customer_dolphin_id = row.children("td.customer_dolphin_name").find("select option:selected").val();
    data = {'customer_id':customer_dolphin_id,'other_name':customer_upload_name};

    // Now trying to update the name in dolphin table
    $.ajax({
          type: 'post',
          url: "{!! route('revenueUploadChangeName') !!}",
          data:data,
          dataType: 'json',
          success: function(data) {
            if (data.result == 'success'){
                box_type = 'success';
                message_type = 'success';
                row.find('td.buttonAdd').empty();
                row.find('td.buttonAdd').html('Added');
                select.prop("disabled", true);
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

</script>
@endif
@stop
