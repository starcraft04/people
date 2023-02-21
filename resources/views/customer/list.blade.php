@extends('layouts.app')

@section('style')
    <!-- CSS -->
    <!-- DataTables -->
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
    

@stop

@section('scriptsrc')
    <!-- JS -->
    <!-- DataTables -->
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}" type="text/javascript"></script>
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

    <!-- Bootbox -->
    <script src="{{ asset('/plugins/bootbox/bootbox.min.js') }}"></script>
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Customer</h3>
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
        <h2>List</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
            <table id="customerTable" class="table table-striped table-hover table-bordered mytable" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Cluster owner</th>
                        <th>Country owner</th>
                        <th>
                            <a href="{{ route('customerFormCreate') }}" class="btn btn-info btn-xs" align="right"><span class="glyphicon glyphicon-plus"> New</span></a>
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th id="customer_id"></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="last_column"></th>
                    </tr>
                </tfoot>
            </table>
      </div>
      <!-- Window content -->

      <!-- MODAL FOR IC01 -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header float-right">
        <h5>User details</h5>
        <div class="text-right">
          <i data-dismiss="modal" aria-label="Close" class="fa fa-close"></i>
        </div>
      </div>
      <div class="modal-body">
          


        <div>
          
          <table id="ic01_table" class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">IC01 Code</th>
      <th scope="col">IC01 Name</th>
    </tr>
  </thead>
  <tbody>
   
  </tbody>
</table>
        
        </div>

        <div id="ic01_adding_form" style="display: none;">
            <form role="form" method="" action="">
                    <input type="hidden" name="_token" value="">
                    <div class="form-group">
                        <label class="control-label">IC01 Code</label>
                        <div>
                            <input type="text" class="form-control input-lg" id="ic01_code" name="ic01_code" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">IC01 Name</label>
                        <div>
                            <input type="text" class="form-control input-lg" id="ic01_name" name="ic01_name">
                        </div>
                    </div><!-- 
                    <div class="form-group">
                        <div style="display: block;width: 22%;float: right;">
                            <button style="width: 117px;" id="add_ic01_record" type="button" class="btn btn-primary">Add IC01</button>
                        </div>
                    </div> -->
                </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" data id ="add_ic01_records" class="btn btn-primary">Add New IC01</button>
      </div>
    </div>
  </div>
</div>
      <!-- End of MODAL -->

    </div>
  </div>
</div>
<!-- Window -->

@stop
<style type="text/css">
    tbody tr:nth-child(-n + 5) td .dropdown ul{
        position: absolute!important;
        top: 0!important;
    }
