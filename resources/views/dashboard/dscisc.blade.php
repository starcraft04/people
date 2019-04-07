@extends('layouts.app')

@section('style')
    <!-- CSS -->
    <!-- Select2 -->
    <link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('scriptsrc')
    <!-- JS -->
    <!-- Select2 -->
    <script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
    <!-- Bootbox -->
    <script src="{{ asset('/plugins/bootbox/bootbox.min.js') }}"></script>
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>ASC vs ISC</h3>
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
        <h2>Report</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        @foreach($dscvsisc as $manager => $employee)
          <div class="row">
          <div class="col-md-12"><span style="font-size:24px;">Manager: {{$manager}}</span></div>
          @foreach($employee as $employee_name => $activities)
          <div class="col-md-12"><span style="font-size:16px;">{{$employee_name}}</span></div>
          <div class="col-md-6">
            <span style="font-size:12px;">ASC - {{round($activities['totaldscdays'],2)}}%</span>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Customer</th>
                  <th>Days (%)</th>
                </tr>
              </thead>
              <tbody>
                @foreach($activities['dsclist'] as $key => $activity)
                  <tr>
                    <td>{{$activity->name}}</td>
                    <td>{{round($activity->sum_task,2)}}%</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="col-md-6">
            <span style="font-size:12px;">ISC - {{round($activities['totaliscdays'],2)}}%</span>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Customer</th>
                  <th>Days (%)</th>
                </tr>
              </thead>
              <tbody>
                @foreach($activities['isclist'] as $key => $activity)
                  <tr>
                    <td>{{$activity->name}}</td>
                    <td>{{round($activity->sum_task,2)}}%</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @endforeach
          </div>
        @endforeach
      </div>
      <!-- Window content -->
    </div>
  </div>
</div>
<!-- Window -->
      </div>
    </div>
  </div>
@stop

@section('script')
<script>

//Init select2 boxes
$("#year").select2({
  allowClear: false
});

$('#year').on('change', function() {
  year = $('#year').val();
  window.location.href = "{!! route('dashboarddscisc') !!}/"+year;
});


</script>
@stop