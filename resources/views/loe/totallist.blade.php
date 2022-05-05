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
                <th data-field="total loe" style="width:10px;">Total LOE</th>
                <th data-field="margin" style="width:10px;">Margin</th>
                <th data-field="total cost" >Total Cost</th>
                <th data-field="total price" >Total Price</th>
              </tr>
          </thead>
          
          <tbody class = "alldata">            
            @foreach($all as $key)

               <tr id ="{{$key->id}}">
             <td>{{$key->id}}</td>
             <td>-</td>
             <td>-</td>
             <td><a href="{!! route('loeView','') !!}/{{$key->id}}">{{$key->project_name}}</a></td>
             <td>-</td>
             <td>{{$key->quantity}}</td>
             <td>{{$key->loe_per_quantity}}</td>
             <td>-</td>             
             <td>{{round($key->off_MD,1)}}</td>
             <td>{{round($key->off_cost,1)}}</td>
             <td>{{round($key->off_price,1)}}</td>
             <td>-</td>
             <td>{{round($key->on_MD,1)}}</td>
             <td>{{round($key->on_cost,1)}}</td>
             <td>{{round($key->on_price,1)}}</td>
             <td>-</td>                          
             <td>{{round($key->near_MD,1)}}</td>
             <td>{{round($key->near_cost,1)}}</td>
             <td>{{round($key->near_price,1)}}</td>
             <td>{{round($key->loe_per_quantity,1)}}</td>
             <td>-</td>
             <td>{{round(($key->off_cost)+($key->on_cost)+$key->near_cost,1)}}</td>
             <td>{{round(($key->off_price)+($key->on_price)+($key->near_price),1)}}</td>
          

             
           </tr>
           @endforeach
          </tbody>
          <tbody id="content"></tbody>
          <tfoot>
            <td>Total:</td>
            <td class="result"></td>
            <td class="result"></td>
            <td class="result"></td>
            <td class="result"></td>
            <td class="result"></td>
            <td class="result_quantity"></td>
            <td class="result_loe_per_quantity"></td>
            <td class="result"></td>
            <td class="result_total_md"></td>
            <td class="result_off_cost"></td>
            <td class="result_off_price"></td>
            <td class="result"></td>
            <td class="result_total_md_on_shore"></td>
            <td class="result_on_cost"></td>
            <td class="result_on_price"></td>
            <td class="result"></td>
            <td class="result_total_md_near"></td>
            <td class="result_near_cost"></td>
            <td class="result_near_price"></td>
            <td class="result"></td>
            <td class="result"></td>
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

   //   url:"{!! route('listAllLoe') !!}",
   //   success:function(data){
   //       console.log(data);
   //   }
   // });





$(document).ready(function(){

  $('#search').on('keyup',function(){
    var value = $(this).val(); //search
    var phase = $('#search_phase').val(); //phase
    console.log("phase");
    console.log(phase);

    if(value)
    {
      $('.alldata').hide();
      $('#content').show();
    }
    else{

      $('.alldata').show();
      $('#content').hide();
    }

    $.ajax({
      url: "{!! route('buildList') !!}",
     type:"GET",
     data:{'search':value,'search_phase':phase},
     error: function (request, error) {

        console.log(arguments);
    },
     success:function(data){
      console.log("sss");
        console.log(data);
        $('#content').html(data);
     }

    });
  })

  $('#search_phase').on('keyup',function(){
    var phase = $(this).val();
    var value = $('#search').val();
    console.log(value);

    if(value)
    {
      $('.alldata').hide();
      $('#content').show();
    }
    else{

      $('.alldata').show();
      $('#content').hide();
    }

    $.ajax({
      url: "{!! route('buildList') !!}",
     type:"GET",
     data:{'search':value,'search_phase':phase},
     error: function (request, error) {

        console.log(arguments);
    },
     success:function(data){
      console.log(value);
        console.log(data);
        $('#content').html(data);
     }

    });
  })

  $('#search_customer').on('keyup',function(){
    var phase = $(this).val();
    var customer = $('#search_customer').val();
    console.log(value);

    if(value)
    {
      $('.alldata').hide();
      $('#content').show();
    }
    else{

      $('.alldata').show();
      $('#content').hide();
    }

    $.ajax({
      url: "{!! route('buildList') !!}",
     type:"GET",
     data:{'search_customer':customer,'search':value,'search_phase':phase},
     error: function (request, error) {

        console.log(arguments);
    },
     success:function(data){
      console.log(value);
        console.log(data);
        $('#content').html(data);
     }

    });
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