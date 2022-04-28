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
        <div class="col-xs-3">
            <label for="manager" class="control-label">Search by Customer Name</label>
              <input type="text" name="search" id = "search_customer" class = "form-control">
          </div>
        <div class="col-xs-3">
            <label for="manager" class="control-label">Search by Project Name</label>
              <input type="text" name="search" id = "search" class = "form-control">
          </div>
          <div class="col-xs-3">
            <label for="manager" class="control-label">Search by Phase</label>
              <input type="text" name="search" id = "search_phase" class = "form-control">
          </div>
          <div class="form-group row">
            <div class="col-xs-2">
            <label for="closed" class="control-label">Totals</label>
            <input name="closed" type="checkbox" id="closed" class="form-group js-switch-small" checked /> 
          </div>
          </div>
        <div class="clearfix"></div>

      </div>
      <!-- Window title -->
      
      
  <!-- SEARCH FIELD -->
          
      <!-- END -->

        <!-- Main table -->
        <!-- Margin Added -->
        <div class="table-responsive">
          <table id="requestsTable" class="table table-striped table-hover table-bordered mytable" style="    overflow-x: auto;">
          <thead>
              <tr>
                  <th colspan="7">Project Details</th>
                  <th colspan="4">Off shore</th>
                  <th colspan="4">On shore</th>
                  <th colspan="4">Near shore</th>
                  <th colspan="4">Totals</th>

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
                <th class="off_md" data-field="md" style="width:10px;">MD</th>
                <th class="off_cost" data-field="cost" >Cost</th>
                <th class="off_price" data-field="price" >Price</th>
                <th data-field="percentage" style="width:10px;">%</th>
                <th data-field="md" style="width:10px;">MD</th>
                <th data-field="cost" >Cost</th>
                <th data-field="price" >Price</th>
                <th data-field="percentage" style="width:10px;">%</th>
                <th data-field="md" style="width:10px;">MD</th>
                <th data-field="cost" >Cost</th>
                <th data-field="price" >Price</th>
                <th class="total loe" style="width:10px;">Total LOE</th>
                <th class="margin" style="width:10px;">Margin</th>
                <th class="total_cost" >Total Cost</th>
                <th class="total_price" >Total Price</th>
              </tr>
          </thead>
          
          <tbody class = "alldata">
            @php
            $sumCost = [];
            $sumPrice = [];
            $margin =  [];
            @endphp
            @foreach($check as $cKey)

             @php 
                if(isset($sumPrice[$cKey->id]) && isset($sumCost[$cKey->id]))
                {
                  $sum= ((($cKey->quantity*$cKey->percentage*$cKey->loe_per_quantity)/100)*$cKey->price);
                  $sumPrice[$cKey->id] += round($sum);

                  
                  $cost=((($cKey->quantity*$cKey->percentage*$cKey->loe_per_quantity)/100)*$cKey->cost);
                  
                  $sumCost[$cKey->id] += round($cost);

                   if($sumCost[$cKey->id] == 0)
                  {
                    $margin[$cKey->id] = 0;
                  }
                  else{
                    $marginTotal = (100*($sumPrice[$cKey->id] -$sumCost[$cKey->id])/$sumCost[$cKey->id]);
                    $margin[$cKey->id] = round($marginTotal);
                  }

                }
                else if(!isset($sumPrice[$cKey->id]) && !isset($sumCost[$cKey->id])){
                  $sumPrice[$cKey->id]=0;
                  $sumCost[$cKey->id]=0;
                  $one_price =((($cKey->quantity*$cKey->percentage*$cKey->loe_per_quantity)/100)*$cKey->price);

                  $sumPrice[$cKey->id] += round($one_price);
                  $one_cost = ((($cKey->quantity*$cKey->percentage*$cKey->loe_per_quantity)/100)*$cKey->cost);
                  $sumCost[$cKey->id] += round($one_cost);
                  
                  if($sumCost[$cKey->id] == 0)
                  {
                    $margin[$cKey->id] = 0;
                  }
                  else{
                    $margin_total = (100*($sumPrice[$cKey->id] -$sumCost[$cKey->id])/$sumCost[$cKey->id]);
                    $margin[$cKey->id] = round($margin_total);
                  }

                }

             @endphp
            @endforeach


            
            @foreach($all as $key)
            @php
            

            $total = $key->unit_cost;
            $total_off_shore_cost = 0;
            $total_on_shore_cost = 0;
            $total_near_shore_cost =0;
            //echo $total;
            
            //off shore total cost and price with MD
            $off_shore_MD = (($key->quantity*$key->off_percentage * $key->loe_per_quantity)/100);
            $total_off_shore_cost += $off_shore_MD * $key->unit_cost;
            $total_off_shore_price = $off_shore_MD * $key->off_price;

            //on shore total cost and price with MD
            $on_shore_MD = (($key->quantity*$key->on_percent * $key->loe_per_quantity)/100);
            $total_on_shore_cost += $on_shore_MD * $key->unit_cost;
            $total_on_shore_price =$on_shore_MD * $key->on_price;


            //near shore total cost and price with MD
            $near_shore_MD = (($key->quantity*$key->near_percentage * $key->loe_per_quantity)/100);
            $total_near_shore_cost += $near_shore_MD * $key->unit_cost;
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
             <td>{{round($key->off_percentage,1)}}</td>             
             <td>{{round($off_shore_MD,1)}}</td>
             <td>{{round($key->off_cost)}}</td>
             <!-- <td>{{$key->off_cost}}</td> -->
             <td>{{round($key->off_price)}}</td>
