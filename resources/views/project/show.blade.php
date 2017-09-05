@extends('layouts.app')

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Project</h3>
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
        <h2>Info</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
<div class="x_content" align="center">
        <br />
        <h2><p align="center" > {!! $project->project_name !!}</p></h2>
      

        <div class="row" style="width: 70%;" align="left">

          <div class="col-sm-12" style="background-color:lavender;">
          <p> <b> Customer name: </b> {!! $customer[0]->name !!} </p>
          </div>

          <div class="col-sm-12" style="background-color:lavenderblush;">
          <p> <b>OTL project code:</b> {!! $project->otl_project_code !!} </p>
          </div>
          <div class="col-sm-12" style="background-color:lavender;">
          <p> <b>Meta-activity: </b> {!! $project->meta_activity !!} </p>
          </div>

          <div class="col-sm-12" style="background-color:lavenderblush;">
          <p> <b>Project type:</b> {!! $project->project_type !!} </p>
          </div>
          <div class="col-sm-12" style="background-color:lavender;">
          <p> <b>Activity type:</b> {!! $project->activity_type !!} </p>
          </div>

          <div class="col-sm-12" style="background-color:lavenderblush;">
          <p> <b>Project status:</b> {!! $project->project_status !!} </p>
          </div>
          <div class="col-sm-12" style="background-color:lavender;">
          <p> <b>Region:</b> {!! $project->region !!} </p>
          </div>

          <div class="col-sm-12" style="background-color:lavenderblush;">
          <p> <b>Country: </b> {!! $project->country !!} </p>
          </div>
          <div class="col-sm-12" style="background-color:lavender;">
          <p> <b>Customer location:</b> {!! $project->customer_location !!} </p>
          </div>

          <div class="col-sm-12" style="background-color:lavenderblush;">
          <p> <b>Technology: </b> {!! $project->technology !!} </p>
          </div>
          <div class="col-sm-12" style="background-color:lavender;">
          <p> <b>description:</b> {!! $project->description !!} </p>
          </div>

          <div class="col-sm-12" style="background-color:lavenderblush;">
          <p> <b>Comments: </b> {!! $project->comments !!} </p>
          </div>
          <div class="col-sm-12" style="background-color:lavender;">
          <p> <b>Estimated start date:</b> {!! $project->estimated_start_date !!} </p>
          </div>

          <div class="col-sm-12" style="background-color:lavenderblush;">
          <p> <b>Estimated end date: </b> {!! $project->estimated_end_date !!} </p>
          </div>
          <div class="col-sm-12" style="background-color:lavender;">
          <p> <b>LoE onshore (days):</b> {!! $project->LoE_onshore !!} </p>
          </div>

          <div class="col-sm-12" style="background-color:lavenderblush;">
          <p> <b>LoE nearshore (days): </b> {!! $project->LoE_nearshore !!} </p>
          </div>
          <div class="col-sm-12" style="background-color:lavender;">
          <p> <b>LoE offshore (days):</b> {!! $project->LoE_offshore !!} </p>
          </div>

          <div class="col-sm-12" style="background-color:lavenderblush;">
          <p> <b>LoE contractor (days): </b> {!! $project->LoE_contractor !!}  </p>
          </div>
          <div class="col-sm-12" style="background-color:lavender;">
          <p> <b>Gold order:</b> {!! $project->gold_order_number !!} </p>
          </div>

          <div class="col-sm-12" style="background-color:lavenderblush;">
          <p> <b>Product code: </b> {!! $project->product_code !!} </p>
          </div>
          <div class="col-sm-12" style="background-color:lavender;">
          <p> <b>Revenue (€):</b> {!! $project->revenue !!} </p>
          </div>
          <div class="col-sm-12" style="background-color:lavenderblush;">
          <p> <b>Win ratio (%): </b> {!! $project->win_ratio !!} </p>
          </div>


        </div>

      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->
@stop