</style>
@section('script')
    <script>
        var customerTable;
        var record_id;
        var clickCount = 0;

        

        $(document).ready(function() {

       


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            customerTable = $('#customerTable').DataTable({
                serverSide: true,
                processing: true,
                scrollX: true,
                ajax: {
                        url: "{!! route('listOfCustomersAjax') !!}",
                        type: "POST",

                    },
                columns: [
                    { name: 'id', data: 'id', searchable: false , visible: false, className:"dt-nowrap"},
                    { name: 'name', data: 'name' },
                    { name: 'cluster_owner', data: 'cluster_owner' },
                    { name: 'country_owner', data: 'country_owner' },
                    {
                        name: 'actions',
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function (data) {
                            // var actions = '';
                            // actions += '<div class="btn-group btn-group-xs">';
                            // 
                            // if ({{ Auth::user()->can('project-edit') ? 'true' : 'false' }}){
                            //   actions += '<button id="'+data.id+'" class="buttonUpdate btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></button>';
                            // };
                            // if ({{ Auth::user()->can('project-delete') ? 'true' : 'false' }}){
                            //   actions += '<button id="'+data.id+'" class="buttonDelete btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>';
                            // };
                            // actions += '</div>';

                var html ="";         
              html+='<div class="row">';
              html+='<div class="col-md-1">';
              html+='<div class="dropdown">';
              html+='<button id="options_loe" class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown" style="display: block;margin: 0 auto;width: 123px;">';
              html+='<i class="fa fa-bars" aria-hidden="true"></i>';
              html+='</button>';
              html+='<ul class="dropdown-menu" style="position:absolute;top:-111px;">';          
              
              html+='<li style="text-align:center;"><a class="dropdown-selection loe_mass_signoff" href="#"> </a>';
              html += '<div class="btn-group btn-group-xs" style="width:100%;">';
             if ({{ Auth::user()->can('project-view') ? 'true' : 'false' }}){
                              html += '<button id="'+data.id+'" class="buttonView" style="display:block;width: 80px;margin: 0 auto;background: white;color: blue;border: none;    font-size: 16px;">View</button>';
                            };
              html+='</div>';
              html+='</li>';
              html+='<li style="text-align:center;">';
              if ({{ Auth::user()->can('project-edit') ? 'true' : 'false' }}){
                              html += '<button id="'+data.id+'" class="buttonUpdate" style="display:block;width: 80px;margin: 0 auto;background: white;color: blue;border: none;    font-size: 16px;">Edit</button>';
                            };
              html+='</li>';
              html+='<li style="text-align:center;">';
              if ({{ Auth::user()->can('project-delete') ? 'true' : 'false' }}){
                              html += '<button id="'+data.id+'" class="buttonDelete" style="display:block;width: 80px;margin: 0 auto;background: white;color: blue;border: none;    font-size: 16px;">Delete</button>';
                            };
              html+='</li>';
               html+='<li style="text-align:center;">';
              if ({{ Auth::user()->can('project-view') ? 'true' : 'false' }}){
                              html += '<button data-col="'+data.id+'" id="'+data.id+'" class="openModal" data-toggle="modal" data-target="#exampleModal" style="display:block;width: 100px;margin: 0 auto;background: white;color: blue;border: none;font-size: 16px;">IC01 Codes</button>';
                            };
                         //add ic01 button
         

              html+='</li>';
                html+='</ul>';
              html+='</div>';
            html+='</div>';
          html+='</div>';
                            return html;
                        },
                        width: '70px'
                    }
                    ],
                order: [[1, 'asc']],
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
                        columns: [ 1, 2, 3, 4, 5, 6 ,7]
                    }
                  },
                  {
                    extend: "excel",
                    className: "btn-sm",
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6,7 ]
                    }
                  },
                  {
                    extend: "print",
                    className: "btn-sm",
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6,7 ]
                    }
                  },
                ],
                initComplete: function () {
                    var columns = this.api().init().columns;
                    this.api().columns().every(function () {
                        var column = this;
                        // this will get us the index of the column
                        index = column[0][0];
                        //console.log(columns[index].searchable);

                        // Now we need to skip the column if it is not searchable and we return true, meaning we go to next iteration
                        if (columns[index].searchable == false) {
                          return true;
                        }
                        else {
                          var input = document.createElement("input");
                          $(input).appendTo($(column.footer()).empty())
                          .on('keyup change', function () {
                              column.search($(this).val(), false, false, true).draw();
                          });
                        }
                    });
                }
            });
            $(document).on('click','.openModal',function(){
                $('#ic01_table tbody').empty();
                var id = $(this).attr('data-col');

                $.ajax({
          
          type: "GET",
          
            url: "{!! route('getCustomerIc01','') !!}",
            data:{'customer_id':id},
            
            success: function(data) {
              html="";
              console.log("ic01");
              console.log(data);

             var trHTML = '';
        
        $.each(data, function (i, item) {
            trHTML += '<tr><th scope="row"></th><td>'+i+'</td><td>' + item + '</td></tr>';
        });
        $('#ic01_table tbody').append(trHTML);
          }
          });
                
        $(document).on('click','#add_ic01_records',function(){
            
            
            console.log(clickCount);

            
            clickCount++;
            if (clickCount === 1) {
              // First click code
                console.log(clickCount);
                $('#ic01_adding_form').css('display','block'); 
            } else if (clickCount === 2) {

              // Second click code
                console.log('seco');
              console.log('Second click!');

              var ic01_code = $('#ic01_code').val();
              var ic01_name = $('#ic01_name').val();
              

              if(ic01_code == '' || ic01_name == '')
              {
                console.log('empty');
              }
              else {
                $.ajax({
          
            type: "GET",
          
            url: "{!! route('addNewIC01Record','') !!}",
            data:{'customer_id':id,'ic01_code':ic01_code,'ic01_name':ic01_name},
            
            success: function(data) {
            
              console.log(data);
                $('#exampleModal').modal('toggle');
                $('#ic01_adding_form').css('display','none');
                $('#ic01_adding_form').reset();
                clickCount=0;
              
            }

          });
              }
            } else if(clickCount >2){
                
                console.log('third');
                $('#exampleModal').modal('toggle');
                $('#ic01_adding_form').css('display','none');
                

            }
          });
                
            });



            
          
          // Handle first click event
          
            $(document).on('click', '.buttonUpdate', function () {
                window.location.href = "{!! route('customerFormUpdate','') !!}/"+this.id;
            } );

            $(document).on('click', '.buttonView', function () {
                window.location.href = "{!! route('customer','') !!}/"+this.id;
            } );

            $(document).on('click', '.buttonDelete', function () {
                record_id = this.id;
                bootbox.confirm("Are you sure want to delete this record?", function(result) {
                    if (result){
                        $.ajax({
                            type: 'get',
                            url: "{!! route('customerDelete','') !!}/"+record_id,
                            dataType: 'json',
                            success: function(data) {
                                console.log(data);
                                if (data.result == 'success'){
                                    box_type = 'success';
                                    message_type = 'success';
                                }
                                else {
                                    box_type = 'danger';
                                    message_type = 'error';
                                }

                                $('#flash-message').empty();
                                var box = $('<div id="delete-message" class="alert alert-'+box_type+' alert-dismissible flash-'+message_type+'" role="alert"><button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>'+data.msg+'</div>');
                                $('#flash-message').append(box);
                                $('#delete-message').delay(2000).queue(function () {
                                    $(this).addClass('animated flipOutX')
                                });
                                customerTable.ajax.reload();
                            }
                        });
                    }
                });
            } );
           
        } );

    </script>
@stop
