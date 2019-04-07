@extends('layouts.app')

@section('content')

<!-- Window -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window title -->
      <div class="x_title">
        <h2>Help</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
          <div class="row">
            1) Connect to Clear Time View and select your team.</BR><img src="{{ asset('/img/help/OTL_HELP_01_CTV_selection.png') }}"></BR></BR></BR>
            2) Go to Reports/time sheets overview.</BR><img src="{{ asset('/img/help/OTL_HELP_02_report_selection.png') }}"></BR></BR></BR>
            3) Select under timeline the year and months you want, under dimension and measures, select what you see on the picture. Then under reports, at the right, click on the export to excel button.</BR><img src="{{ asset('/img/help/OTL_HELP_03_extract_to_excel.png') }}"></BR></BR></BR>
            4) Open the excel file you got and save it (you may need to do this operation in order for this to work as the format as to be corrected from what you got from CTV). Then Upload your file.</BR></BR></BR>
            5) Look if you get any errors from the upload. You can export the errors to CSV and send to your team for correction.</BR><img src="{{ asset('/img/help/OTL_HELP_07_results.png') }}"></BR></BR></BR>
          </div>

      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->
@stop
