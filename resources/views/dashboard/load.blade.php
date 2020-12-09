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
    <script src="{{ asset('/plugins/bootbox/bootbox.min.js') }}"></script>
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Team load</h3>
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
        <h2>Tools</small></h2>
        <button id="legendButton" class="btn btn-success btn-sm" style="margin-left: 10px;">legend</button>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <br />
          <div class="row">
            <div class="form-group col-xs-2">
              <label for="month" class="control-label">Year</label>
              <select class="form-control select2" style="width: 100%;" id="year" name="year" data-placeholder="Select a year">
                @foreach($authUsersForDataView->year_list as $key => $value)
                <option value="{{ $key }}"
                  @if(isset($authUsersForDataView->year_selected) && $key == $authUsersForDataView->year_selected) selected
                  @endif>
                  {{ $value }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-xs-2">
              <label for="manager" class="control-label">Manager</label>
              <select class="form-control select2" style="width: 100%;" id="manager" name="manager" data-placeholder="Select a manager" multiple="multiple">
                @foreach($authUsersForDataView->manager_list as $key => $value)
                <option value="{{ $key }}"
                  @if(isset($authUsersForDataView->manager_selected) && $key == $authUsersForDataView->manager_selected) selected
                  @endif>
                  {{ $value }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-xs-2">
              <label for="user" class="control-label">User</label>
              <select class="form-control select2" style="width: 100%;" id="user" name="user" data-placeholder="Select a user" multiple="multiple">
                @foreach($authUsersForDataView->user_list as $key => $value)
                <option value="{{ $key }}"
                  @if(isset($authUsersForDataView->user_selected) && $key == $authUsersForDataView->user_selected) selected
                  @endif>
                  {{ $value }}
                </option>
                @endforeach
              </select>
            </div>
          </div>
      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->

<!-- Window -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window title -->
      <div class="x_title">
        <h2>Load (days)</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
            <table id="activitiesTable" class="table table-striped table-hover table-bordered mytable" width="100%">
              <thead>
                <tr>
                  <th>Manager ID</th>
                  <th>Manager name</th>
                  <th>User ID</th>
                  <th>User name</th>
                  <th>Year</th>
                  @foreach(config('select.available_months') as $month)
                  <th>{{ ucfirst($month) }} Tot</th>
                  <th>{{ ucfirst($month) }} Bil</th>
                  <th>{{ ucfirst($month) }} ARVI</th>
                  <th>{{ ucfirst($month) }} completion</th>
                  @endforeach
                  <th>H1 Bil(hours)</th>
                  <th>H2 Bil(hours)</th>
                  <th>Year Bil(hours)</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  @foreach(config('select.available_months') as $month)
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  @endforeach
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
      </div>
<!-- Window content -->

<!-- Modal -->
<div class="modal fade" id="legendModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
              <button type="button" class="close" 
                  data-dismiss="modal">
                      <span aria-hidden="true">&times;</span>
                      <span class="sr-only">Close</span>
              </button>
              <h4 class="modal-title" id="myModalLabel">
                  Legend
              </h4>
          </div>
            
          <!-- Modal Body -->
          <div class="modal-body">
            We take 22 days as a base for the number of working days in a month (average)
              
                <table class="table borderless">
                  <thead>
                    <th>Color</th><th>Meaning</th>
                  </thead>
                  <tbody>
                    <tr><td style="color: blue;">Blue</td><td>days smaller or equal to 22</td></tr>
                    <tr><td style="color: red;">Red</td><td>days greater than 22</td></tr>
                  </tbody>
                </table>
              
          </div>
            
          <!-- Modal Footer -->
          <div class="modal-footer">
              <button type="button" class="btn btn-default"
                      data-dismiss="modal">
                          Close
              </button>
          </div>
        </div>
    </div>
</div>
<!-- Modal -->

      </div>
    </div>
  </div>
  @stop

  @section('script')
  <script>
  //region Variables and functions
  var activitiesTable;
  var year = [];
  var manager = [];
  var user = [];

  function ajaxData(){
    var obj = {
      'year[]': year,
      'manager[]': manager,
      'user[]': user
    };
    return obj;
  }

  // This is the function that will set the values in the select2 boxes with info from Cookies
  function fill_select(select_id){
    array_to_use = [];
    values = Cookies.get(select_id);

    if (values != null) {
      values = values.replace(/\"/g,'').replace('[','').replace(']','');
      values = values.split(',');
      $('#'+select_id).val(values).trigger('change');
      array_to_use = [];
      $("#"+select_id+" option:selected").each(function()
      {
        // log the value and text of each option
        array_to_use.push($(this).val());

      });
    }
    else {
      $("#"+select_id+" option:selected").each(function()
      {
        // log the value and text of each option
        array_to_use.push($(this).val());
      });
    }
    return array_to_use;
  }

  //Assign color
  function color_for_month_value(from_prime,td) {
      if (from_prime >= 1) {
        $(td).addClass("otl");      
      } else {
          $(td).addClass("forecast");
      }
  }

  function color_for_completion_value(value,td) {
    if (value < 100) {
      $(td).addClass("too_low");      
    }
  }

  //For number of week days in a month
  function daysInMonth(month, year){
    // Here January is 1 based
    //Day 0 is the last day in the previous month
    return new Date(year, month, 0).getDate();
    // Here January is 0 based
    //return new Date(year, month+1, 0).getDate();
  }
  function isWeekday(year, month, day) {
    var day = new Date(year, month-1, day).getDay();
    return day !=0 && day !=6;
  }
  function getWeekdaysInMonth(month, year) {
    var days = daysInMonth(month, year);
    var weekdays = 0;
    for(var i=0; i< days; i++) {
        if (isWeekday(year, month, i+1)) weekdays++;
    }
    return weekdays;
  }

  /* year_test = 2020;
  month_test = 3;
  console.log(daysInMonth(month_test, year_test));
  for (let day = 1; day < daysInMonth(month_test, year_test)+1; day++) {
    date_day = new Date(year_test, month_test, day);
    console.log(date_day.toLocaleString()+' - weekday: '+isWeekday(year_test,month_test,day));
  }
  console.log(getWeekdaysInMonth(month_test, year_test)); */
  
  //endregion
  
  
  

  $(document).ready(function() {
    //region Init
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // SELECTIONS START
    // ________________
    // First we define the select2 boxes

    //Init select2 boxes
    $("#year").select2({
      allowClear: false,
      disabled: {{ $authUsersForDataView->year_select_disabled }}
    });
    //Init select2 boxes
    $("#manager").select2({
      allowClear: false,
      disabled: {{ $authUsersForDataView->manager_select_disabled }}
    });
    //Init select2 boxes
    $("#user").select2({
      allowClear: false,
      disabled: {{ $authUsersForDataView->user_select_disabled }}
    });

    // Then we need to get back the information from the cookie

    year = fill_select('year');
    manager = fill_select('manager');
    user = fill_select('user');

    //alert($.fn.dataTable.version);

    // Then we define what happens when the selection changes

    $('#year').on('change', function() {
      Cookies.set('year', $('#year').val());
      year = [];
      $("#year option:selected").each(function()
      {
        // log the value and text of each option
        year.push($(this).val());

      });
      activitiesTable.ajax.reload();
    });

    $('#manager').on('change', function() {
      Cookies.set('manager', $('#manager').val());
      manager = [];
      $("#manager option:selected").each(function()
      {
        // log the value and text of each option
        manager.push($(this).val());

      });
      activitiesTable.ajax.reload();
    });

    $('#user').on('change', function() {
      Cookies.set('user', $('#user').val());
      user = [];
      $("#user option:selected").each(function()
      {
        // log the value and text of each option
        user.push($(this).val());

      });
      activitiesTable.ajax.reload();
    });

    // SELECTIONS END
    //endregion

    activitiesTable = $('#activitiesTable').DataTable({
      scrollX: true,
      serverSide: true,
      processing: true,
      stateSave: true,
      ajax: {
        url: "{!! route('listOfLoadPerUserAjax') !!}",
        type: "POST",
        data: function ( d ) {
          $.extend(d,ajaxData());
        },
        dataType: "JSON",
        beforeSend: function() {
          //console.log(ajaxData());
        }
      },
      columns: [
        { name: 'manager_id', data: 'manager_id' , searchable: false , visible: false},
        { name: 'manager_name', data: 'manager_name', width: '150px' },
        { name: 'user_id', data: 'user_id' , searchable: false , visible: false},
        { name: 'user_name', data: 'user_name' , width: '150px'},
        { name: 'year', data: 'year'  , visible: false},
        @foreach(config('select.available_months') as $month_int => $month)

        { name: '{{ $month }}_com', data: function ( row, type, val, meta ){
            if (row.{{ $month }}_com>0) {
              month_com = row.{{ $month }}_com;
            } else {
              month_com = '';
            }  
            return month_com;
          },
          createdCell: function (td, cellData, rowData, row, col) {
            color_for_month_value(rowData.{{ $month }}_from_otl,td);
          }, width: '30px', searchable: false},

        { name: '{{ $month }}_bil', data: function ( row, type, val, meta ){
            if (row.{{ $month }}_com>0) {
              month_bil = row.{{ $month }}_bil;
            } else {
              month_bil = '';
            }  
            return month_bil;
          },
          createdCell: function (td, cellData, rowData, row, col) {
            //color_for_month_bil_value(rowData.{{ $month }}_from_otl,td);
          }, width: '30px', searchable: false},

        { data: function ( row, type, val, meta ) {
            if (row.{{ $month }}_com>0) {
              arvi = (row.{{ $month }}_bil/getWeekdaysInMonth({{ $month_int }}, row.year)*100).toFixed(1)+'%';
            } else {
              arvi = '';
            }
            return arvi;
          }, 
          createdCell: function (td, cellData, rowData, row, col) {
            //color_for_completion_value(prime_completion,td);
          }, width: '30px', searchable: false, orderable: false},

        { data: function ( row, type, val, meta ) {
            if (row.{{ $month }}_com>0) {
              prime_completion = (row.{{ $month }}_com/getWeekdaysInMonth({{ $month_int }}, row.year)*100).toFixed(1)+'%';
            } else {
              prime_completion = '';
            }
            return prime_completion;
          }, 
          createdCell: function (td, cellData, rowData, row, col) {
            prime_completion = rowData.{{ $month }}_com/getWeekdaysInMonth({{ $month_int }}, rowData.year)*100;
            color_for_completion_value(prime_completion,td);
          }, width: '30px', searchable: false, orderable: false},
        @endforeach

        { data: function ( row, type, val, meta ) {
            total = 0;
            @foreach(config('select.available_months_h1') as $month)
            
            if (row.{{ $month }}_bil>0) {
                total += row.{{ $month }}_bil;
              }
            @endforeach
            total = total*8;
            return total.toFixed(1);
          }, 
          createdCell: function (td, cellData, rowData, row, col) {
          }, width: '30px', searchable: false, orderable: false},

        { data: function ( row, type, val, meta ) {
            total = 0;
            @foreach(config('select.available_months_h2') as $month)
            
            if (row.{{ $month }}_bil>0) {
                total += row.{{ $month }}_bil;
              }
            @endforeach
            total = total*8;
            return total.toFixed(1);
          }, 
          createdCell: function (td, cellData, rowData, row, col) {
          }, width: '30px', searchable: false, orderable: false},

        { data: function ( row, type, val, meta ) {
            total = 0;
            @foreach(config('select.available_months') as $month)
            
            if (row.{{ $month }}_bil>0) {
                total += row.{{ $month }}_bil;
              }
            @endforeach
            total = total*8;
            return total.toFixed(1);
          }, 
          createdCell: function (td, cellData, rowData, row, col) {
          }, width: '30px', searchable: false, orderable: false},

      ],
      order: [[2, 'asc']],
      lengthMenu: [
          [ 10, 25, 50, -1 ],
          [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      dom: 'Bfrtip',
      buttons: [
        {
          extend: "colvis",
          className: "btn-sm",
          collectionLayout: "three-column",
          columns: [1,3,4
          @for ($i = 5; $i < 5+(4*12); $i++)
              ,{{ $i }}
          @endfor
          ,{{5+(4*12)}},{{5+(4*12)+1}},{{5+(4*12)+2}}
        ]
        },
        {
          extend: "pageLength",
          className: "btn-sm"
        },
        {
          extend: 'collection',
          className: "btn-sm",
          text: 'Views',
          buttons: [
              {
                text: 'H1',
                extend: 'colvisGroup',
                show: [ 1,3
                  @for ($i = 5; $i < 5+(4*6); $i++)
                    ,{{ $i }}
                  @endfor
                  ,{{5+(4*12)}}
                ],
                hide: [ 0,2,4
                  @for ($i = 5+(4*6); $i < 5+(4*12); $i++)
                    ,{{ $i }}
                  @endfor
                  ,{{5+(4*12)+1}},{{5+(4*12)+2}}
                ]
              },
              {
                text: 'H2',
                extend: 'colvisGroup',
                show: [ 1,3
                  @for ($i = 5+(4*6); $i < 5+(4*12); $i++)
                    ,{{ $i }}
                  @endfor
                  ,{{5+(4*12)+1}}
                ],
                hide: [ 0,2,4
                  @for ($i = 5; $i < 5+(4*6); $i++)
                    ,{{ $i }}
                  @endfor
                  ,{{5+(4*12)}},{{5+(4*12)+2}}
                 ]
              }
              ,
              {
                text: 'Full year',
                extend: 'colvisGroup',
                show: [ 1,3
                  @for ($i = 5; $i < 5+(4*12); $i++)
                      ,{{ $i }}
                  @endfor
                  ,{{5+(4*12)}},{{5+(4*12)+1}},{{5+(4*12)+2}}
                ],
                hide: [ 0,2,4 ]
              }
          ],
          responsive: true
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
      initComplete: function (json) {
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
        var state = activitiesTable.state.loaded();
        if (state) {
            activitiesTable.columns().eq(0).each(function (colIdx) {
                var colSearch = state.columns[colIdx].search;

                if (colSearch.search) {
                    $('input', activitiesTable.column(colIdx).footer()).val(colSearch.search);
                }
            });

            activitiesTable.draw();
        }
        //console.log(json.json.data);
      }
    });

    $(document).on('click', '#legendButton', function () {
    $('#legendModal').modal();
  });

  } );
  </script>
  @stop
