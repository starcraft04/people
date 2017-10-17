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
    <h3>Cluster Board</h3>
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
                  @if($key == $year) selected
                  @endif>
                  {{ $value }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-xs-2">
              <label for="month" class="control-label">Customer</label>
              <select class="form-control select2" style="width: 100%;" id="customer_list" name="customer_list" data-placeholder="Select a customer">
                <option></option>
                @foreach($customers_list as $key => $value)
                <option value="{{ $key }}"
                  @if($key == $customer_id) selected
                  @endif>
                  {{$value}}
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
        <h2>Top {{$top}} accounts per cluster</small></h2>
        <button id="legendButton" class="btn btn-success btn-sm" style="margin-left: 10px;">info</button>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <br />
        <!-- start accordion -->
        <div class="accordion" id="accordion" role="tablist" hide="true" aria-multiselectable="true">
        <?php $customer_i = 0; $cluster_i = 0; ?>
        @foreach($activities as $cluster => $customers)
          <div class="panel">
            <a class="panel-heading" role="tab" id="heading{{$cluster_i}}" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$cluster_i}}" aria-expanded="true" aria-controls="collapse{{$cluster_i}}">
            <p><strong>
            <h2 class="panel-title" align="center">{{$cluster}}</h2>
            </strong></p>
            </a>

            <div id="collapse{{$cluster_i}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$cluster_i}}">
              <div class="panel-body">
              
                @foreach($customers as $customer => $users)
                  <div class="row">
                  <div class="col-md-6"><span style="font-size:24px;">{{$customer}}</span>
                  <button type="button" id="customer_{{$customer_i}}" class="btn btn-success btn-xs btn-details">show details</button>
                  </div>
                  </div>
                  <!-- revenues -->
                  <div class="row">
                  <table id="table_revenue_customer_{{$customer_i}}" class="table table-bordered" style="display:none;">
                    <thead>
                      <tr>
                        <th>Product name</th>
                        <th>Product code</th>
                        <th>Year</th>
                        <th>Jan</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Apr</th>
                        <th>May</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Aug</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dec</th>
                      </tr>
                    </thead>
                    @if(isset($revenues[$customer]))
                    <tbody>
                      @foreach ($revenues[$customer] as $key => $revenue)
                      <tr>
                        <td style="width: 20%;"></td>
                        <td style="width: 15%;">{{$revenue->product_code}}</td>
                        <td style="width: 5%;">{{$revenue->year}}</td>
                        <td style="width: 5%;">{{number_format($revenue->jan,0,'.','')}}</td>
                        <td style="width: 5%;">{{number_format($revenue->feb,0,'.','')}}</td>
                        <td style="width: 5%;">{{number_format($revenue->mar,0,'.','')}}</td>
                        <td style="width: 5%;">{{number_format($revenue->apr,0,'.','')}}</td>
                        <td style="width: 5%;">{{number_format($revenue->may,0,'.','')}}</td>
                        <td style="width: 5%;">{{number_format($revenue->jun,0,'.','')}}</td>
                        <td style="width: 5%;">{{number_format($revenue->jul,0,'.','')}}</td>
                        <td style="width: 5%;">{{number_format($revenue->aug,0,'.','')}}</td>
                        <td style="width: 5%;">{{number_format($revenue->sep,0,'.','')}}</td>
                        <td style="width: 5%;">{{number_format($revenue->oct,0,'.','')}}</td>
                        <td style="width: 5%;">{{number_format($revenue->nov,0,'.','')}}</td>
                        <td>{{number_format($revenue->dec,0,'.','')}}</td>                        
                      </tr>
                      @endforeach
                    </tbody>
                    @endif
                  </table>
                  </div>
                  <!-- revenues -->
                  <!-- activities per user -->
                  <div class="row">
                  <table id="table_customer_{{$customer_i}}" class="table table-bordered" style="display:none;">
                    <thead>
                      <tr>
                        <th>Project name</th>
                        <th>Consultant</th>
                        <th>Year</th>
                        <th>Jan</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Apr</th>
                        <th>May</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Aug</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dec</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($users as $key => $activity)
                      <tr>
                        <td style="width: 20%;">{{$activity->project_name}}</td>
                        <td style="width: 15%;">{{$activity->user_name}}</td>
                        <td style="width: 5%;">{{$activity->year}}</td>
                        <td style="width: 5%;@if($activity->jan_otl == 1)color:green;font-weight: bold;@endif">
                          @if($activity->jan_com != 0){{$activity->jan_com}}@endif
                        </td>
                        <td style="width: 5%;@if($activity->feb_otl == 1)color:green;font-weight: bold;@endif">
                          @if($activity->feb_com != 0){{$activity->feb_com}}@endif
                        </td>
                        <td style="width: 5%;@if($activity->mar_otl == 1)color:green;font-weight: bold;@endif">
                          @if($activity->mar_com != 0){{$activity->mar_com}}@endif
                        </td>
                        <td style="width: 5%;@if($activity->apr_otl == 1)color:green;font-weight: bold;@endif">
                          @if($activity->apr_com != 0){{$activity->apr_com}}@endif
                        </td>
                        <td style="width: 5%;@if($activity->may_otl == 1)color:green;font-weight: bold;@endif">
                          @if($activity->may_com != 0){{$activity->may_com}}@endif
                        </td>
                        <td style="width: 5%;@if($activity->jun_otl == 1)color:green;font-weight: bold;@endif">
                          @if($activity->jun_com != 0){{$activity->jun_com}}@endif
                        </td>
                        <td style="width: 5%;@if($activity->jul_otl == 1)color:green;font-weight: bold;@endif">
                          @if($activity->jul_com != 0){{$activity->jul_com}}@endif
                        </td>
                        <td style="width: 5%;@if($activity->aug_otl == 1)color:green;font-weight: bold;@endif">
                          @if($activity->aug_com != 0){{$activity->aug_com}}@endif
                        </td>
                        <td style="width: 5%;@if($activity->sep_otl == 1)color:green;font-weight: bold;@endif">
                          @if($activity->sep_com != 0){{$activity->sep_com}}@endif
                        </td>
                        <td style="width: 5%;@if($activity->oct_otl == 1)color:green;font-weight: bold;@endif">
                          @if($activity->oct_com != 0){{$activity->oct_com}}@endif
                        </td>
                        <td style="width: 5%;@if($activity->nov_otl == 1)color:green;font-weight: bold;@endif">
                          @if($activity->nov_com != 0){{$activity->nov_com}}@endif
                        </td>
                        <td style="width: 5%;@if($activity->dec_otl == 1)color:green;font-weight: bold;@endif">
                          @if($activity->dec_com != 0){{$activity->dec_com}}@endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  </div>
                  <!-- activities per user -->
                  <?php $customer_i++; ?>
                @endforeach
              </div>
            </div>
          </div>
          <?php $cluster_i++; ?>
        @endforeach

        </div>
        <!-- end accordion -->
          
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
                  Info
              </h4>
          </div>
            
          <!-- Modal Body -->
          <div class="modal-body">
          Those are the top {{$top}} accounts per cluster in number of hours spent for this year from consultants.</br>
        Green means it has been validated by OTL.</br>
        If you need to see more accounts per cluster, please click on your name (top right) and select profile.
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
<!-- Window -->
      </div>
    </div>
  </div>
@stop

@section('script')
<script>
$(document).ready(function() {
  $('#collapse0').addClass('in');
});
$(document).on('click', '.btn-details', function () {
  if ($(this).text() == 'show details') {
    $(this).html('hide details');
    $('#table_'+this.id).show();
    $('#table_revenue_'+this.id).show();
  } else {
    $(this).html('show details');
    $('#table_'+this.id).hide();
    $('#table_revenue_'+this.id).hide();
  }
});

$(document).on('click', '#legendButton', function () {
    $('#legendModal').modal();
  });

//Init select2 boxes
$("#year").select2({
  allowClear: false
});
$("#customer_list").select2({
  allowClear: true
});

$('#year,#customer_list').on('change', function() {
  year = $('#year').val();
  customer = $('#customer_list').val();
  if (customer) {
    window.location.href = "{!! route('clusterdashboard',['','']) !!}/"+year+"/"+customer;
  } else {
    window.location.href = "{!! route('clusterdashboard','') !!}/"+year;
  }
});


</script>
@stop