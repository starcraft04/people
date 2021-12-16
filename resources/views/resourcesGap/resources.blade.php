@extends('layouts.app')

@section('style')
    <!-- CSS -->
    <!-- DataTables -->
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('/css/datatables.css') }}">
    <!-- Select2 -->
    <link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Switchery -->
    <link href="{{ asset('/plugins/gentelella/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
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
    <!-- Bootbox -->
    <script src="{{ asset('/plugins/bootbox/bootbox.min.js') }}"></script>script>
    <!-- Switchery -->
    <script src="{{ asset('/plugins/gentelella/vendors/switchery/dist/switchery.min.js') }}" type="text/javascript"></script>
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Resources Gap</h3>
  </div>
</div>
<div class="clearfix"></div>
<!-- Page title -->

<!-- Window -->
<div class="row">
         <!-- Selections for the table -->

 <!-- Selections for the table -->
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"><!-- Selections for the table -->

        <div class="form-group row">
          <div class="col-xs-2">
            <label for="year_res" class="control-label">Year</label>
            <select class="form-control select2" id="year_res" name="year_res" data-placeholder="Select a year">
              @foreach(config('select.year') as $key => $value)
              <option value="{{ $key }}">
                {{ $value }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-xs-2">
            <label for="month_res" class="control-label">Month</label>
            <select class="form-control select2" id="month_res" name="month_res" data-placeholder="Select a month">
              @foreach(config('select.month_names') as $key => $value)
              <option value="{{ $key }}">
                {{ $value }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-xs-3" style="display:none;">
            <label for="manager" class="control-label">Manager</label>
            <select class="form-control select2" id="manager" name="manager" data-placeholder="Select a manager" multiple="multiple">
              @foreach($authUsersForDataView->manager_list as $key => $value)
              <option value="{{ $key }}"
                @if(isset($authUsersForDataView->manager_selected) && $key == $authUsersForDataView->manager_selected) selected
                @endif>
                {{ $value }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-xs-3" style="display:none;">
            <label for="user" class="control-label">User</label>
            <select class="form-control select2" id="user" name="user" data-placeholder="Select a user" multiple="multiple">
              @foreach($authUsersForDataView->user_list as $key => $value)
              <option value="{{ $key }}"
                @if(isset($authUsersForDataView->user_selected) && $key == $authUsersForDataView->user_selected) selected
                @endif>
                {{ $value }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-xs-2">
            <label for="closed_type" id="closed_name" class="control-label">FTE</label>
            <input name="closed_type" type="checkbox" id="closed_type" class="form-group js-switch-small" checked /> 
          </div>
        </div>

        <!-- Selections for the table -->
       
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
      



        <!-- Main table -->
        <table id="activitiesTable" class="table table-striped table-hover table-bordered mytable" width="100%">
          <thead>
            <tr>
              <th>User Practice</th>
              @foreach(config('select.available_months') as $key => $month)
              <th id="table_month_{{$key}}"></th>
              @endforeach
              <th>AVG Per Practice</th>

            </tr>
          </thead>
          <tfoot>
            <tr>
              <th></th>
              @foreach(config('select.available_months') as $key => $month)
              <th></th>
              @endforeach
              <th></th>

            </tr>
          </tfoot>
        </table>
        <!-- Main table -->

      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->

@stop

  @section('script')
<script type="text/javascript">
  $(document).ready(function() {


 var activitiesTable;
  var year = [];
  var month = [];
  var manager = [];
  var user = [];
  var month_col = [];
  var header_months = [];
  var checkbox_closed = 0;
  var urlList ="{!! route('listsFTE') !!}";



  // switchery
  var small = document.querySelector('.js-switch-small');
  var switchery = new Switchery(small, { size: 'small' });

  function ajaxData(){
    var obj = {
      'year[]': year,
      'month[]': month,
      'manager[]': manager,
      'user[]': user,
      'checkbox_closed':checkbox_closed
    };
    return obj;
  }

  // This is the function that will set the values in the select2 boxes with info from Cookies


  function fill_select(select_id){
    array_to_use = [];
    
    var d = new Date();
      var y = d.getFullYear();
      var m = d.getMonth()+1;
      if (select_id == 'year_res') {
        $('#'+select_id).val(y).trigger('change');
      } else if (select_id == 'month_res') {
        $('#'+select_id).val(m).trigger('change');
      }
      $("#"+select_id+" option:selected").each(function()
      {
        // log the value and text of each option
        array_to_use.push($(this).val());
      });
    return array_to_use;
  }

  

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    //region Selection
    // SELECTIONS START
    // ________________
    // First we define the select2 boxes

    //Init select2 boxes
    $("#year_res").select2({
      allowClear: false
    });
    $("#month_res").select2({
      allowClear: false
    });
    $("#manager").select2({
      allowClear: false,
      disabled: {{ $authUsersForDataView->manager_select_disabled }}
    });
    $("#user").select2({
      allowClear: false,
      disabled: {{ $authUsersForDataView->user_select_disabled }}
    });

    // Then we need to get back the information from the cookie

    year = fill_select('year_res');
    month = fill_select('month_res');
    manager = fill_select('manager');
    user = fill_select('user');

    month_col = [1,2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];

    


function color_for_month_value(value,td) {
      if(value >0){
          $(td).addClass('resource_gap_postive');
      }
      else{
        $(td).addClass('resource_gap_negative_and_zero');
      }
    }
    //alert($.fn.dataTable.version);

    // This is to update the headers
    function update_headers() {
      months_from_selection = [];
      months_name = [
        @foreach(config('select.month') as $key => $month)
          '{{$month}}'
          @if($month != 'DEC'),@endif
        @endforeach
      ];
      header_months = [];
      
      for (let index = parseInt(month[0],10); index <= 12; index++) {
        this_year = parseInt(year[0],10);
        months_from_selection.push(months_name[index-1]+' '+this_year.toString().substring(2));
        header_months.push({'year':this_year,'month':index});
      }
      if (month[0] > 1) {
        next_year = parseInt(year[0], 10)+1;
        for (let index = 1; index <= month[0]-1; index++) {
          months_from_selection.push(months_name[index-1]+' '+next_year.toString().substring(2));
          header_months.push({'year':next_year,'month':index});
        }
      }

      //console.log(months_from_selection);
      
      // We change the title of the months as it varies in function of the year and month selected
      for (let index = 1; index <= 12; index++) {
          //console.log(month);
          $('#table_month_'+index).empty().html(months_from_selection[index-1]);
        }
    }

    // Then we define what happens when the selection changes

    $('#year_res').on('change', function() {
      Cookies.set('year', $('#year_res').val());
      year = [];
      $("#year_res option:selected").each(function()
      {
        // log the value and text of each option
        year.push($(this).val());

      });
        activitiesTable.ajax.reload(update_headers());

    });

    $('#month_res').on('change', function() {
      Cookies.set('month', $('#month_res').val());
      month = [];
      $("#month_res option:selected").each(function()
      {
        // log the value and text of each option
        month.push($(this).val());

      });
      //console.log(month);
      activitiesTable.ajax.reload(update_headers());

    });

    $('#manager').on('change', function() {
      Cookies.set('manager', $('#manager').val());
      manager = [];
      $("#manager option:selected").each(function()
      {
        // log the value and text of each option
        manager.push($(this).val());

      });
            activitiesTable.ajax.reload(update_headers());

    });

    $('#user').on('change', function() {
      Cookies.set('user', $('#user').val());
      user = [];
      $("#user option:selected").each(function()
      {
        // log the value and text of each option
        user.push($(this).val());

      });
            activitiesTable.ajax.reload(update_headers());

    });

    $('#closed_type').on('change', function() {
      if ($(this).is(':checked')) {
        checkbox_closed = 1;
        urlList = "{!! route('listsFTE') !!}";
        $('#closed_name').html('FTE');
        console.log($('#closed_name').html());
        console.log(urlList);

      } else {
        checkbox_closed = 0;
        
        urlList = "{!! route('lists') !!}";
        $('#closed_name').html('MD');
        console.log($('#closed_name').html());
        console.log(urlList);
        

      }
      activitiesTable.ajax.reload();
    });

    // SELECTIONS END
    //endregion

    $.ajax({
       url: "{!! route('listsFTE') !!}",
        type: "POST",
        data: ajaxData(),
        success:function(data){
          console.log(data);
        },
        dataType: "JSON",
    });

   

    activitiesTable = $('#activitiesTable').DataTable({
      scrollX: true,
      serverSide: true,
      processing: true,
      stateSave: true,

      ajax: {
        url: urlList,
        type: "POST",
        data: function ( d ) {
          $.extend(d,ajaxData());
        },
        dataType: "JSON"
      },
      columns: [
        { name: 'u.domain', data: 'practice' , width:'50px',searchable: true , visible: true}
        @foreach(config('select.available_months') as $key => $month)

          ,{ name: 'm{{$key}}_com_sum', data: 'm{{$key}}_com_sum', 
            createdCell: function (td, cellData, rowData, row, col) {
              color_for_month_value(rowData.m{{$key}}_com_sum,td);
            }, width: '20px', searchable: false, visible: true, orderable: false}

        @endforeach

        ,{ name: 'sum', data: 'sum' ,createdCell: function (td, cellData, rowData, row, col) {
              color_for_month_value(rowData.sum,td);
            },width:'50px',searchable: false , visible: true}
        
        ],
        footerCallback: function ( row, data, start, end, display ) {
        var api = this.api(), data;
        //adding total word
        $( api.column(0).footer() ).html(
              '<div style="font-size: 120%;">Total</div>'
          );
        $.each(month_col, function( index, value ) {
          // Total over this page
          pageTotal = api
            .column( value, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
              return parseFloat(a)+parseFloat(b);
            }, 0 );

          // Update footer
          if(pageTotal > 0){
            $( api.column( value ).footer() ).html(
              '<div style="font-size: 120%; text-align: center;color : red;">'+pageTotal.toFixed(1)+'</div>'
          );
          }
          else{
             $( api.column( value ).footer() ).html(
              '<div style="font-size: 120%; text-align: center;">'+pageTotal.toFixed(1)+'</div>'
          );
          }
        });
      },
      initComplete: function () {
        update_headers();
        
            activitiesTable.draw();
        
      }

    });

    })

</script>
@stop