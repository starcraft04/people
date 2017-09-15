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
        <!-- start accordion -->
        <div class="accordion" id="accordion" role="tablist" hide="true" aria-multiselectable="true">
          
        @foreach($activities as $country => $customers)
          <div class="panel">
            <a class="panel-heading" role="tab" id="heading{{$country}}" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$country}}" aria-expanded="true" aria-controls="collapse{{$country}}">
            <p><strong>
            <h2 class="panel-title" align="center">{{$country}}</h2>
            </strong></p>
            </a>

            <div id="collapse{{$country}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{{$country}}">
              <div class="panel-body">
                @foreach($customers as $customer => $users)
                  <div class="row">
                  <div class="col-md-6"><span style="font-size:24px;">{{$customer}}</span>
                  <button type="button" id="{{str_replace(' ', '', $customer)}}" class="btn btn-success btn-xs btn-details">show details</button>
                  </div>
                  </div>
                  <div class="row">
                  <table id="table_{{str_replace(' ', '', $customer)}}" class="table table-bordered" style="display:none;">
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
                        <td>{{$activity->project_name}}</td>
                        <td>{{$activity->user_name}}</td>
                        <td>{{$activity->year}}</td>
                        <td @if($activity->jan_otl == 1)style="color:green;font-weight: bold;"@endif>
                          @if($activity->jan_com != 0){{$activity->jan_com}}@endif
                        </td>
                        <td @if($activity->feb_otl == 1)style="color:green;font-weight: bold;"@endif>
                          @if($activity->feb_com != 0){{$activity->feb_com}}@endif
                        </td>
                        <td @if($activity->mar_otl == 1)style="color:green;font-weight: bold;"@endif>
                          @if($activity->mar_com != 0){{$activity->mar_com}}@endif
                        </td>
                        <td @if($activity->apr_otl == 1)style="color:green;font-weight: bold;"@endif>
                          @if($activity->apr_com != 0){{$activity->apr_com}}@endif
                        </td>
                        <td @if($activity->may_otl == 1)style="color:green;font-weight: bold;"@endif>
                          @if($activity->may_com != 0){{$activity->may_com}}@endif
                        </td>
                        <td @if($activity->jun_otl == 1)style="color:green;font-weight: bold;"@endif>
                          @if($activity->jun_com != 0){{$activity->jun_com}}@endif
                        </td>
                        <td @if($activity->jul_otl == 1)style="color:green;font-weight: bold;"@endif>
                          @if($activity->jul_com != 0){{$activity->jul_com}}@endif
                        </td>
                        <td @if($activity->aug_otl == 1)style="color:green;font-weight: bold;"@endif>
                          @if($activity->aug_com != 0){{$activity->aug_com}}@endif
                        </td>
                        <td @if($activity->sep_otl == 1)style="color:green;font-weight: bold;"@endif>
                          @if($activity->sep_com != 0){{$activity->sep_com}}@endif
                        </td>
                        <td @if($activity->oct_otl == 1)style="color:green;font-weight: bold;"@endif>
                          @if($activity->oct_com != 0){{$activity->oct_com}}@endif
                        </td>
                        <td @if($activity->nov_otl == 1)style="color:green;font-weight: bold;"@endif>
                          @if($activity->nov_com != 0){{$activity->nov_com}}@endif
                        </td>
                        <td @if($activity->dec_otl == 1)style="color:green;font-weight: bold;"@endif>
                          @if($activity->dec_com != 0){{$activity->dec_com}}@endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  </div>  
                @endforeach
              </div>
            </div>
          </div>
        @endforeach

        </div>
        <!-- end accordion -->
          
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

$(document).on('click', '.btn-details', function () {
  if ($(this).text() == 'show details') {
    $(this).html('hide details');
    $('#table_'+this.id).show();
  } else {
    $(this).html('show details');
    $('#table_'+this.id).hide();
  }
});

</script>
@stop