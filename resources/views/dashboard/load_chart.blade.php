@extends('layouts.app')

@section('style')
<!-- CSS -->
<!-- Select2 -->
<link href="{{ asset('/plugins/gentelella/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('scriptsrc')
<!-- JS -->
<!-- Select2 -->
<script src="{{ asset('/plugins/gentelella/vendors/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
<!-- ChartJs -->
<script src="{{ asset('/plugins/chartjs/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('/plugins/chartjs/FileSaver.js') }}"></script>
<script src="{{ asset('/plugins/chartjs/canvas-to-blob.js') }}"></script>
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Load chart</h3>
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
        <h2>Chart</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <button id="save_chart" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-camera"></span> Save chart</button>
      <div class="x_content">
          <canvas id="barChart"></canvas>
      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->

  @stop

  @section('script')
  <script>
  var barChart;
  var year = [];
  var manager = [];
  var user = [];
  var myvar='';

  function ajaxDataPOST(){
    var obj = {
      'year[]': year,
      'manager[]': manager,
      'user[]': user
    };
    return obj;
  };
  function ajaxdscvstotal(){
    var myarray = [
      myvar.dscvstotal[0].jan_com,
      myvar.dscvstotal[0].feb_com,
      myvar.dscvstotal[0].mar_com,
      myvar.dscvstotal[0].apr_com,
      myvar.dscvstotal[0].may_com,
      myvar.dscvstotal[0].jun_com,
      myvar.dscvstotal[0].jul_com,
      myvar.dscvstotal[0].aug_com,
      myvar.dscvstotal[0].sep_com,
      myvar.dscvstotal[0].oct_com,
      myvar.dscvstotal[0].nov_com,
      myvar.dscvstotal[0].dec_com
    ];
    return myarray;
  };
  function ajaxtheoreticalCapacity(){
    var myarray = [
      myvar.theoreticalCapacity[0].jan_com,
      myvar.theoreticalCapacity[0].feb_com,
      myvar.theoreticalCapacity[0].mar_com,
      myvar.theoreticalCapacity[0].apr_com,
      myvar.theoreticalCapacity[0].may_com,
      myvar.theoreticalCapacity[0].jun_com,
      myvar.theoreticalCapacity[0].jul_com,
      myvar.theoreticalCapacity[0].aug_com,
      myvar.theoreticalCapacity[0].sep_com,
      myvar.theoreticalCapacity[0].oct_com,
      myvar.theoreticalCapacity[0].nov_com,
      myvar.theoreticalCapacity[0].dec_com
    ];
    return myarray;
  };
  function ajaxdscpipeline(){
    var myarray = [
      myvar.dscpipeline[0].jan_com,
      myvar.dscpipeline[0].feb_com,
      myvar.dscpipeline[0].mar_com,
      myvar.dscpipeline[0].apr_com,
      myvar.dscpipeline[0].may_com,
      myvar.dscpipeline[0].jun_com,
      myvar.dscpipeline[0].jul_com,
      myvar.dscpipeline[0].aug_com,
      myvar.dscpipeline[0].sep_com,
      myvar.dscpipeline[0].oct_com,
      myvar.dscpipeline[0].nov_com,
      myvar.dscpipeline[0].dec_com
    ];
    return myarray;
  };
  function ajaxiscpipeline(){
    var myarray = [
      myvar.iscpipeline[0].jan_com,
      myvar.iscpipeline[0].feb_com,
      myvar.iscpipeline[0].mar_com,
      myvar.iscpipeline[0].apr_com,
      myvar.iscpipeline[0].may_com,
      myvar.iscpipeline[0].jun_com,
      myvar.iscpipeline[0].jul_com,
      myvar.iscpipeline[0].aug_com,
      myvar.iscpipeline[0].sep_com,
      myvar.iscpipeline[0].oct_com,
      myvar.iscpipeline[0].nov_com,
      myvar.iscpipeline[0].dec_com
    ];
    return myarray;
  };
  function ajaxdscstarted(){
    var myarray = [
      myvar.dscstarted[0].jan_com,
      myvar.dscstarted[0].feb_com,
      myvar.dscstarted[0].mar_com,
      myvar.dscstarted[0].apr_com,
      myvar.dscstarted[0].may_com,
      myvar.dscstarted[0].jun_com,
      myvar.dscstarted[0].jul_com,
      myvar.dscstarted[0].aug_com,
      myvar.dscstarted[0].sep_com,
      myvar.dscstarted[0].oct_com,
      myvar.dscstarted[0].nov_com,
      myvar.dscstarted[0].dec_com
    ];
    return myarray;
  };
  function ajaxiscstarted(){
    var myarray = [
      myvar.iscstarted[0].jan_com,
      myvar.iscstarted[0].feb_com,
      myvar.iscstarted[0].mar_com,
      myvar.iscstarted[0].apr_com,
      myvar.iscstarted[0].may_com,
      myvar.iscstarted[0].jun_com,
      myvar.iscstarted[0].jul_com,
      myvar.iscstarted[0].aug_com,
      myvar.iscstarted[0].sep_com,
      myvar.iscstarted[0].oct_com,
      myvar.iscstarted[0].nov_com,
      myvar.iscstarted[0].dec_com
    ];
    return myarray;
  };
  function ajaxorange(){
    var myarray = [
      myvar.orange[0].jan_com,
      myvar.orange[0].feb_com,
      myvar.orange[0].mar_com,
      myvar.orange[0].apr_com,
      myvar.orange[0].may_com,
      myvar.orange[0].jun_com,
      myvar.orange[0].jul_com,
      myvar.orange[0].aug_com,
      myvar.orange[0].sep_com,
      myvar.orange[0].oct_com,
      myvar.orange[0].nov_com,
      myvar.orange[0].dec_com
    ];
    return myarray;
  };
  function ajaxpresales(){
    var myarray = [
      myvar.presales[0].jan_com,
      myvar.presales[0].feb_com,
      myvar.presales[0].mar_com,
      myvar.presales[0].apr_com,
      myvar.presales[0].may_com,
      myvar.presales[0].jun_com,
      myvar.presales[0].jul_com,
      myvar.presales[0].aug_com,
      myvar.presales[0].sep_com,
      myvar.presales[0].oct_com,
      myvar.presales[0].nov_com,
      myvar.presales[0].dec_com
    ];
    return myarray;
  };
  window.chartColors = {
   red: 'rgb(255, 99, 132)',
   orange: 'rgb(255, 159, 64)',
   yellow: 'rgb(255, 205, 86)',
   green: 'rgb(0, 204, 102)',
   green_light: 'rgb(26, 255, 140)',
   blue: 'rgb(0, 51, 255)',
   blue_light: 'rgb(77, 112, 235)',
   purple: 'rgb(153, 102, 255)',
   grey: 'rgb(201, 203, 207)'
  };

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

  $(document).ready(function() {
    // Init of save as button
    $("#save_chart").click(function(){
      $("#barChart").get(0).toBlob(function(blob){
        saveAs(blob, "chart.png")
      });
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
      $.ajax({
          url:"{!! route('listOfLoadPerUserChartAjax') !!}",
          type:'POST',
          data: ajaxDataPOST(),
          dataType:"JSON",
          success: function(data) {
            useReturnData(data);
            barChart.data.datasets[0].data = ajaxdscvstotal();
            barChart.data.datasets[1].data = ajaxtheoreticalCapacity();
            barChart.data.datasets[2].data = ajaxdscpipeline();
            barChart.data.datasets[3].data = ajaxiscpipeline();
            barChart.data.datasets[4].data = ajaxdscstarted();
            barChart.data.datasets[5].data = ajaxiscstarted();
            barChart.data.datasets[6].data = ajaxpresales();
            barChart.data.datasets[7].data = ajaxorange();
            console.log(barChart.data);
            barChart.update();
          }
        });
    });
    $('#manager').on('change', function() {
      Cookies.set('manager', $('#manager').val());
      manager = [];
      $("#manager option:selected").each(function()
      {
        // log the value and text of each option
        manager.push($(this).val());
      });
      $.ajax({
          url:"{!! route('listOfLoadPerUserChartAjax') !!}",
          type:'POST',
          data: ajaxDataPOST(),
          dataType:"JSON",
          success: function(data) {
            useReturnData(data);
            barChart.data.datasets[0].data = ajaxdscvstotal();
            barChart.data.datasets[1].data = ajaxtheoreticalCapacity();
            barChart.data.datasets[2].data = ajaxdscpipeline();
            barChart.data.datasets[3].data = ajaxiscpipeline();
            barChart.data.datasets[4].data = ajaxdscstarted();
            barChart.data.datasets[5].data = ajaxiscstarted();
            barChart.data.datasets[6].data = ajaxpresales();
            barChart.data.datasets[7].data = ajaxorange();
            console.log(barChart.data);
            barChart.update();
          }
        });
    });
    $('#user').on('change', function() {
      Cookies.set('user', $('#user').val());
      user = [];
      $("#user option:selected").each(function()
      {
        // log the value and text of each option
        user.push($(this).val());
      });
      $.ajax({
          url:"{!! route('listOfLoadPerUserChartAjax') !!}",
          type:'POST',
          data: ajaxDataPOST(),
          dataType:"JSON",
          success: function(data) {
            useReturnData(data);
            barChart.data.datasets[0].data = ajaxdscvstotal();
            barChart.data.datasets[1].data = ajaxtheoreticalCapacity();
            barChart.data.datasets[2].data = ajaxdscpipeline();
            barChart.data.datasets[3].data = ajaxiscpipeline();
            barChart.data.datasets[4].data = ajaxdscstarted();
            barChart.data.datasets[5].data = ajaxiscstarted();
            barChart.data.datasets[6].data = ajaxpresales();
            barChart.data.datasets[7].data = ajaxorange();
            console.log(barChart.data);
            barChart.update();
          }
        });
    });

    // SELECTIONS END

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    function useReturnData(data){
        myvar = data;
        //console.log(myvar);
    };
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */
     var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

     var color = Chart.helpers.color;
     var barChartData = {
         labels: MONTHS,
         datasets: [
          {
            type: 'line',
             label: 'DSC vs Total capacity',
             yAxisID: "y-axis-2",
             borderColor: window.chartColors.orange,
             borderWidth: 3,
             fill: false,
             data: []
          },
          {
          type: 'line',
           label: 'Theoretical capacity',
           yAxisID: "y-axis-1",
           borderColor: window.chartColors.red,
           borderWidth: 3,
           fill: false,
           pointRadius: 0,
           data: []
         },
          {
          type: 'bar',
           label: 'DSC Pipeline',
           yAxisID: "y-axis-1",
           stack: 'Stack 1',
           backgroundColor: color(window.chartColors.blue_light).alpha(0.7).rgbString(),
           borderColor: window.chartColors.blue_light,
           borderWidth: 1,
           data: []
          },
          {
          type: 'bar',
           label: 'ISC Pipeline',
           yAxisID: "y-axis-1",
           stack: 'Stack 1',
           backgroundColor: color(window.chartColors.green_light).alpha(0.7).rgbString(),
           borderColor: window.chartColors.green_light,
           borderWidth: 1,
           data: []
          },
          {
          type: 'bar',
           label: 'DSC Started',
           yAxisID: "y-axis-1",
           stack: 'Stack 1',
           backgroundColor: color(window.chartColors.blue).alpha(0.7).rgbString(),
           borderColor: window.chartColors.blue,
           borderWidth: 1,
           data: []
          },
          {
          type: 'bar',
           label: 'ISC Started',
           yAxisID: "y-axis-1",
           stack: 'Stack 1',
           backgroundColor: color(window.chartColors.green).alpha(0.7).rgbString(),
           borderColor: window.chartColors.green,
           borderWidth: 1,
           data: []
          },
          {
          type: 'bar',
           label: 'Pre-sales',
           yAxisID: "y-axis-1",
           stack: 'Stack 1',
           backgroundColor: color(window.chartColors.yellow).alpha(0.7).rgbString(),
           borderColor: window.chartColors.yellow,
           borderWidth: 1,
           data: []
          },
          {
          type: 'bar',
           label: 'Orange ABS or other',
           yAxisID: "y-axis-1",
           stack: 'Stack 1',
           backgroundColor: color(window.chartColors.grey).alpha(0.7).rgbString(),
           borderColor: window.chartColors.grey,
           borderWidth: 1,
           data: []
          }
        ]
     };
     $.ajax({
         url:"{!! route('listOfLoadPerUserChartAjax') !!}",
         type:'POST',
         data: ajaxDataPOST(),
         dataType:"JSON",
         beforeSend: function() {
           console.log(ajaxDataPOST());
         },
         success: function(data) {
           useReturnData(data);
           barChart.data.datasets[0].data = ajaxdscvstotal();
           barChart.data.datasets[1].data = ajaxtheoreticalCapacity();
           barChart.data.datasets[2].data = ajaxdscpipeline();
           barChart.data.datasets[3].data = ajaxiscpipeline();
           barChart.data.datasets[4].data = ajaxdscstarted();
           barChart.data.datasets[5].data = ajaxiscstarted();
           barChart.data.datasets[6].data = ajaxpresales();
           barChart.data.datasets[7].data = ajaxorange();
           console.log(barChart.data);
           barChart.update();
         }
       });
     //-------------
     //- BAR CHART -
     //-------------
     var barChartCanvas = $("#barChart").get(0).getContext("2d");
     var ctx = $('#barChart');
     ctx.attr('height',120);
     var barChartOptions = {
        responsive: true,
        title: {
            display: true,
            text: 'LoE Forecast vs Capacity'
        },
        scales: {
                    xAxes: [{
                            stacked: true,
                        }],
                    yAxes: [{
                        type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                        display: true,
                        position: "left",
                        id: "y-axis-1",
                        scaleLabel: {
                          display: true,
                          labelString: '# Mandays'
                        },
                        stacked: true
                        }, {
                        type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                        display: true,
                        position: "right",
                        id: "y-axis-2",
                        scaleLabel: {
                          display: true,
                          labelString: '%'
                        },
                        gridLines: {
                            drawOnChartArea: false
                        },
                        stacked: false,
                        ticks: {
                            beginAtZero: true,
                            min: 0,
                            max: 100
                        }
                    }],
                }
      };
     barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            });
  } );
  </script>
  @stop