<!--              <td>{{$key->off_price}}</td> -->
             <td>{{round($key->on_percent,1)}}</td>
             <td>{{round($on_shore_MD,2)}}</td>
             <td>{{round($key->on_cost)}}</td>
             <!-- <td>{{$key->on_cost}}</td> -->
             <td>{{round($key->on_price)}}</td>
             <!-- <td>{{$key->on_price}}</td>              -->
             <td>{{round($key->near_percentage,1)}}</td>                          
             <td>{{round($near_shore_MD,1)}}</td>
             <td>{{round($key->near_cost)}}</td>
             <!-- <td>{{$key->near_cost}}</td> -->
             <td>{{round($key->near_price)}}</td>
             <td>{{round($key->quantity*$key->loe_per_quantity,1)}}</td>
             
             <!-- <td>{{$key->near_price}}</td> -->
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
          <tbody id="content"></tbody>
          <tfoot id="footer_content">
            <tr>
              <th id="total" colspan="19">Grand Totals :</th>
              <td id="footer_total_loe"></td>
              <td id="footer_total_margin"></td>
              <td id="footer_total_cost"></td>
              <td id="footer_total_price"></td>
            </tr>
          </tfoot>
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





$(document).ready(function(){


  $('#footer_content').hide();
  function grand_total_calculations()
  {
    var sum_total_cost=0;
    var sum_total_price=0;
    var sum_total_loe=0;

    $("#content tr #total_cost").each(function(index,value){
         getEachRow = parseFloat($(this).text());
         sum_total_cost += getEachRow
       });
        $("#content tr #total_price").each(function(index,value){
         getEachRow = parseFloat($(this).text());
         sum_total_price += getEachRow
       });

        $("#content tr #total_loe").each(function(index,value){
         getEachRow = parseFloat($(this).text());
         sum_total_loe += getEachRow
       });


        var sum_margin = Math.round(((100*(sum_total_price-sum_total_cost))/sum_total_cost))
        
        document.getElementById('footer_total_loe').innerHTML = Math.round(sum_total_loe);
        document.getElementById('footer_total_margin').innerHTML = sum_margin;
        document.getElementById('footer_total_price').innerHTML = sum_total_price;
        document.getElementById('footer_total_cost').innerHTML = sum_total_cost;

        $('#footer_content').show();
  }



  if (Cookies.get('checkbox_closed') != null) {
      if (Cookies.get('checkbox_closed') == 0) {
        checkbox_closed = 0;

        $('#content').hide();
        $('.alldata').show();

        $('#closed').click();
      } else {
        checkbox_closed = 1;
        $('.alldata').hide();
      $('#content').show();
      }
    }
$('#closed').on('change', function() {
      if ($(this).is(':checked')) {
        Cookies.set('checkbox_closed', 1);
        checkbox_closed = 1;
         $.ajax({
      url: "{!! route('listAllLoe') !!}",
     type:"GET",
     error: function (request, error) {

        console.log(arguments);
    },
     success:function(data){
        $('#content').html(data);
        $('.alldata').hide();
      $('#content').show();
     }

    }); 
      } else {
        Cookies.set('checkbox_closed', 0);
        checkbox_closed = 0;
        $('#content').hide();
        $('.alldata').show();


      }
      console.log(checkbox_closed);
      //activitiesTable.ajax.reload();
    });

  $('#search').on('keyup',function(){
    
    var value = $(this).val(); //search
    var phase = $('#search_phase').val(); //phase
    console.log("phase");
    console.log(phase);

    if(value)
    {
      $('.alldata').hide();
      $('#content').show();

    $.ajax({
      url: "{!! route('buildList') !!}",
     type:"GET",
     data:{'search':value,'search_phase':phase},
     error: function (request, error) {

        console.log(arguments);
    },
     success:function(data){
      console.log("sss");
        $('#content').html(data);
        grand_total_calculations();
     }

    });
    }
    else{
      if(checkbox_closed == 1)
      {
        $.ajax({
      url: "{!! route('listAllLoe') !!}",
     type:"GET",
     error: function (request, error) {

        console.log(arguments);
    },
     success:function(data){
        $('#content').html(data);
        $('.alldata').hide();
      $('#content').show();
     }

    });
      }
      else{

      $('.alldata').show();
      $('#content').hide();
      $('tfoot').hide();

    $.ajax({
      url: "{!! route('buildList') !!}",
     type:"GET",
     data:{'search':value,'search_phase':phase},
     error: function (request, error) {

        console.log(arguments);
    },
     success:function(data){
      console.log("sss");
        $('#content').html(data);
        grand_total_calculations();
     }

    });
      }

      
    }

  })

  

$('#search_customer').on('keyup',function(){
    var customer = $(this).val();
    var value = $('#search').val();
    var phase = $('#search_phase').val();
    console.log(value);

    if(customer)
    {
      $('.alldata').hide();
      $('#content').show();
      $.ajax({
      url: "{!! route('buildList') !!}",
     type:"GET",
     data:{'search_customer':customer,'search':value,'search_phase':phase},
     error: function (request, error) {

        console.log(arguments);
    },
     success:function(data){
      
        $('#content').html(data);
        grand_total_calculations();


     }

    });
    }
    else{
      if(checkbox_closed == 1)
      {
        $.ajax({
      url: "{!! route('listAllLoe') !!}",
     type:"GET",
     error: function (request, error) {

        console.log(arguments);
    },
     success:function(data){
        $('#content').html(data);
        $('.alldata').hide();
      $('#content').show();
     }

    });
      }
      else{
        
      $('.alldata').show();
      $('#content').hide();
      $('tfoot').hide();

      
      }

      
    }
    
  })
  $('#search_phase').on('keyup',function(){
    var phase = $(this).val();
    var value = $('#search').val();
    console.log(value);

    if(value)
    {
      $('.alldata').hide();
      $('#content').show();

      $.ajax({
      url: "{!! route('buildList') !!}",
     type:"GET",
     data:{'search':value,'search_phase':phase},
     error: function (request, error) {

        console.log(arguments);
    },
     success:function(data){
      
        $('#content').html(data);
        grand_total_calculations();
     }

    });
    }
    else{
      if(checkbox_closed == 1)
      {
        $.ajax({
      url: "{!! route('listAllLoe') !!}",
     type:"GET",
     error: function (request, error) {

        console.log(arguments);
    },
     success:function(data){
        $('#content').html(data);
        $('.alldata').hide();
      $('#content').show();
     }

    });
      }
      else{
        
      $('.alldata').show();
      $('#content').hide();
      $('tfoot').hide();


       $.ajax({
      url: "{!! route('buildList') !!}",
     type:"GET",
     data:{'search':value,'search_phase':phase},
     error: function (request, error) {

        console.log(arguments);
    },
     success:function(data){
      
        $('#content').html(data);
        grand_total_calculations();
     }

    });
      }

      
    }

   
  })

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