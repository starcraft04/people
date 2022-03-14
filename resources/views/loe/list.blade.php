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
    <!-- Switchery -->
    <link href="{{ asset('/plugins/gentelella/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
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
    <script src="{{ asset('/plugins/bootbox/bootbox.min.js') }}"></script>script>
    <!-- Switchery -->
    <script src="{{ asset('/plugins/gentelella/vendors/switchery/dist/switchery.min.js') }}" type="text/javascript"></script>

    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>LOE Dashboard</h3>
  </div>
</div>
<div class="clearfix"></div>
<!-- Page title -->

<!-- Window -->
<div class="row">
         <!-- Selections for the table -->

 <!-- Selections for the table -->

        <!-- Selections for the table -->
       
      <!-- Window title -->
      <div class="x_title">
        <h2>List</small></h2>
        
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->
      
        <!-- Main table -->
        <div class="table-responsive">
          <table id="requestsTable" class="table table-striped table-hover table-bordered mytable" style="    overflow-x: auto;">
          <thead>
              <tr>
                  <th colspan="6">Project Details</th>
                  <th colspan="4">Off shore</th>
                  <th colspan="4">On shore</th>
                  <th colspan="4">Near shore</th>
                  <th colspan="3">Totals</th>

              </tr>
              <tr>
                <th data-field="project_id">Project ID</th>

                <th data-field="project_name" style="width:10px;">Customer</th>
                <th data-field="project_name" style="width:10px;">Project_name</th>
                <th data-field="pahse" style="width:10px;">phase</th>
                <th data-field="pahse" style="width:10px;">Quantity</th>
                <th data-field="pahse" style="width:10px;">Loe per quantity</th>
                <th data-field="percentage" style="width:10px;">%</th>
                <th data-field="md" style="width:10px;">MD</th>
                <th data-field="cost" >Cost</th>
                <th data-field="price" >Price</th>
                <th data-field="percentage" style="width:10px;">%</th>
                <th data-field="md" style="width:10px;">MD</th>
                <th data-field="cost" >Cost</th>
                <th data-field="price" >Price</th>
                <th data-field="percentage" style="width:10px;">%</th>
                <th data-field="md" style="width:10px;">MD</th>
                <th data-field="cost" >Cost</th>
                <th data-field="price" >Price</th>

                <th data-field="margin" style="width:10px;">Margin</th>
                <th data-field="total cost" >Total Cost</th>
                <th data-field="total price" >Total Price</th>
              </tr>
          </thead>
          <tbody>
            @foreach($all as $key)
            @php
            $total_price = ((($key->off_percentage * $key->loe_per_quantity)/100)*$key->off_price)+((($key->on_percent* $key->loe_per_quantity)/100)*$key->on_price)+((($key->near_percentage * $key->loe_per_quantity)/100)*$key->near_price);

            $total_cost = ((($key->off_percentage * $key->loe_per_quantity)/100)*$key->off_cost)+((($key->on_percent* $key->loe_per_quantity)/100)*$key->on_cost)+((($key->near_percentage * $key->loe_per_quantity)/100)*$key->near_cost);
            if($total_cost == 0){
              $margin = 0;
            }else{
             $margin = round(100*($total_price-$total_cost)/$total_cost); 
            }
            
            @endphp

           <tr>
             <td>{{$key->id}}</td>
             <td>{{$key->name}}</td>
             <td><a href="{!! route('loeView','') !!}/{{$key->id}}">{{$key->project_name}}</a></td>
             <td>{{$key->main_phase}}</td>
             <td>{{$key->quantity}}</td>
             <td>{{$key->loe_per_quantity}}</td>
             <td>{{$key->off_percentage}}</td>             
             <td>{{($key->off_percentage * $key->loe_per_quantity)/100}}</td>
             <td>{{$key->off_cost}}</td>
             <td>{{$key->off_price}}</td>
             <td>{{$key->on_percent}}</td>
             <td>{{($key->on_percent * $key->loe_per_quantity)/100}}</td>
             <td>{{$key->on_cost}}</td>
             <td>{{$key->on_price}}</td>             
             <td>{{$key->near_percentage}}</td>                          
             <td>{{($key->near_percentage * $key->loe_per_quantity)/100}}</td>
             <td>{{$key->near_cost}}</td>
             <td>{{$key->near_price}}</td>

             <td>{{$margin}}</td>

             <td>{{((($key->off_percentage * $key->loe_per_quantity)/100)*$key->off_cost)+((($key->on_percent* $key->loe_per_quantity)/100)*$key->on_cost)+((($key->near_percentage * $key->loe_per_quantity)/100)*$key->near_cost)}}</td>
             <td>{{((($key->off_percentage * $key->loe_per_quantity)/100)*$key->off_price)+((($key->on_percent* $key->loe_per_quantity)/100)*$key->on_price)+((($key->near_percentage * $key->loe_per_quantity)/100)*$key->near_price)}}</td>
           </tr>
           @endforeach
          </tbody>
        </table>
        </div>
        <!-- Main table -->

      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->

@stop

  @section('script')
<script type="text/javascript">


    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    //region Selection
    // SELECTIONS START
    // ________________
    // First we define the select2 boxes

    //Init select2 boxes



   // $.ajax({

   // 	url:"{!! route('listAllLoe') !!}",
   // 	success:function(data){
   // 		console.log(data);
   // 	}
   // });


$.ajax({
   url: "{!! route('listAllLoe') !!}",
   type:"GET",
   dataType:"JSON",
   success:function(data){
    console.log(data);
   }
});



</script>
@stop