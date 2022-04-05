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
      
       <!-- Modal Assign User to project Start-->
      <div class="modal fade" id="project_data" role="dialog" aria- 
            labelledby="assign_user_modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="demoModalLabel">Project Details</h5>
                <button type="button" id=close-btn class="close" data-dismiss="modal" aria- 
                                label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
              <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Location</th>
                      <th scope="col">Cost</th>
                      <th scope="col">Price</th>
                    </tr>
                  </thead>
                  <tbody id="modal-data">
                  </tbody>
                </table>

                    
            </div>

            <div class="modal-footer">
                
            </div>
          </div>
        </div>
      </div>


        <!-- Main table -->
        <div class="table-responsive">
          <table id="requestsTable" class="table table-striped table-hover table-bordered mytable" style="    overflow-x: auto;">
          <thead>
              <tr>
                  <th colspan="7">Project Details</th>
                  <th colspan="4">Off shore</th>
                  <th colspan="4">On shore</th>
                  <th colspan="4">Near shore</th>
                  <th colspan="3">Totals</th>

              </tr>
              <tr>
                <th data-field="project_id">Project ID</th>
                <th>LOE ID</th>

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
            @php
            $sumCost = [];
            $sumPrice = [];
            $margin =  [];
            @endphp
            @foreach($check as $cKey)

             @php 

                if(isset($sumPrice[$cKey->id]) && isset($sumCost[$cKey->id]))
                {
                  
                  $sumPrice[$cKey->id] += round(((($cKey->percentage*$cKey->loe_per_quantity)/100)*$cKey->price));
                  
                  $sumCost[$cKey->id] += round(((($cKey->percentage*$cKey->loe_per_quantity)/100)*$cKey->cost));

                   if($sumCost[$cKey->id] == 0)
                  {
                    $margin[$cKey->id] = 0;
                  }
                  else{
                    $margin[$cKey->id] = round((100*($sumPrice[$cKey->id] -$sumCost[$cKey->id])/$sumCost[$cKey->id]));
                  }

                }
                else if(!isset($sumPrice[$cKey->id]) && !isset($sumCost[$cKey->id])){
                  $sumPrice[$cKey->id]=0;
                  $sumCost[$cKey->id]=0;
                  $sumPrice[$cKey->id] += round(((($cKey->percentage*$cKey->loe_per_quantity)/100)*$cKey->price));
                  
                  $sumCost[$cKey->id] += round(((($cKey->percentage*$cKey->loe_per_quantity)/100)*$cKey->cost));
                  
                  if($sumCost[$cKey->id] == 0)
                  {
                    $margin[$cKey->id] = 0;
                  }
                  else{
                    $margin[$cKey->id] = round((100*($sumPrice[$cKey->id] -$sumCost[$cKey->id])/$sumCost[$cKey->id]));
                  }

                }

             @endphp
            @endforeach


            
            @foreach($all as $key)
            @php
            

            $total = $key->unit_cost;
            //echo $total;
            
            //off shore total cost and price with MD
            $off_shore_MD = (($key->off_percentage * $key->loe_per_quantity)/100);
            $total_off_shore_cost = $off_shore_MD * $key->off_cost;
            $total_off_shore_price = $off_shore_MD * $key->off_price;

            //on shore total cost and price with MD
            $on_shore_MD = (($key->on_percent * $key->loe_per_quantity)/100);
            $total_on_shore_cost = $on_shore_MD * $key->on_cost;
            $total_on_shore_price =$on_shore_MD * $key->on_price;


            //near shore total cost and price with MD
            $near_shore_MD = (($key->near_percentage * $key->loe_per_quantity)/100);
            $total_near_shore_cost = $near_shore_MD * $key->near_cost;
            $total_near_shore_price = $near_shore_MD * $key->near_price;


            $total_price = $total_off_shore_price+$total_on_shore_price+$total_near_shore_price;

            $total_cost = $total_off_shore_cost+$total_on_shore_cost+$total_near_shore_cost;

          

            @endphp

            



           <tr id ="{{$key->id}}">
             <td>{{$key->id}}</td>
             <td>{{$key->plID}}</td>
             <td>{{$key->name}}</td>
             <td><a href="{!! route('loeView','') !!}/{{$key->id}}">{{$key->project_name}}</a></td>
             <td>{{$key->main_phase}}</td>
             <td>{{$key->quantity}}</td>
             <td>{{$key->loe_per_quantity}}</td>
             <td>{{$key->off_percentage}}</td>             
             <td>{{round($off_shore_MD,2)}}</td>
             <td>{{round($total_off_shore_cost,1)}}</td>
             <td>{{round($total_off_shore_price,1)}}</td>
             <td>{{$key->on_percent}}</td>
             <td>{{round($on_shore_MD,2)}}</td>
             <td>{{round($total_on_shore_cost,1)}}</td>
             <td>{{round($total_on_shore_price,1)}}</td>             
             <td>{{$key->near_percentage}}</td>                          
             <td>{{round($near_shore_MD,2)}}</td>
             <td>{{round($total_near_shore_cost,1)}}</td>
             <td>{{round($total_near_shore_price,1)}}</td>
             @foreach($margin as $id => $val)
              @php
              if($id == $key->plID)
              {
              @endphp
                <td>{{$val}}</td>
              @php 
              }
              @endphp
             @endforeach
             @foreach($sumCost as $id => $val)
              @php
              if($id == $key->plID)
              {
              @endphp
                <td>{{$val}}</td>
              @php 
              }
              @endphp
            
              
             @endforeach
             @foreach($sumPrice as $id => $val)
              @php
              if($id == $key->plID)
              {
              @endphp
                <td>{{$val}}</td>
              @php 
              }
              @endphp
            
              
             @endforeach

             
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

$(document).ready(function(){

  $(document).on('click','#requestsTable td' , function(){
    let project_id = $(this).closest('tr').attr('id');
    console.log(project_id);

        $.ajax({
       url: "{!! route('loeDetails','') !!}/"+project_id,
       type:"GET",
       dataType:"JSON",
       success:function(data){
        console.log(data);
        data.forEach(elem=>$('#modal-data').append('<tr>'+
                      '<th scope="row">'+elem.location+'</th>'+
                      '<td>'+elem.cost+'</td>'+
                      '<td>'+elem.price+'</td>'+'</tr>'));
     
       }
    });
      $('#project_data').modal('show');
        
  });
});



</script>
@stop