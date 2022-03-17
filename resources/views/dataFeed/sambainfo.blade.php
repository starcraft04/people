@extends('layouts.app')

@section('style')
<!-- CSS -->
<!-- Switchery -->
<link href="{{ asset('/plugins/gentelella/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
<!-- Select2 -->
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/css/forms.css') }}" rel="stylesheet" />
<!-- DataTables -->
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('/css/datatables.css') }}">
<!-- Loader -->
<link href="{{ asset('/css/loader.css') }}" rel="stylesheet">
<!-- Document styling -->
<style>
h3 {
  overflow: hidden;
  text-align: center;
}

h3:before,
h3:after {
  background-color: #000;
  content: "";
  display: inline-block;
  height: 1px;
  position: relative;
  vertical-align: middle;
  width: 50%;
}

h3:before {
  right: 0.5em;
  margin-left: -50%;
}

h3:after {
  left: 0.5em;
  margin-right: -50%;
}
.label_error {
  color: red;
}
</style>
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
<!-- Switchery -->
<script src="{{ asset('/plugins/gentelella/vendors/switchery/dist/switchery.min.js') }}" type="text/javascript"></script>
<!-- Select2 -->
<script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>CL upload</h3>
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
        <h2>Form</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
           <div class="container">
        <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card Uploader" style="padding: 12px;">
          <div class="card-header">Download From the table using CSV button to have an Excel sheet with the Projects that do not have Customer Link ID</div>
          <div class="card-body">
            @if(session('status'))
              <div class="alert alert-sucess" role="alert">
                {{ session('ststus') }}
              </div>
            @endif
            <form action="CLimport" method="post" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <input type="file" name="file" style="display: inline-block;margin: 12px;">
                <button type="submit" class="btn btn-primary" style = "display: inline-block;">Import</button>
              </div>
            </form>
          </div>
          
        </div>
        
      </div>
      
    </div>
      </div>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      
    <!-- Customer Link update -->
      <div class="x_title">
        <h2>Customer Links Updator</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="col-xs-2">
            <label for="year" class="control-label">Year</label>
            <select class="form-control select2" id="year" name="year" data-placeholder="Select a year">
              @foreach(config('select.year') as $key => $value)
              <option value="{{ $key }}">
                {{ $value }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-offset-11 col-md-1">
            <button class="btn btn-primary" id="updatone_cl">Update</button>
          </div>
      </div>
      

      <!-- Customer Link update -->
      <!-- Main table -->
        <table id="samba_table" class="table table-striped table-hover table-bordered mytable" width="100%">
          <thead>
            <tr>
              <th>Project ID</th>
              <th>Customer Name</th>
              <th>Project Name</th>
              <th>Customer Link ID</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
            </tr>
          </tfoot>
        </table>
        <!-- Main table -->

      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->

    </div>
  </div>
</div>
<!-- Window -->



@stop

@section('script')
  <script>
$.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });


    // Customer Links
    //Init select2 boxes
    $("#year").select2({
      allowClear: false
    });

    var year  = $('select#year').val();

    $('#year').on('change', function() {
      Cookies.set('year', $('#year').val());
      year = [];
      $("#year option:selected").each(function()
      {
        // log the value and text of each option
        year.push($(this).val());

      });
      samba_table = $('#samba_table').DataTable({
      scrollX: true,
      orderCellsTop: true,
      bDestroy: true,
      serverSide: true,
      processing: true,
      stateSave: true,
      ajax: {
        url: "{!! route('projectsWithoutCLID') !!}",
        type: "GET",
        data:{'year':year[0]},

        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
        },
        dataType: "JSON"
      },
      columns: [
        { name: 'a.project_id', data: 'project_id' , searchable: false , visible: true},
        { name: 'c.name', data: 'name' , searchable: false , visible: true},
        { name: 'p.project_name', data: 'project_name' , className: "dt-nowrap", visible: true},
        { name: 'p.samba_id', data: 'samba_id' , searchable: false , visible: true},
       
      ],
      lengthMenu: [
          [ 10, 25, 50, -1 ],
          [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      dom: 'Bfrtip',
      buttons: [
        {
          extend: "pageLength",
          className: "btn-sm"
        },
        {
          extend: "csv",
          className: "btn-sm",
          exportOptions: {
              columns: ':visible'
          }
        },
        {
          extend: "excel",
          className: "btn-sm",
          exportOptions: {
              columns: ':visible'
          }
        },
        {
          extend: "print",
          className: "btn-sm",
          exportOptions: {
              columns: ':visible'
          }
        },
      ],
      footerCallback: function ( row, data, start, end, display ) {
        
      },
      initComplete: function () {
        
        samba_table.draw();
      }
    }); 
    });

    $(document).on('click','#updatone_cl',function(){
      console.log('this is year');
      console.log(year[0]);

      $.ajax({
        type: 'POST',
        url: "{!! route('callCL') !!}",
        data:{'year':year[0]},
        dataType: 'json',
        success:function(data){
          console.log("------------");
          console.log(data); 
          console.log("------------");
        }
        

      });
    });

      
  </script>
@stop
