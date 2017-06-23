@extends('layouts.app')


@section('scriptsrc')
<!-- JS -->
<!-- ChartJs -->
<script src="{{ asset('/plugins/chartjs/Chart.bundle.js') }}" type="text/javascript"></script>
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
        <h2>Chart</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
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
  $(document).ready(function() {

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
          type: 'bar',
           label: 'ISC Pre-Sales',
           backgroundColor: color(window.chartColors.green_light).alpha(0.5).rgbString(),
           borderColor: window.chartColors.green_light,
           borderWidth: 1,
           data: [5,8,5,3,4,7,10,6,2,8,4,9]
          }
        ]
     };

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
