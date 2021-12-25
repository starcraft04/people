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
    <h3>Resource Request</h3>
  </div>
</div>
<div class="clearfix"></div>
<!-- Page title -->

<!-- Window -->
<div class="row">
         <!-- Selections for the table -->

 <!-- Selections for the table -->
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"><!-- Selections for the table -->

        <div class="form-group row">
          <div class="col-xs-2">
            <label for="year_res" class="control-label">Year</label>
            <select class="form-control select2" id="year_res" name="year_res" data-placeholder="Select a year">
              @foreach(config('select.year') as $key => $value)
              <option value="{{ $key }}">
                {{ $value }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-xs-2">
            <label for="month_res" class="control-label">Month</label>
            <select class="form-control select2" id="month_res" name="month_res" data-placeholder="Select a month">
              @foreach(config('select.month_names') as $key => $value)
              <option value="{{ $key }}">
                {{ $value }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-xs-3" style="display:none;">
            <label for="manager" class="control-label">Manager</label>
            <select class="form-control select2" id="manager" name="manager" data-placeholder="Select a manager" multiple="multiple">
              @foreach($authUsersForDataView->manager_list as $key => $value)
              <option value="{{ $key }}"
                @if(isset($authUsersForDataView->manager_selected) && $key == $authUsersForDataView->manager_selected) selected
                @endif>
                {{ $value }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-xs-3" style="display:none;">
            <label for="user" class="control-label">User</label>
            <select class="form-control select2" id="user" name="user" data-placeholder="Select a user" multiple="multiple">
              @foreach($authUsersForDataView->user_list as $key => $value)
              <option value="{{ $key }}"
                @if(isset($authUsersForDataView->user_selected) && $key == $authUsersForDataView->user_selected) selected
                @endif>
                {{ $value }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-xs-2" style="display:none;">
            <label for="closed" class="control-label">Hide closed</label>
            <input name="closed" type="checkbox" id="closed" class="form-group js-switch-small" checked /> 
          </div>
        </div>

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


            <button id="RequestResource" style="display: inline-block;width: 15%;" class="btn btn-info btn-xs"  align="right" data-toggle="modal" data-target="#resource_request_create"><span class="glyphicon glyphicon-plus">Request Resource</span></button>

            <!-- Modal -->
              <div class="modal fade" id="resource_request_create" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" style="display:table;">
                      <div class="modal-content" style="width: 900px;">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" id="modal_action_title"></h4>
                        </div>
                        <!-- Modal Header -->
                      
                        <!-- Modal Body -->
                        <div class="modal-body">
                          <form id="resource_request_create_form" role="form" method="POST" action="">
                            <div class="col-md-6 left_form">
                               <!-- Cutomers list -->
                      <div id="resource_request_create_formgroup_customer" class="form-group">
                        <label  class="control-label" for="resource_request_create_form_customer">Customer</label>
                        <select class="form-control select2" style="width: 100%;" id="resource_request_create_form_customer" data-placeholder="Select a customer">
                          @foreach($customers_list as $key => $value)
                          <option value="{{ $key }}">
                            {{ $value }}
                          </option>
                          @endforeach  
                        </select>
                        <span id="resource_request_create_form_customer_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- Project list -->
                      <div id="resource_request_create_formgroup_project" class="form-group">
                        <label  class="control-label" for="resource_request_create_form_project">Project</label>
                        <select class="form-control select2" style="width: 100%;" id="resource_request_create_form_project" data-placeholder="Select a project">
                        </select>
                        <span id="resource_request_create_form_project_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- users list -->
                      <div id="resource_request_create_formgroup_creator" class="form-group">
                        <label  class="control-label" for="resource_request_create_form_creator">Creator</label>
                        <select class="form-control select2" style="width: 100%;" id="resource_request_create_form_creator" data-placeholder="Creator"><option value="{{auth()->user()->id}}">{{auth()->user()->name}}</option>
                         
                        </select>
                        <span id="resource_request_create_form_creator_error" class="help-block"></span>
                      </div>

                      <!-- Budgeted -->
                      <div id="resource_request_create_formgroup_customer" class="form-group">
                        <label  class="control-label" for="resource_request_create_form_budgted">Budgted</label>
                        <select class="form-control select2" style="width: 100%;" id="resource_request_create_budgted" data-placeholder="Select a customer">
                          <option value=""></option>
                         <option value="Yes">
                            Yes
                          </option>
                          <option value="No">
                            No
                          </option>
                        </select>
                        <span id="resource_request_create_form_budgted_error" class="help-block"></span>
                      </div>
                      <!-- End -->


                      <!-- Consulting Request -->
                      <div id="resource_request_create_formgroup_consulting_request" class="form-group">
                        <label  class="control-label" for="resource_request_create_form_consulting_request">Consulting Request</label>
                        <input type="text" class="form-control" id="resource_request_create_form_consulting_request">
                        <span id="resource_request_create_form_consulting_request_error" class="help-block"></span>
                      </div>
                      <!-- End -->


                      <!-- PR -->
                      <div id="resource_request_create_formgroup_pr" class="form-group">
                        <label  class="control-label" for="resource_request_create_pr">PR</label>
                        <input type="text" class="form-control" id="resource_request_create_pr">
                        <span id="resource_request_create_pr_error" class="help-block"></span>
                      </div>
                      <!-- End -->

                      <!-- PO -->
                      <div id="resource_request_create_formgroup_po" class="form-group">
                        <label  class="control-label" for="resource_request_create_po">PO</label>
                        <input type="text" class="form-control" id="resource_request_create_po">
                        <span id="resource_request_create_po_error" class="help-block"></span>
                      </div>
                      <!-- End -->

                      <!-- Users domain list -->
                      <div id="resource_request_create_formgroup_customer" class="form-group">
                        <label  class="control-label" for="resource_request_create_form_domain_user">User Practices</label>
                        <select class="form-control select2" style="width: 100%;" id="resource_request_create_form_domain_user" data-placeholder="Select a Practice">y
                          <option value=""></option>

                          @foreach(config('domains.domain-users') as $domain)
                            <option value="{{ $domain }}"
                             >
                              {{$domain}}
                            </option>
                            @endforeach
                        </select>
                        <span id="resource_request_create_form_domain_user_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- Contractor name -->
                      <div id="resource_request_create_formgroup_contractor_name" class="form-group">
                        <label  class="control-label" for="resource_request_create_contractor_name">Contractor name</label>
                        <input type="text" class="form-control" id="resource_request_create_contractor_name">
                        <span id="resource_request_create_contractor_name_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- Duration -->
                      <div id="resource_request_create_formgroup_duration" class="form-group">
                        <label  class="control-label" for="resource_request_create_duration">Duration</label>
                        <input type="text" class="form-control" id="resource_request_create_duration" required>

                        <span id="resource_request_create_form_duration_error" class="help-block"></span>
                      </div>
                      <!-- End -->

                      <!-- Reason for request -->
                      <div id="resource_request_create_formgroup_reason_for_request" class="form-group">
                        <label  class="control-label" for="resource_request_create_reason_for_request">Reason for request</label>
                        <textarea name="reason_for_request" class="form-control" id="resource_request_create_reason_request" placeholder="Reasons of request" required></textarea> 
                        <span id="resource_request_create_form_reason_for_request_error" class="help-block"></span>
                      </div>
                      <!-- End -->

                            </div>
                            <div class="col-md-6 right_form">
                              
                                <!-- Case status -->
                      <div id="resource_request_create_formgroup_customer" class="form-group">
                        <label  class="control-label" for="resource_request_create_form_case_status">Case status</label>
                        <select class="form-control select2" style="width: 100%;" id="resource_request_create_case_status" data-placeholder="Select a customer">
                        <option value=""></option>

                         <option value="Completed">
                            Completed
                          </option>
                          <option value="Init">
                            Init
                          </option>
                        </select>
                        <span id="resource_request_create_form_case_status_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- EWR status -->
                      <div id="resource_request_create_formgroup_customer" class="form-group">
                        <label  class="control-label" for="resource_request_create_form_ewr_status">EWR status</label>
                        <select class="form-control select2" style="width: 100%;" id="resource_request_create_ewr_status" data-placeholder="Select a customer">
                        <option value=""></option>
                         <option value="Accepted">
                            Accepted
                          </option>
                          <option value="Waiting">
                            Waiting
                          </option>
                        </select>
                        <span id="resource_request_create_form_ewr_status_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- supplier -->
                      <div id="resource_request_create_formgroup_supplier" class="form-group">
                        <label  class="control-label" for="resource_request_create_supplier">Supplier</label>
                        <input type="text" class="form-control" id="resource_request_create_supplier">
                        <span id="resource_request_create_form_supplier_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- revenue -->
                     <div id="resource_request_create_formgroup_revenue" class="form-group">
                        <label  class="control-label" for="resource_request_create_revenue">Revenue</label>
                        <input type="text" class="form-control" id="resource_request_create_revenue" required>

                        <span id="resource_request_create_form_revenue_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- Cost -->
                      <div id="resource_request_create_formgroup_cost" class="form-group">
                        <label  class="control-label" for="resource_request_create_form_cost">Cost</label>
                        <input type="text" class="form-control" id="resource_request_create_form_cost" required>
                        <span id="resource_request_create_form_cost_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- Currency -->
                      <div id="resource_request_create_formgroup_currency" class="form-group">
                        <label  class="control-label" for="resource_request_create_form_currency">Currency</label>
                        <select class="form-control select2" style="width: 100%;" id="resource_request_create_currency" data-placeholder="Select Currency" required>
                        <option value=""></option>
                         <option value="EUR">
                            EUR
                          </option>
                          <option value="USD">
                            USD
                          </option>
                        </select>
                        <span id="resource_request_create_form_currency_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- Margin -->
                      <div id="resource_request_create_formgroup_margin" class="form-group">
                        <label  class="control-label" for="resource_request_create_margin">Margin</label>
                        <input type="number" class="form-control" id="resource_request_create_margin" required>
                        <span id="resource_request_create_form_margin_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- Internal Check -->
                      <div id="resource_request_create_formgroup_customer" class="form-group">
                        <label  class="control-label" for="resource_request_create_form_internal_check">Internal Check</label>
                        <select class="form-control select2" style="width: 100%;" id="resource_request_create_internal_check" data-placeholder="Select a customer" required>
                          <option value=""></option>
                         <option value="Yes">
                            Yes
                          </option>
                          <option value="No">
                            No
                          </option>
                        </select>
                        <span id="resource_request_create_form_internal_check_error" class="help-block"></span>
                      </div>
                      <!-- End -->                      
                      <!-- Description -->
                      <div id="resource_request_create_formgroup_description" class="form-group">
                        <label  class="control-label" for="resource_request_create_for_description">Description</label>
                        <textarea name="description" class="form-control" id="resource_request_create_description" placeholder="Description"></textarea> 
                        <span id="resource_request_create_form_description_error" class="help-block"></span>
                      </div>
                      <!-- End -->

                      <!-- Comment -->
                      <div id="resource_request_create_formgroup_comment" class="form-group">
                        <label  class="control-label" for="resource_request_create_for_comment">Comment</label>
                        <textarea name="comment" class="form-control" id="resource_request_create_comment" placeholder="Comments"></textarea> 
                        <span id="resource_request_create_form_comment_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                            </div>
                                
                                <div class="form-group">
                                <div id="modal_action_form_hidden"></div>
                            </div>
                          </form>
                        </div>
                          
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" id="modal_action_create_update_button" class="btn btn-success">Update</button>
                        </div>
                      </div>
                  </div>
              </div>
              <!-- Modal -->


        <!-- Main table -->
        <table id="requestsTable" class="table table-striped table-hover table-bordered mytable" width="100%">
          <thead>
            <tr>
              <th>Manager name</th>
              <th>Creator</th>
              <th>Project Name</th>
              <th>Date of Creation</th>
              <th>Budgted</th>
              <th>Consulting Request</th>
              <th>PR#</th>
              <th>PO#</th>
              <th>Practices</th>
              <th>Duration</th>
              <th>Case status</th>
              <th>EWR status</th>
              <th>Supplier</th>
              <th>Revenue</th>
              <th>Cost</th>
              <th>Currency</th>
              <th>Margin</th>
              <th>Internal Check</th>
              <th>Reason for request</th>
              <th>Description</th>
              <th>Comment</th>
              <th>Last update</th>
              <th>Date of Complete</th>
              <th>Contractor name</th>
              <th>Action</th>
            </tr>
          </thead>
           <tfoot>
            <tr>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
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

@stop

  @section('script')
<script type="text/javascript">

  $('#myTabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
  $(document).ready(function() {


  var requestsTable;
  var year = [];
  var month = [];
  var manager = [];
  var user = [];
  var month_col = [];
  var header_months = [];
  var checkbox_closed = 0;

  // switchery
  var small = document.querySelector('.js-switch-small');
  var switchery = new Switchery(small, { size: 'small' });

  function ajaxData(){
    var obj = {
      'year[]': year,
      'month[]': month,
      'manager[]': manager,
      'user[]': user,
      'checkbox_closed':checkbox_closed
    };
    return obj;
  }

  // This is the function that will set the values in the select2 boxes with info from Cookies
  function fill_select(select_id){
    array_to_use = [];
    
    var d = new Date();
      var y = d.getFullYear();
      var m = d.getMonth()+1;
      if (select_id == 'year_res') {
        $('#'+select_id).val(y).trigger('change');
      } else if (select_id == 'month_res') {
        $('#'+select_id).val(m).trigger('change');
      }
      $("#"+select_id+" option:selected").each(function()
      {
        // log the value and text of each option
        array_to_use.push($(this).val());
      });
    return array_to_use;
  }

  

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
    $("#year_res").select2({
      allowClear: false
    });
    $("#month_res").select2({
      allowClear: false
    });
    $("#manager").select2({
      allowClear: false,
      disabled: {{ $authUsersForDataView->manager_select_disabled }}
    });
    $("#user").select2({
      allowClear: false,
      disabled: {{ $authUsersForDataView->user_select_disabled }}
    });



 
 function change_project_select(customer_id) {

      $.ajax({
            type: 'get',
            url: "{!! route('getProjectByCustomerId','') !!}/"+customer_id,
            dataType: 'json',
            success: function(data) {
              project_list = data;
              // console.log(project_list);
              var html = '';
              var html_domain='';
              project_list.forEach(fill_project_select);
              function fill_project_select (project){
              html += '<option value="'+project.id+'" >'+project.project_name+'</option>';
              console.log(project.id);
              }

              $('#resource_request_create_form_project').empty();
              $('#resource_request_create_form_project').append(html);
              // Set selected 
              $('#resource_request_create_form_project').val(project_list[0].id);
              $('#resource_request_create_form_project').select2().trigger('change');
            },
            error: function (jqXhr, textStatus, errorMessage) { // error callback 
              console.log('Error: ' + errorMessage);
            }
      });
    }



    $('#resource_request_create_form_customer').on('change', function() {
      $('select#resource_request_create_form_project').val($(this).data(''));
      $('select#resource_request_create_form_project').select2().trigger('change');
      customer_id = $('#resource_request_create_form_customer').val();
      var customer_link_id = $('select#resource_request_create_form_customer_link').val();

      // console.log(customer_id);

          change_project_select(customer_id);

    });

    $('#resource_request_create_form_project').on('change', function() {
      var project_id = $('#resource_request_create_form_project').val();


    });
    // Then we need to get back the information from the cookie

    year = fill_select('year_res');
    month = fill_select('month_res');
    manager = fill_select('manager');
    user = fill_select('user');

    month_col = [1,2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];

    if (Cookies.get('checkbox_closed') != null) {
      if (Cookies.get('checkbox_closed') == 0) {
        checkbox_closed = 0;
        $('#closed').click();
      } else {
        checkbox_closed = 1;
      }
    }


function color_for_month_value(value,td) {
      if(value >0){
          $(td).addClass('resource_gap_postive');
      }
      else{
        $(td).addClass('resource_gap_negative_and_zero');
      }
    }
    //alert($.fn.dataTable.version);

    // This is to update the headers
    function update_headers() {
      months_from_selection = [];
      months_name = [
        @foreach(config('select.month') as $key => $month)
          '{{$month}}'
          @if($month != 'DEC'),@endif
        @endforeach
      ];
      header_months = [];
      
      for (let index = parseInt(month[0],10); index <= 12; index++) {
        this_year = parseInt(year[0],10);
        months_from_selection.push(months_name[index-1]+' '+this_year.toString().substring(2));
        header_months.push({'year':this_year,'month':index});
      }
      if (month[0] > 1) {
        next_year = parseInt(year[0], 10)+1;
        for (let index = 1; index <= month[0]-1; index++) {
          months_from_selection.push(months_name[index-1]+' '+next_year.toString().substring(2));
          header_months.push({'year':next_year,'month':index});
        }
      }

      //console.log(months_from_selection);
      
      // We change the title of the months as it varies in function of the year and month selected
      for (let index = 1; index <= 12; index++) {
          //console.log(month);
          $('#table_month_'+index).empty().html(months_from_selection[index-1]);
        }
    }

    // Then we define what happens when the selection changes

    $('#year_res').on('change', function() {
      Cookies.set('year', $('#year_res').val());
      year = [];
      $("#year_res option:selected").each(function()
      {
        // log the value and text of each option
        year.push($(this).val());

      });
        requestsTable.ajax.reload(update_headers());

    });

    $('#month_res').on('change', function() {
      Cookies.set('month', $('#month_res').val());
      month = [];
      $("#month_res option:selected").each(function()
      {
        // log the value and text of each option
        month.push($(this).val());

      });
      //console.log(month);
      requestsTable.ajax.reload(update_headers());

    });

    $('#manager').on('change', function() {
      Cookies.set('manager', $('#manager').val());
      manager = [];
      $("#manager option:selected").each(function()
      {
        // log the value and text of each option
        manager.push($(this).val());

      });
            requestsTable.ajax.reload(update_headers());

    });

    $('#user').on('change', function() {
      Cookies.set('user', $('#user').val());
      user = [];
      $("#user option:selected").each(function()
      {
        // log the value and text of each option
        user.push($(this).val());

      });
            requestsTable.ajax.reload(update_headers());

    });

    $('#closed').on('change', function() {
      if ($(this).is(':checked')) {
        Cookies.set('checkbox_closed', 1);
        checkbox_closed = 1;
      } else {
        Cookies.set('checkbox_closed', 0);
        checkbox_closed = 0;
      }
      //console.log(checkbox_closed);
    });

    // SELECTIONS END
    //endregion

    $.ajax({
       url: "{!! route('resource_request_view') !!}",
        type: "GET",
        success:function(data){
          console.log(data);
        },
        dataType: "JSON",
    });

// form field required


// select 2 init
$("#resource_request_create_form_customer").select2({
          allowClear: false
      });
 $("#resource_request_create_form_project").select2({
          allowClear: false
      });

$("#resource_request_create_form_project_user").select2({
          allowClear: false
      });


$("#resource_request_create_budgted").select2({
          allowClear: false
      });


$("#resource_request_create_form_domain_user").select2({
          allowClear: false
      });


$("#resource_request_create_case_status").select2({
          allowClear: false
      });


$("#resource_request_create_ewr_status").select2({
          allowClear: false
      });


$("#resource_request_create_currency").select2({
          allowClear: false
      });


$("#resource_request_create_internal_check").select2({
          allowClear: false
      });

// resource_request_create
$("#resource_request_create_form_customer").select2({
          allowClear: false
      });
 $("#resource_request_create_form_project").select2({
          allowClear: false
      });

$("#resource_request_create_form_project_user").select2({
          allowClear: false
      });


$("#resource_request_create_form_budgted").select2({
          allowClear: false
      });


$("#resource_request_create_form_domain_user").select2({
          allowClear: false
      });


$("#resource_request_create_form_case_status").select2({
          allowClear: false
      });


$("#resource_request_create_ewr_status").select2({
          allowClear: false
      });


$("#resource_request_create_currency").select2({
          allowClear: false
      });


$("#resource_request_create_form_internal_check").select2({
          allowClear: false
      });
// send data to controller

// $(document).on('click','#modal_action_update_button',function(){


    $(document).on('click', '.buttonDeleteRequest', function () {
        record_id = this.id;
        bootbox.confirm("Are you sure want to delete this record?", function(result) {
            if (result){
                $.ajax({
                    type: 'get',
                    url: "{!! route('requestDelete','') !!}/"+record_id,
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
                        requestsTable.ajax.reload();
                    }
                });
            }
        });
    });


    //create request action :
    $(document).on('click', '#modal_action_create_update_button', function () {


      let user = $('select#resource_request_create_form_creator').val();
      
      let project = $('select#resource_request_create_form_project').val();
      let budget = $('select#resource_request_create_budgted').val();
      let consulting_request = $('#resource_request_create_form_consulting_request').val();
      let currecny = $('select#resource_request_create_currency').val();
      let po = $('#resource_request_create_po').val();
      let pr = $('#resource_request_create_pr').val();
      let practices = $('select#resource_request_create_form_domain_user').val();
      let contractor_name = $('#resource_request_create_contractor_name').val();
      let supplier = $('#resource_request_create_supplier').val();
      let case_status = $('select#resource_request_create_case_status').val();
      let duration = $('#resource_request_create_duration').val();
      let ewr_status = $('select#resource_request_create_ewr_status').val();
      let revenue = $('#resource_request_create_revenue').val();
      let cost = $('#resource_request_create_form_cost').val();
      let margin = $('#resource_request_create_margin').val();
      let internal_check = $('select#resource_request_create_internal_check').val();
      let reason_for_request = $('#resource_request_create_reason_request').val();
      let description = $('#resource_request_create_description').val();
      let comment = $('#resource_request_create_comment').val();





      let data = {"project":project,
                  "practices":practices,
                  "contractor_name":contractor_name,
                  "supplier":supplier,
                  'case_status':case_status,
                  'duration':duration,
                  'ewr_status':ewr_status,
                  'revenue':revenue,
                  'cost':cost,
                  'margin':margin,
                  'internal_check':internal_check,
                  'reason_for_request':reason_for_request,
                  'description':description,
                  'comment':comment,
                  "po":po,
                  'pr':pr,
                  "budget":budget,
                  "consulting_request":consulting_request,
                  'currecny':currecny,
                  'user':user[0]
                };

                if(typeof record_id !== 'undefined'){
                  $.ajax({
                    type: 'post',
                    url: "{!! route('updateRequest','') !!}/"+record_id,
                    data:data,
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
                        $('#resource_request_create').modal('hide');
                        requestsTable.ajax.reload();
                    }
            });
                }
                else{
                  $.ajax({
           url: "{!! route('create_request') !!}",
            type: "POST",
            data: data,
            success: function(result){
              console.log(result);
                            if(result.errors)
                            {
                                $('#modal_error').html('');

                                $.each(result.errors, function(key, value){
                                    $('#modal_error').show();
                                    $('#modal_error').append('<li>'+value+'</li>');
                                });
                            }
                            else
                            {
                        $('#resource_request_create').modal('hide');
                                requestsTable.ajax.reload();
                            }
                        },
            dataType: "JSON",
        });
                }
        
        



  

})
    //update request action:

    $(document).on('click', '.buttonActionEdit', function () {
        modal_action_form_clean('Update');
        record_id = this.id;
                $.ajax({
                    type: 'get',
                    url: "{!! route('getRequest','') !!}/"+record_id,
                    dataType: 'json',
                    success: function(data) {
                      console.log("---------modal data---------");
                        console.log(data);
                        console.log("---------Budgeted---------");
                        console.log(data[0]['Budgeted']);
                        console.log("---------ewr---------");
                        console.log(data[0]['EWR_status']);
                        $('#resource_request_create_budgted').val(data[0]['Budgeted']);
                        $('select#resource_request_create_form_project_user').val();
                        $('select#resource_request_create_form_project').val();
                        // $('select#resource_request_create_form_budgted').val();
                        $('#resource_request_create_form_consulting_request').val(data[0]['consulting_request']);
                        $('select#resource_request_create_currency').val(data[0]['currency']);
                        $('#resource_request_create_po').val(data[0]['PO']);
                        $('#resource_request_create_pr').val(data[0]['PR']);
                        $('select#resource_request_create_form_domain_user').val(data[0]['practice']);
                        $('#resource_request_create_contractor_name').val(data[0]['contractor_name']);
                        $('#resource_request_create_supplier').val(data[0]['supplier']);
                        $('#resource_request_create_case_status').val(data[0]['case_status']);
                        $('#resource_request_create_duration').val(data[0]['duration']);

                        $('#resource_request_create_ewr_status').val(data[0]['EWR_status']);
                        $('#resource_request_create_revenue').val(data[0]['revenue']);
                        $('#resource_request_create_form_cost').val(data[0]['cost']);
                        $('#resource_request_create_margin').val(data[0]['margin']);
                        $('select#resource_request_create_internal_check').val(data[0]['internal_check']);
                        $('#resource_request_create_reason_request').val(data[0]['reason_for_request']);
                        $('#resource_request_create_description').val(data[0]['description']);
                        $('#resource_request_create_comment').val(data[0]['comments']);

                        $("#resource_request_create_budgted").select2({
                                allowClear: true
                            });
                        $("#resource_request_create_case_status").select2({
                                allowClear: true
                            });
                        $("#resource_request_create_currency").select2({
                                allowClear: true
                            });
                        $("#resource_request_create_internal_check").select2({
                                allowClear: true
                            });
                        $("#resource_request_create_form_domain_user").select2({
                                allowClear: true
                            });
                        $("#resource_request_create_ewr_status").select2({
                                allowClear: true
                            });

                        
                    }
                });
            
        
    });

$(document).on('click', '#modal_action_update_request_button', function () {
// update modal field 
  let user = $('select#resource_request_create_form_project_user').val();
  let project = $('select#resource_request_create_form_project').val();
  let budget = $('select#resource_request_create_budgted').val();
  let consulting_request = $('#resource_request_create_form_consulting_request').val();
  let currecny = $('select#resource_request_create_currency').val();
  let po = $('#resource_request_create_po').val();
  let pr = $('#resource_request_create_pr').val();
  let practices = $('select#resource_request_create_form_domain_user').val();
  let contractor_name = $('#resource_request_create_contractor_name').val();
  let supplier = $('#resource_request_create_supplier').val();
  let case_status = $('select#resource_request_create_case_status').val();
  let duration = $('#resource_request_create_duration').val();
  let ewr_status = $('select#resource_request_create_ewr_status').val();
  let revenue = $('#resource_request_create_revenue').val();
  let cost = $('#resource_request_create_form_cost').val();
  let margin = $('#resource_request_create_margin').val();
  let internal_check = $('select#resource_request_create_internal_check').val();
  let reason_for_request = $('#resource_request_create_reason_request').val();
  let description = $('#resource_request_create_description').val();
  let comment = $('#resource_request_create_comment').val();




  let data = {
              "practices":practices,
              "contractor_name":contractor_name,
              "supplier":supplier,
              'case_status':case_status,
              'duration':duration,
              'ewr_status':ewr_status,
              'revenue':revenue,
              'cost':cost,
              'margin':margin,
              'internal_check':internal_check,
              'reason_for_request':reason_for_request,
              'description':description,
              'comment':comment,
              "po":po,
              'pr':pr,
              "budget":budget,
              "consulting_request":consulting_request,
              'currecny':currecny
            };

        console.log("clicked");
        
                
            
        
    });
// })
// $.ajax({
//   url: "",
//   type: "POST",
//   data:{}, 
//   dataType: "JSON"
//   success:function(data){

//   }
// })



    requestsTable = $('#requestsTable').DataTable({
      scrollX: true,
      orderCellsTop: true,
      serverSide: true,
      processing: true,
      stateSave: true,
      ajax: {
         url: "{!! route('resource_request_view') !!}",
        type: "GET",
        dataType: "JSON"
      },
      columns: [      
              { name: 'm.name', data: 'manager_name', searchable: true, visible: true},
              { name: 'u.name', data: 'user_name'},
              { name: 'p.project_name', data: 'project_name' , searchable: true, visible: true},
              { name: 'resources_request.created_at', data: 'created_at' , searchable: true, visible: true},
              { name: 'resources_request.Budgeted', data: 'Budgeted' , searchable: true, visible: true,

                render: function (data) {
                    if(data === 'No'){
                      data = '<span style="padding: 5px;color: #FF7900;">No</span>';
                    }
                    else{
                      data = '<span style="color: #1f9d1f;">YES</span>';
                    }
                    return data;
                },
                width: '100px'},
              { name: 'resources_request.consulting_request', data: 'consulting_request' , searchable: true, visible: true},
              { name: 'resources_request.PR', data: 'PR' , searchable: true, visible: true},
              { name: 'resources_request.PO', data: 'PO' , searchable: true, visible: true},
              { name: 'resources_request.practice', data: 'practice' , searchable: true, visible: true},
              { name: 'resources_request.duration', data: 'duration' , searchable: true, visible: true},
              { name: 'resources_request.case_status', 
                data: 'case_status' , searchable: true, visible: true,

                render: function (data) {
                    if(data === 'Completed'){
                      data = '<span style="padding: 5px;color: #1f9d1f;">Completed</span>';
                    }
                    else{
                      data = '<span style="color: #FF7900;">Initiate</span>';
                    }
                    return data;
                },
                width: '100px'
              },
              { name: 'resources_request.EWR_status', data: 'EWR_status' , searchable: true, visible: true,

                render: function (data) {
                    if(data === 'Accepted'){
                      data = '<span style="padding: 5px;color: #1f9d1f;">Accepted</span>';
                    }
                    else{
                      data = '<span style="color: #AF032B;">Waiting</span>';
                    }
                    return data;
                },
                width: '100px'},
              { name: 'resources_request.supplier', data: 'supplier' , searchable: true, visible: true},
              { name: 'resources_request.revenue', data: 'revenue' , searchable: true, visible: true},
              { name: 'resources_request.cost', data: 'cost' , searchable: true, visible: true},
              { name: 'resources_request.currency', data: 'currency' , searchable: true, visible: true,

                render: function (data) {
                    if(data === 'USD'){
                      data = '<span style="padding: 5px;color: #669966;">USD</span>';
                    }
                    else{
                      data = '<span style="color: #9FCDCD;">EURO</span>';
                    }
                    return data;
                },
                width: '100px'},
              { name: 'resources_request.margin', data: 'margin' , searchable: true, visible: true},
              { name: 'resources_request.internal_check', data: 'internal_check' , searchable: true, visible: true,

                render: function (data) {
                    if(data === 'No'){
                      data = '<span style="padding: 5px;color: #FF7900;">No</span>';
                    }
                    else{
                      data = '<span style="color: #1f9d1f;">YES</span>';
                    }
                    return data;
                },
                width: '100px'},
              { name: 'resources_request.reason_for_request', data: 'reason_for_request' , searchable: true, visible: false},
              { name: 'resources_request.description', data: 'description' , searchable: true, visible: false},
              { name: 'resources_request.comments', data: 'comments' , searchable: false, visible: false},
              { name: 'resources_request.updated_at', data: 'updated_at' , searchable: false, visible: false},
              { name: 'resources_request.date_of_complete', data: 'date_of_complete' , searchable: true, visible: false},
              { name: 'resources_request.contractor_name', data: 'contractor_name' , searchable: true, visible: false},
              {
                name: 'actions',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                    var actions = '';
                    actions += '<div class="btn-group btn-group-xs">';
                    if ({{ Auth::user()->can('user-delete') ? 'true' : 'false' }}){
                      actions += '<button id="'+data.id+'" class="buttonDeleteRequest btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>';
                      actions +='<button id="'+data.id+'" class="buttonActionEdit btn btn-primary" data-toggle="modal" data-target="#resource_request_create"><span class="glyphicon glyphicon-pencil"></span></button>';
                    };
                    actions += '</div>';
                    return actions;
                },
                width: '100px'
            },


        ],
         order: [[1, 'asc'],[3, 'asc'],[7, 'asc'],[12, 'asc']],
          lengthMenu: [
          [ 10, 25, 50, -1 ],
          [ '10 rows', '25 rows', '50 rows', 'Show all' ]
           ],
      dom: 'Bfrtip',
      buttons: [
        {
          extend: "colvis",
          className: "btn-sm",
          collectionLayout: "three-column",
          columns: [ 1, 3, 4, 5, 6,7,8,9, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23,24]
        },
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
      ],
        
    });



    })

  function modal_action_form_clean(title) {
      $('#modal_action_title').text(title+' Resource Request');
      $('#modal_action_create_update_button').text(title);
      $('#modal_action_form_hidden').empty();

      // Clean all input
      $("form#resource_request_create_form input").each(function(){ 
        $(this).val('');
      });
      // Clean all textarea
      $("form#resource_request_create_form textarea").each(function(){
        $(this).val('');
      });
      // Clean all select
      $("form#resource_request_create_form select").each(function(){
        $(this).val('');
        $(this).select2().trigger('change');
      });

    

      modal_action_form_error_clean();
    }



    function modal_action_form_error_clean() {
      // Clean all error class
      $("form#resource_request_create_form  div.form-group").each(function(){
        $(this).removeClass('has-error');
      });
      // Clean all error message
      $("form#resource_request_create_form span.help-block").each(function(){
        $(this).empty();
      });
    }


        $(document).on('click', '#RequestResource', function () {
        modal_action_form_clean('Create');
        var hidden = '';
        hidden += '<input class="form-control" id="resource_request_create" type="hidden" value="create">';
        $('#modal_action_form_hidden').append(hidden);
        $('#modal_action').modal("show");
    });
</script>
@stop