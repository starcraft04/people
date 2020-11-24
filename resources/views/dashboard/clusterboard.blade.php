@extends('layouts.app')

@section('style')
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('/css/datatables.css') }}">
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
            <div class="form-group col-xs-2">
              <label for="customer_list" class="control-label">Customer</label>
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
            <div class="form-group col-xs-2">
              <label for="domain" class="control-label">Domain</label>
              <select class="form-control select2" style="width: 100%;" id="domain" name="domain" data-placeholder="Select a domain">
                <option></option>
                @foreach(config('domains.domain-users') as $domain)
                <option value="{{ $domain }}"
                  @if($domain == $domain_selected) selected
                  @endif>
                  {{$domain}}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-xs-2">
            <label for="manager" class="control-label">Manager</label>
            <select class="form-control select2" style="width: 100%;" id="manager" name="manager" data-placeholder="Select a manager">
              <option></option>
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
            <select class="form-control select2" style="width: 100%;" id="user" name="user" data-placeholder="Select a user">
              <option></option>
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
        <h2>Top {{$top}} accounts per cluster<small> (in term of man days)</small></h2>
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
        <?php $customer_i = 0; ?>
        @foreach($activities as $cluster => $customers)
            <span class="cluster">{{$cluster}}</span>
              <div class="panel-body">
              
                @foreach($customers as $customer => $users)
                  <div class="row">
                  <div class="col-md-1">
                    <button type="button" id="customer_{{$customer_i}}" class="btn btn-success btn-xs btn-details">show details</button>
                  </div>

                  <div class="col-md-9">
                    <span class="customer">{{$customer}}</span>
                  </div>
                  <div class="col-md-2">
                    <span class="customer_total">Bill. Days Tot.: <b>{{number_format($grand_total[$customer]['activity'],0,'.','')}} days</b><BR>Rev. Tot.: <span class="@if($grand_total[$customer]['revenue'] <=0) no_revenue @endif"><b>{{number_format($grand_total[$customer]['revenue'],0,'.','')}} k€</b></span></span>
                  </div>
                  </div>
                  <!-- total -->
                  <div class="row">
                  <table class="table table-striped table-hover table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 30%;"></th>
                        <th style="width: 15%;"></th>
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
                      <tr class="table_customer_{{$customer_i}}" style="display:none;">
                        <td class="revenue_section">Revenue (k€)</td>
                        <td class="title_section">Product code</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      @if(isset($revenues[$customer]))
                      @foreach ($revenues[$customer] as $key => $revenue)
                      <tr class="table_customer_{{$customer_i}}" style="display:none;">
                        <td></td>
                        <td>{{$revenue->product_code}}</td>
                        <td class="@if($revenue->jan == 0) zero @elseif($revenue->jan_actuals == 1) otl @else forecast @endif">{{number_format($revenue->jan,2,'.','')}}</td>
                        <td class="@if($revenue->feb == 0) zero @elseif($revenue->feb_actuals == 1) otl @else forecast @endif">{{number_format($revenue->feb,2,'.','')}}</td>
                        <td class="@if($revenue->mar == 0) zero @elseif($revenue->mar_actuals == 1) otl @else forecast @endif">{{number_format($revenue->mar,2,'.','')}}</td>
                        <td class="@if($revenue->apr == 0) zero @elseif($revenue->apr_actuals == 1) otl @else forecast @endif">{{number_format($revenue->apr,2,'.','')}}</td>
                        <td class="@if($revenue->may == 0) zero @elseif($revenue->may_actuals == 1) otl @else forecast @endif">{{number_format($revenue->may,2,'.','')}}</td>
                        <td class="@if($revenue->jun == 0) zero @elseif($revenue->jun_actuals == 1) otl @else forecast @endif">{{number_format($revenue->jun,2,'.','')}}</td>
                        <td class="@if($revenue->jul == 0) zero @elseif($revenue->jul_actuals == 1) otl @else forecast @endif">{{number_format($revenue->jul,2,'.','')}}</td>
                        <td class="@if($revenue->aug == 0) zero @elseif($revenue->aug_actuals == 1) otl @else forecast @endif">{{number_format($revenue->aug,2,'.','')}}</td>
                        <td class="@if($revenue->sep == 0) zero @elseif($revenue->sep_actuals == 1) otl @else forecast @endif">{{number_format($revenue->sep,2,'.','')}}</td>
                        <td class="@if($revenue->oct == 0) zero @elseif($revenue->oct_actuals == 1) otl @else forecast @endif">{{number_format($revenue->oct,2,'.','')}}</td>
                        <td class="@if($revenue->nov == 0) zero @elseif($revenue->nov_actuals == 1) otl @else forecast @endif">{{number_format($revenue->nov,2,'.','')}}</td>
                        <td class="@if($revenue->dec == 0) zero @elseif($revenue->dec_actuals == 1) otl @else forecast @endif">{{number_format($revenue->dec,2,'.','')}}</td>                        
                      </tr>
                      @endforeach
                      @endif
                      <!-- total revenue -->
                      @if(isset($revenues_tot[$customer]))
                      <tr>
                        <td></td>
                        <td class="total_section">Total revenue (k€)</td>
                        <td class="total_section">{{number_format($revenues_tot[$customer]->jan,0,'.','')}}</td>
                        <td class="total_section">{{number_format($revenues_tot[$customer]->feb,0,'.','')}}</td>
                        <td class="total_section">{{number_format($revenues_tot[$customer]->mar,0,'.','')}}</td>
                        <td class="total_section">{{number_format($revenues_tot[$customer]->apr,0,'.','')}}</td>
                        <td class="total_section">{{number_format($revenues_tot[$customer]->may,0,'.','')}}</td>
                        <td class="total_section">{{number_format($revenues_tot[$customer]->jun,0,'.','')}}</td>
                        <td class="total_section">{{number_format($revenues_tot[$customer]->jul,0,'.','')}}</td>
                        <td class="total_section">{{number_format($revenues_tot[$customer]->aug,0,'.','')}}</td>
                        <td class="total_section">{{number_format($revenues_tot[$customer]->sep,0,'.','')}}</td>
                        <td class="total_section">{{number_format($revenues_tot[$customer]->oct,0,'.','')}}</td>
                        <td class="total_section">{{number_format($revenues_tot[$customer]->nov,0,'.','')}}</td>
                        <td class="total_section">{{number_format($revenues_tot[$customer]->dec,0,'.','')}}</td>                        
                      </tr>
                      @endif
                      <!-- total revenue -->
                      <tr class="table_customer_{{$customer_i}}" style="display:none;">
                        <td class="revenue_section">Consulting man days</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr class="table_customer_{{$customer_i}}" style="display:none;">
                        <td class="title_section">Project name</td>
                        <td class="title_section">Consultant</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      @foreach ($users as $key => $activity)
                      <tr class="table_customer_{{$customer_i}}" style="display:none;">
                        <td>{{$activity->project_name}}</td>
                        <td>{{$activity->user_name}}</td>
                        <td class="@if($activity->jan_com == 0) zero @elseif($activity->jan_from_otl == 1) otl @else forecast @endif">
                          {{$activity->jan_com}} 
                        </td>
                        <td class="@if($activity->feb_com == 0) zero @elseif($activity->feb_from_otl == 1) otl @else forecast @endif">
                          {{$activity->feb_com}}
                        </td>
                        <td class="@if($activity->mar_com == 0) zero @elseif($activity->mar_from_otl == 1) otl @else forecast @endif">
                          {{$activity->mar_com}}
                        </td>
                        <td class="@if($activity->apr_com == 0) zero @elseif($activity->apr_from_otl == 1) otl @else forecast @endif">
                          {{$activity->apr_com}}
                        </td>
                        <td class="@if($activity->may_com == 0) zero @elseif($activity->may_from_otl == 1) otl @else forecast @endif">
                          {{$activity->may_com}}
                        </td>
                        <td class="@if($activity->jun_com == 0) zero @elseif($activity->jun_from_otl == 1) otl @else forecast @endif">
                          {{$activity->jun_com}}
                        </td>
                        <td class="@if($activity->jul_com == 0) zero @elseif($activity->jul_from_otl == 1) otl @else forecast @endif">
                          {{$activity->jul_com}}
                        </td>
                        <td class="@if($activity->aug_com == 0) zero @elseif($activity->aug_from_otl == 1) otl @else forecast @endif">
                          {{$activity->aug_com}}
                        </td>
                        <td class="@if($activity->sep_com == 0) zero @elseif($activity->sep_from_otl == 1) otl @else forecast @endif">
                          {{$activity->sep_com}}
                        </td>
                        <td class="@if($activity->oct_com == 0) zero @elseif($activity->oct_from_otl == 1) otl @else forecast @endif">
                          {{$activity->oct_com}}
                        </td>
                        <td class="@if($activity->nov_com == 0) zero @elseif($activity->nov_from_otl == 1) otl @else forecast @endif">
                          {{$activity->nov_com}}
                        </td>
                        <td class="@if($activity->dec_com == 0) zero @elseif($activity->dec_from_otl == 1) otl @else forecast @endif">
                          {{$activity->dec_com}}
                        </td>
                      </tr>
                      @endforeach
                      <!-- total activities -->
                      @if(isset($activities_tot[$customer]))
                      <tr>
                        <td></td>
                        <td class="total_section">Total man days</td>
                        <td class="total_section">{{number_format($activities_tot[$customer]->jan_com,0,'.','')}}</td>
                        <td class="total_section">{{number_format($activities_tot[$customer]->feb_com,0,'.','')}}</td>
                        <td class="total_section">{{number_format($activities_tot[$customer]->mar_com,0,'.','')}}</td>
                        <td class="total_section">{{number_format($activities_tot[$customer]->apr_com,0,'.','')}}</td>
                        <td class="total_section">{{number_format($activities_tot[$customer]->may_com,0,'.','')}}</td>
                        <td class="total_section">{{number_format($activities_tot[$customer]->jun_com,0,'.','')}}</td>
                        <td class="total_section">{{number_format($activities_tot[$customer]->jul_com,0,'.','')}}</td>
                        <td class="total_section">{{number_format($activities_tot[$customer]->aug_com,0,'.','')}}</td>
                        <td class="total_section">{{number_format($activities_tot[$customer]->sep_com,0,'.','')}}</td>
                        <td class="total_section">{{number_format($activities_tot[$customer]->oct_com,0,'.','')}}</td>
                        <td class="total_section">{{number_format($activities_tot[$customer]->nov_com,0,'.','')}}</td>
                        <td class="total_section">{{number_format($activities_tot[$customer]->dec_com,0,'.','')}}</td>                        
                      </tr>
                      @endif
                      <!-- total activities -->
                    </tbody>
                  </table>
                  </div>
                  <!-- total -->
                  <?php $customer_i++; ?>
                @endforeach
              </div>
        @endforeach

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
          Those are the top {{$top}} accounts per cluster in number of days spent for this year from consultants.</br>
          For the revenue (coming from TSPR file), green means it is actuals and blue means it is forecast.</br>
        For the man days, green means it has been validated by Prime.</br>
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
    $('.table_'+this.id).show();
  } else {
    $(this).html('show details');
    $('.table_'+this.id).hide();
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
  allowClear: true,
  disabled: {{ $customer_disabled }}
});
$("#domain").select2({
  allowClear: true
});
$("#manager").select2({
  allowClear: true,
  disabled: {{ $manager_disabled }}
});
$("#user").select2({
  allowClear: true,
  disabled: {{ $user_disabled }}
});

$('#year,#customer_list,#domain,#manager,#user').on('change', function() {
  year = $('#year').val();
  customer = $('#customer_list').val();
  domain = $('#domain').val();
  manager = $('#manager').val();
  user = $('#user').val();
  if (!customer) {
    customer = '0';
  }
  if (!domain) {
    domain = 'all';
  }
  if (!manager) {
    manager = '0';
  }
  if (!user) {
    user = '0';
  }
  window.location.href = "{!! route('clusterdashboard',['','']) !!}/"+year+"/"+customer+"/"+domain+"/"+manager+"/"+user;
});


</script>
@stop