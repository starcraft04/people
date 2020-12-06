@extends('layouts.app')

@section('style')
    <!-- CSS -->
    <!-- Select2 -->
    <link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Document styling -->
    <link href="{{ asset('/css/loe.css') }}" rel="stylesheet" />

@stop

@section('scriptsrc')
    <!-- JS -->
    <!-- Select2 -->
    <script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
    <!-- Excel export -->
    <script src="{{ asset('/plugins/TableExport/libs/FileSaver/FileSaver.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/TableExport/libs/js-xlsx/xlsx.core.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/TableExport/tableExport.min.js') }}" type="text/javascript"></script>
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>LoE dashboard</h3>
  </div>
</div>
<div class="clearfix"></div>
<!-- Page title -->

<!-- Window -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window content -->
      <div class="x_content">

        <div class="form-group row">
          <div class="col-xs-3">
            <label for="year" class="control-label">Year</label>
            <select class="form-control select2" style="width: 100%;" id="year" name="year" data-placeholder="Select a year">
              @foreach($authUsersForDataView->year_list as $key => $value)
              <option value="{{ $key }}"
                @if($key == $year) selected
                @endif>
                {{ $value }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-xs-3">
            <label for="customer" class="control-label">Customer</label>
            <select class="form-control select2" style="width: 100%;" id="customer" name="customer" data-placeholder="Select a customer">
              @foreach($customers_list as $key => $value)
              <option value="{{ $key }}">
                {{ $value }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-xs-3">
            <label for="project" class="control-label">Project</label>
            <select class="form-control select2" style="width: 100%;" id="project" name="project" data-placeholder="Select a project">
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col-md-1">
            <div class="dropdown">
              <button id="options_loe" class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
              <span class="glyphicon glyphicon-cog"></span><i class="fa fa-sort-desc"></i>
              </button>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Report</li>
                <li><a class="dropdown-selection" id="loe_table_to_excel" href="#">Export to Excel</a></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered table-sm" cellspacing="0" width="100%" id="LoeTable"></table>
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

$(document).ready(function() {
  var year = "{!! $year !!}";
  var customer = $('#customer').val();;
  var project;
  var project_list;

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

  //Init select2 boxes
  $("#year").select2({
    allowClear: false,
    disabled: {{ $authUsersForDataView->year_select_disabled }}
  });
  $("#customer").select2({
    allowClear: false
  });
  $("#project").select2({
    allowClear: false
  });

  // Init Customer and projects
  change_project_select(customer);

  $('#year').on('change', function() {
    year = $('#year').val();
    window.location.href = "{!! route('loedashboard') !!}/"+year;
  });

  $(document).on('click', '#loe_table_to_excel', function () {
    $('.table_recurrent').empty();
    $('.table_recurrent').html('1');
    $('#LoeTable').tableExport({type:'excel',fileName: 'loe'});
    $('.table_recurrent').empty();
    $('.table_recurrent').html('<i class="fa fa-check"></i>');
    
  });

  function change_project_select(customer_id) {
    $.ajax({
            type: 'get',
            url: "{!! route('loeDashboardProjects','') !!}/"+customer_id,
            dataType: 'json',
            success: function(data) {
              project_list = data;
              //console.log(project_list);
              var html = '';
              project_list.forEach(fill_project_select);
              function fill_project_select (project){
                html += '<option value="'+project.id+'" >'+project.project_name+'</option>';
              }

              $('#project').empty();
              $('#project').append(html);
              // Set selected 
              $('#project').val(project_list[0].id);
              $('#project').select2().trigger('change');
            },
            error: function (jqXhr, textStatus, errorMessage) { // error callback 
              console.log('Error: ' + errorMessage);
            }
          });
  }

  $('#customer').on('change', function() {
    $('select#project').val($(this).data(''));
    $('select#project').select2().trigger('change');
    customer_id = $('#customer').val();
    change_project_select(customer_id);
  });

  $('#project').on('change', function() {
    var project_id = $('select#project').children("option:selected").val();
    if (project_id > 0) {
      //console.log(project_id);
      getloe(project_id);
    }
    
  });

  function getBusinessDatesCount(start, end) {
    var startDate = new Date(start);
    var endDate = new Date(end);
    var count = 0;
    var curDate = startDate;
    while (curDate <= endDate) {
        var dayOfWeek = curDate.getDay();
        if(!((dayOfWeek == 6) || (dayOfWeek == 0)))
          count++;
        curDate.setDate(curDate.getDate() + 1);
    }
    return count;
  }

  function td_no_null(item,end='') {
    if (item != null && item != '') {
      return '<td>'+item+end+'</td>';
    } else {
      return '<td></td>';
    }
  }

  function getloe(project_id) {
    var project_id;
    $('#LoeTable').empty();
      $.ajax({
        type: 'get',
        url: "{!! route('listFromProjectID','') !!}/"+project_id,
        dataType: 'json',
        success: function(data) {
          console.log(data);

          if (data.length != 0) {

            // Then we need to create the headers for the table
            html = '<thead>';
            //region First header
            html += '<tr>';
            html += '<th rowspan="3" style="min-width:150px;">'+'Main Phase'+'</th>';
            html += '<th rowspan="3" style="min-width:150px;">'+'Secondary Phase'+'</th>';
            html += '<th rowspan="3" style="min-width:150px;">'+'Domain'+'</th>';
            html += '<th rowspan="3" style="min-width:250px;">'+'Description'+'</th>';
            html += '<th rowspan="3" style="min-width:150px;">'+'Option'+'</th>';
            html += '<th rowspan="3" style="min-width:250px;">'+'Assumption'+'</th>';
            html += '<th rowspan="3">'+'Quantity'+'</th>';
            html += '<th rowspan="3">'+'LoE (per unit)'+'</th>';
            html += '<th rowspan="3">'+'recurrent'+'</th>';
            html += '<th rowspan="3" style="min-width:150px;">'+'Start date'+'</th>';
            html += '<th rowspan="3" style="min-width:150px;">'+'End date'+'</th>';
            if (data.col.cons.length>0) {
              html += '<th colspan="'+2*data.col.cons.length+'">'+'Consulting type (MD)'+'</th>';
            }
            
            html += '<th rowspan="3">'+'Total Loe'+'</th>';
            if (data.col.cons.length>0) {
              html += '<th rowspan="3">'+'Total Price'+'</th>';
            }
            html += '</tr>';
            //endregion
            //region Second header
            html += '<tr>';

            data.col.cons.forEach(function(cons){
              html += '<th colspan="2" style="min-width:150px;">'
              html += cons.name;
              html += '<br>';
              if (cons.seniority != null) {
                html += cons.seniority;
              } else {
                html += '';
              }
              html += '<br>';
              if (cons.location != null) {
                html += cons.location;
              } else {
                html += '';
              }
              html += '</th>';
            });

            html += '</tr>';
            //endregion
            //region Third header
            html += '<tr>';
            data.col.cons.forEach(function(cons){
              html += '<th>MD</th>';
              html += '<th>€</th>';
            });

            html += '</tr>';

            html += '</thead>';
            //endregion
            // Data filling
            var grand_total_loe = 0;
            var grand_total_price = 0;
            var total_loe = 0;

            //region Body
            html += '<tbody>';
            data.data.loe.forEach(function(row){

              html += td_no_null(row.main_phase);
              html += td_no_null(row.secondary_phase);
              html += td_no_null(row.domain);
              html += td_no_null(row.description);
              html += td_no_null(row.option);
              html += td_no_null(row.assumption);

              html += '<td>'+row.quantity+'</td>';
              html += '<td>'+row.loe_per_quantity+'</td>';
              
              if (row.recurrent == 1) {
                html += '<td class="table_recurrent"><i class="fa fa-check"></i></td>';
              } else {
                html += '<td></td>';
              }
              
              html += td_no_null(row.start_date);
              html += td_no_null(row.end_date);

              var total_price = 0;
              data.col.cons.forEach(fill_cons_data_MD);

              function fill_cons_data_MD (cons){
                if (data.data.cons.hasOwnProperty(row.id) && data.data.cons[row.id].hasOwnProperty(cons.name)) {
                  //console.log(site.name+': '+data.data.site[row.id][site.name]['quantity']);
                  fill_percent = data.data.cons[row.id][cons.name].percentage;
                  if (row.recurrent == 0) {
                    fill_md = row.quantity*row.loe_per_quantity*fill_percent/100;
                  } else {
                    fill_md = row.quantity*row.loe_per_quantity*getBusinessDatesCount(row.start_date,row.end_date)*fill_percent/100;
                  }
                  if (data.data.cons[row.id][cons.name].price != null) {
                    fill_price = data.data.cons[row.id][cons.name].price;
                  } else {
                    fill_price = 0;
                  }
                  if (fill_price != null) {
                    total_price += fill_md*fill_price;
                  }
                  //console.log('fill_md: '+fill_md);
                  //console.log('fill_price: '+fill_price);
                  //console.log('total_price: '+total_price);
                  //console.log('---------------------------: ');
                } else {
                  //console.log(site.name+': -');
                  fill_md = 0;
                  fill_price = 0;
                }
                html += '<td>'+fill_md+'</td>';
                html += '<td>'+fill_price+'</td>';
              }

              if (row.recurrent == 0) {
                total_loe = row.quantity*row.loe_per_quantity;
              } else {
                total_loe = row.quantity*row.loe_per_quantity*getBusinessDatesCount(row.start_date,row.end_date);
                //console.log(getBusinessDatesCount(row.start_date,row.end_date));
              }
              if (total_loe != null && total_loe != '') {
                html += '<td>'+total_loe+'</td>';
              } else {
                html += '<td></td>';
              }
              grand_total_loe += total_loe;
              
              if (data.col.cons.length>0) {
                html += td_no_null(total_price, ' €');
              }
              
              grand_total_price += total_price;

              html += '</tr>';
            });
            html += '</tbody>';
            //endregion
            //region Footer
            html += '<tfoot>';
            number_of_cols = 11+2*data.col.cons.length-1;
            //console.log(number_of_cols);
            //console.log(data.col.site.length);
            //console.log(data.col.cons.length);
            // Wen need to remove one column named formula in case there is no calculation
            if (data.col.site.length == 0) {
              number_of_cols -= 1;
            }
            for (let index = 0; index < number_of_cols; index++) {
              html += '<td></td>';
            }

            html += '<td>Grand Total</td>';

            if (grand_total_loe != null && grand_total_loe != '') {
              html += '<td>'+grand_total_loe+'</td>';
            } else {
              html += '<td></td>';
            }

            if (data.col.cons.length>0) {
              if (grand_total_price != null && grand_total_price != '') {
                html += '<td>'+grand_total_price+' €</td>';
              } else {
              html += '<td></td>';
              }
              
            }
            
            html += '</tfoot>';
            //endregion

            $('#LoeTable').prepend(html);

          }

        }
      });
  }

  // Remove the formatting to get integer data for summation
  var intVal = function ( i ) {
    return typeof i === 'string' ?
      i.replace(/[\$,]/g, '')*1 :
      typeof i === 'number' ?
          i : 0;
  };

});


</script>
@stop