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


            <button id="RequestResource" style="display: inline-block;width: 15%;" class="btn btn-info btn-xs"  align="right" data-toggle="modal" data-target="#assign_user_modal"><span class="glyphicon glyphicon-plus">Request Resource</span></button>

         <div class="modal fade" id="assign_user_modal" role="dialog" aria- 
            labelledby="assign_user_modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="demoModalLabel">Request Resource</h5>
                <button type="button" id=close-btn class="close" data-dismiss="modal" aria- 
                                label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >

                    <form method="POST" id="modal_Request_Resource" action="">
                      <div id="modal__request_resource_formgroup" class="form-group">
                        <span id="modal_assign_user_form_customer_link_error" class="help-block"></span>
                      </div>

                       <!-- Cutomers list -->
                      <div id="modal_assign_user_formgroup_customer" class="form-group">
                        <label  class="control-label" for="modal_assign_user_form_customer">Customer</label>
                        <select class="form-control select2" style="width: 100%;" id="modal_assign_user_form_customer" data-placeholder="Select a customer">
                          @foreach($customers_list as $key => $value)
                          <option value="{{ $key }}">
                            {{ $value }}
                          </option>
                          @endforeach  
                        </select>
                        <span id="modal_assign_user_form_customer_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- Project list -->
                      <div id="modal_assign_user_formgroup_project" class="form-group">
                        <label  class="control-label" for="modal_assign_user_form_project">Project</label>
                        <select class="form-control select2" style="width: 100%;" id="modal_assign_user_form_project" data-placeholder="Select a project">
                        </select>
                        <span id="modal_assign_user_form_project_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- users list -->
                      <div id="modal_request_resource_formgroup_budgted" class="form-group">
                        <label  class="control-label" for="modal_assign_user_form_project_user">Creator</label>
                          <select class="form-control select2" id="modal_assign_user_form_project_user" name="user" data-placeholder=" Consultants" multiple="multiple">
                          @foreach($authUsersForDataView->user_list as $key => $value)
                          <option value="{{ $key }}"
                            @if(isset($authUsersForDataView->user_selected) && $key == $authUsersForDataView->user_selected) selected
                            @endif>
                            {{ $value }}
                          </option>
                          @endforeach
                        </select>
                        <span id="modal_assign_user_form_project_user_error" class="help-block"></span>
                      </div>
                      <!-- End -->

                      <!-- Budgeted -->
                      <div id="modal_assign_user_formgroup_customer" class="form-group">
                        <label  class="control-label" for="modal_request_resource_form_budgted">Budgted</label>
                        <select class="form-control select2" style="width: 100%;" id="modal_request_resource_form_budgted" data-placeholder="Select a customer">
                          <option value=""></option>
                         <option value="Yes">
                            Yes
                          </option>
                          <option value="No">
                            No
                          </option>
                        </select>
                        <span id="modal_request_resource_form_budgted_error" class="help-block"></span>
                      </div>
                      <!-- End -->


                      <!-- Consulting Request -->
                      <div id="modal_request_resource_formgroup_consulting_request" class="form-group">
                        <label  class="control-label" for="modal_request_resource_form_consulting_request">Consulting Request</label>
                        <input type="text" class="form-control" id="modal_request_resource_form_consulting_request">
                        <span id="modal_request_resource_form_consulting_request_error" class="help-block"></span>
                      </div>
                      <!-- End -->


                      <!-- PR -->
                      <div id="modal_request_resource_formgroup_pr" class="form-group">
                        <label  class="control-label" for="modal_request_resource_form_pr">PR</label>
                        <input type="text" class="form-control" id="pr">
                        <span id="modal_request_resource_form_pr_error" class="help-block"></span>
                      </div>
                      <!-- End -->

                      <!-- PO -->
                      <div id="modal_request_resource_formgroup_po" class="form-group">
                        <label  class="control-label" for="modal_request_resource_form_po">PO</label>
                        <input type="text" class="form-control" id="po">
                        <span id="modal_request_resource_form_po_error" class="help-block"></span>
                      </div>
                      <!-- End -->

                      <!-- Users domain list -->
                      <div id="modal_assign_user_formgroup_customer" class="form-group">
                        <label  class="control-label" for="modal_assign_user_form_domain_user">User Practices</label>
                        <select class="form-control select2" style="width: 100%;" id="modal_assign_user_form_domain_user" data-placeholder="Select a Practice">y
                          <option value=""></option>

                          @foreach(config('domains.domain-users') as $domain)
                            <option value="{{ $domain }}"
                             >
                              {{$domain}}
                            </option>
                            @endforeach
                        </select>
                        <span id="modal_assign_user_form_domain_user_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- Contractor name -->
                      <div id="modal_request_resource_formgroup_contractor_name" class="form-group">
                        <label  class="control-label" for="modal_request_resource_form_contractor_name">Contractor name</label>
                        <input type="text" class="form-control" id="contractor_name">
                        <span id="modal_request_resource_form_contractor_name_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- Duration -->
                      <div id="modal_request_resource_formgroup_duration" class="form-group">
                        <label  class="control-label" for="modal_request_resource_duration">Duration</label>
                        <input type="text" class="form-control" id="modal_request_resource_durarion" required>

                        <span id="modal_request_resource_form_duration_error" class="help-block"></span>
                      </div>
                      <!-- End -->

                      <!-- Case status -->
                      <div id="modal_assign_user_formgroup_customer" class="form-group">
                        <label  class="control-label" for="modal_request_resource_form_case_status">Case status</label>
                        <select class="form-control select2" style="width: 100%;" id="modal_request_resource_form_case_status" data-placeholder="Select a customer">
                        <option value=""></option>

                         <option value="Completed">
                            Completed
                          </option>
                          <option value="Init">
                            Init
                          </option>
                        </select>
                        <span id="modal_request_resource_form_case_status_error" class="help-block"></span>
                      </div>
                      <!-- End -->


                      <!-- EWR status -->
                      <div id="modal_assign_user_formgroup_customer" class="form-group">
                        <label  class="control-label" for="modal_request_resource_form_ewr_status">EWR status</label>
                        <select class="form-control select2" style="width: 100%;" id="modal_request_resource_form_ewr_status" data-placeholder="Select a customer">
                        <option value=""></option>
                         <option value="Accepted">
                            Accepted
                          </option>
                          <option value="Waiting">
                            Waiting
                          </option>
                        </select>
                        <span id="modal_request_resource_form_ewr_status_error" class="help-block"></span>
                      </div>
                      <!-- End -->


                      <!-- supplier -->
                      <div id="modal_request_resource_formgroup_supplier" class="form-group">
                        <label  class="control-label" for="modal_request_resource_form_spplier">Supplier</label>
                        <input type="text" class="form-control" id="supplier">
                        <span id="modal_request_resource_form_supplier_error" class="help-block"></span>
                      </div>
                      <!-- End -->



                      <!-- revenue -->
                     <div id="modal_request_resource_formgroup_revenue" class="form-group">
                        <label  class="control-label" for="modal_request_resource_revenue">Revenue</label>
                        <input type="text" class="form-control" id="modal_request_resource_revenue" required>

                        <span id="modal_request_resource_form_revenue_error" class="help-block"></span>
                      </div>
                      <!-- End -->


                      <!-- Cost -->
                      <div id="modal_request_resource_formgroup_cost" class="form-group">
                        <label  class="control-label" for="modal_request_resource_form_cost">Cost</label>
                        <input type="text" class="form-control" id="modal_request_resource_form_cost" required>
                        <span id="modal_request_resource_form_cost_error" class="help-block"></span>
                      </div>
                      <!-- End -->


                      <!-- Currency -->
                      <div id="modal_assign_user_formgroup_currency" class="form-group">
                        <label  class="control-label" for="modal_request_resource_form_currency">Currency</label>
                        <select class="form-control select2" style="width: 100%;" id="modal_request_resource_form_currency" data-placeholder="Select Currency" required>
                        <option value=""></option>
                         <option value="EUR">
                            EUR
                          </option>
                          <option value="USD">
                            USD
                          </option>
                        </select>
                        <span id="modal_request_resource_form_currency_error" class="help-block"></span>
                      </div>
                      <!-- End -->


                      <!-- Margin -->
                      <div id="modal_request_resource_formgroup_margin" class="form-group">
                        <label  class="control-label" for="modal_request_resource_form_contractor_name">Margin</label>
                        <input type="number" class="form-control" id="margin" required>
                        <span id="modal_request_resource_form_margin_error" class="help-block"></span>
                      </div>
                      <!-- End -->


                      <!-- Internal Check -->
                      <div id="modal_assign_user_formgroup_customer" class="form-group">
                        <label  class="control-label" for="modal_request_resource_form_internal_check">Internal Check</label>
                        <select class="form-control select2" style="width: 100%;" id="modal_request_resource_form_internal_check" data-placeholder="Select a customer" required>
                          <option value=""></option>
                         <option value="Yes">
                            Yes
                          </option>
                          <option value="No">
                            No
                          </option>
                        </select>
                        <span id="modal_request_resource_form_internal_check_error" class="help-block"></span>
                      </div>
                      <!-- End -->



                      <!-- Reason for request -->
                      <div id="modal_request_resource_formgroup_reason_for_request" class="form-group">
                        <label  class="control-label" for="modal_request_resource_reason_for_request">Reason for request</label>
                        <textarea name="reason_for_request" class="form-control" id="reason_for_request" placeholder="Reasons of request" required></textarea> 
                        <span id="modal_request_resource_form_reason_for_request_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      
                      <!-- Description -->
                      <div id="modal_request_resource_formgroup_description" class="form-group">
                        <label  class="control-label" for="modal_request_resource_description">Description</label>
                        <textarea name="description" class="form-control" id="description" placeholder="Description"></textarea> 
                        <span id="modal_request_resource_form_description_error" class="help-block"></span>
                      </div>
                      <!-- End -->

                      <!-- Comment -->
                      <div id="modal_request_resource_formgroup_comment" class="form-group">
                        <label  class="control-label" for="modal_request_resource_comment">Comment</label>
                        <textarea name="comment" class="form-control" id="comment" placeholder="Comments"></textarea> 
                        <span id="modal_request_resource_form_comment_error" class="help-block"></span>
                      </div>
                      <!-- End -->

                      <div id="modal_error"></div>

                      </div>

                      <div class="form-group">
                          <div id="modal_assign_user_form_hidden"></div>
                      </div>

            <div class="modal-footer">
                <button type="button" id="modal_action_update_button" class="btn btn-success" >Submit Request</button>
            </div>
                    </form>



            </div>
          </div>
        </div>
      </div>

      <!-- Window content -->

      <!-- Modal update -->
       <div class="modal fade" id="modal_resource_update" role="dialog" aria- 
            labelledby="assign_user_modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="demoModalLabel">Request Resource</h5>
                <button type="button" id=close-btn class="close" data-dismiss="modal" aria- 
                                label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >

                    <form method="POST" id="modal_form_resource_update" action="">
                      <div id="modal__request_resource_formgroup" class="form-group">
                        <span id="modal_assign_user_form_customer_link_error" class="help-block"></span>
                      </div>

                       <!-- Cutomers list -->
                      <div id="modal_resource_update_formgroup_customer" class="form-group">
                        <label  class="control-label" for="modal_assign_user_form_customer">Customer</label>
                        <select class="form-control select2" style="width: 100%;" id="modal_resource_update_form_customer" data-placeholder="Select a customer">
                          @foreach($customers_list as $key => $value)
                          <option value="{{ $key }}">
                            {{ $value }}
                          </option>
                          @endforeach  
                        </select>
                        <span id="modal_resource_update_form_customer_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- Project list -->
                      <div id="modal_resource_update_formgroup_project" class="form-group">
                        <label  class="control-label" for="modal_resource_update_form_project">Project</label>
                        <select class="form-control select2" style="width: 100%;" id="modal_resource_update_form_project" data-placeholder="Select a project">
                        </select>
                        <span id="modal_resource_update_form_project_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- users list -->
                      <div id="modal_resource_update_formgroup_budgted" class="form-group">
                        <label  class="control-label" for="modal_resource_update_form_project_user">Creator</label>
                          <select class="form-control select2" id="modal_resource_update_form_project_user" name="user" data-placeholder=" Consultants" multiple="multiple">
                          @foreach($authUsersForDataView->user_list as $key => $value)
                          <option value="{{ $key }}"
                            @if(isset($authUsersForDataView->user_selected) && $key == $authUsersForDataView->user_selected) selected
                            @endif>
                            {{ $value }}
                          </option>
                          @endforeach
                        </select>
                        <span id="modal_resource_update_form_project_user_error" class="help-block"></span>
                      </div>
                      <!-- End -->

                      <!-- Budgeted -->
                      <div id="modal_assign_user_formgroup_customer" class="form-group">
                        <label  class="control-label" for="modal_resource_update_form_budgted">Budgted</label>
                        <select class="form-control select2" style="width: 100%;" id="modal_resource_update_budgted" data-placeholder="Select a customer">
                          <option value=""></option>
                         <option value="Yes">
                            Yes
                          </option>
                          <option value="No">
                            No
                          </option>
                        </select>
                        <span id="modal_resource_update_form_budgted_error" class="help-block"></span>
                      </div>
                      <!-- End -->


                      <!-- Consulting Request -->
                      <div id="modal_resource_update_formgroup_consulting_request" class="form-group">
                        <label  class="control-label" for="modal_resource_update_form_consulting_request">Consulting Request</label>
                        <input type="text" class="form-control" id="modal_resource_update_form_consulting_request">
                        <span id="modal_resource_update_form_consulting_request_error" class="help-block"></span>
                      </div>
                      <!-- End -->


                      <!-- PR -->
                      <div id="modal_resource_update_formgroup_pr" class="form-group">
                        <label  class="control-label" for="modal_resource_update_pr">PR</label>
                        <input type="text" class="form-control" id="modal_resource_update_pr">
                        <span id="modal_resource_update_pr_error" class="help-block"></span>
                      </div>
                      <!-- End -->

                      <!-- PO -->
                      <div id="modal_resource_update_formgroup_po" class="form-group">
                        <label  class="control-label" for="modal_resource_update_po">PO</label>
                        <input type="text" class="form-control" id="modal_resource_update_po">
                        <span id="modal_resource_update_po_error" class="help-block"></span>
                      </div>
                      <!-- End -->

                      <!-- Users domain list -->
                      <div id="modal_resource_update_formgroup_customer" class="form-group">
                        <label  class="control-label" for="modal_resource_update_form_domain_user">User Practices</label>
                        <select class="form-control select2" style="width: 100%;" id="modal_resource_update_form_domain_user" data-placeholder="Select a Practice">y
                          <option value=""></option>

                          @foreach(config('domains.domain-users') as $domain)
                            <option value="{{ $domain }}"
                             >
                              {{$domain}}
                            </option>
                            @endforeach
                        </select>
                        <span id="modal_resource_update_form_domain_user_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- Contractor name -->
                      <div id="modal_resource_update_formgroup_contractor_name" class="form-group">
                        <label  class="control-label" for="modal_resource_update_contractor_name">Contractor name</label>
                        <input type="text" class="form-control" id="modal_resource_update_contractor_name">
                        <span id="modal_resource_update_contractor_name_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      <!-- Duration -->
                      <div id="modal_resource_update_formgroup_duration" class="form-group">
                        <label  class="control-label" for="modal_resource_update_duration">Duration</label>
                        <input type="text" class="form-control" id="modal_resource_update_duration" required>

                        <span id="modal_resource_update_form_duration_error" class="help-block"></span>
                      </div>
                      <!-- End -->

                      <!-- Case status -->
                      <div id="modal_resource_update_formgroup_customer" class="form-group">
                        <label  class="control-label" for="modal_resource_update_form_case_status">Case status</label>
                        <select class="form-control select2" style="width: 100%;" id="modal_resource_update_case_status" data-placeholder="Select a customer">
                        <option value=""></option>

                         <option value="Completed">
                            Completed
                          </option>
                          <option value="Init">
                            Init
                          </option>
                        </select>
                        <span id="modal_resource_update_form_case_status_error" class="help-block"></span>
                      </div>
                      <!-- End -->


                      <!-- EWR status -->
                      <div id="modal_resource_update_formgroup_customer" class="form-group">
                        <label  class="control-label" for="modal_resource_update_form_ewr_status">EWR status</label>
                        <select class="form-control select2" style="width: 100%;" id="modal_resource_update_ewr_status" data-placeholder="Select a customer">
                        <option value=""></option>
                         <option value="Accepted">
                            Accepted
                          </option>
                          <option value="Waiting">
                            Waiting
                          </option>
                        </select>
                        <span id="modal_resource_update_form_ewr_status_error" class="help-block"></span>
                      </div>
                      <!-- End -->


                      <!-- supplier -->
                      <div id="modal_resource_update_formgroup_supplier" class="form-group">
                        <label  class="control-label" for="modal_resource_update_supplier">Supplier</label>
                        <input type="text" class="form-control" id="modal_resource_update_supplier">
                        <span id="modal_resource_update_form_supplier_error" class="help-block"></span>
                      </div>
                      <!-- End -->



                      <!-- revenue -->
                     <div id="modal_resource_update_formgroup_revenue" class="form-group">
                        <label  class="control-label" for="modal_resource_update_revenue">Revenue</label>
                        <input type="text" class="form-control" id="modal_resource_update_revenue" required>

                        <span id="modal_resource_update_form_revenue_error" class="help-block"></span>
                      </div>
                      <!-- End -->


                      <!-- Cost -->
                      <div id="modal_resource_update_formgroup_cost" class="form-group">
                        <label  class="control-label" for="modal_resource_update_form_cost">Cost</label>
                        <input type="text" class="form-control" id="modal_resource_update_form_cost" required>
                        <span id="modal_resource_update_form_cost_error" class="help-block"></span>
                      </div>
                      <!-- End -->


                      <!-- Currency -->
                      <div id="modal_resource_update_formgroup_currency" class="form-group">
                        <label  class="control-label" for="modal_resource_update_form_currency">Currency</label>
                        <select class="form-control select2" style="width: 100%;" id="modal_resource_update_currency" data-placeholder="Select Currency" required>
                        <option value=""></option>
                         <option value="EUR">
                            EUR
                          </option>
                          <option value="USD">
                            USD
                          </option>
                        </select>
                        <span id="modal_resource_update_form_currency_error" class="help-block"></span>
                      </div>
                      <!-- End -->


                      <!-- Margin -->
                      <div id="modal_resource_update_formgroup_margin" class="form-group">
                        <label  class="control-label" for="modal_resource_update_margin">Margin</label>
                        <input type="number" class="form-control" id="modal_resource_update_margin" required>
                        <span id="modal_resource_update_form_margin_error" class="help-block"></span>
                      </div>
                      <!-- End -->


                      <!-- Internal Check -->
                      <div id="modal_resource_update_formgroup_customer" class="form-group">
                        <label  class="control-label" for="modal_resource_update_form_internal_check">Internal Check</label>
                        <select class="form-control select2" style="width: 100%;" id="modal_resource_update_internal_check" data-placeholder="Select a customer" required>
                          <option value=""></option>
                         <option value="Yes">
                            Yes
                          </option>
                          <option value="No">
                            No
                          </option>
                        </select>
                        <span id="modal_resource_update_form_internal_check_error" class="help-block"></span>
                      </div>
                      <!-- End -->



                      <!-- Reason for request -->
                      <div id="modal_resource_update_formgroup_reason_for_request" class="form-group">
                        <label  class="control-label" for="modal_resource_update_reason_for_request">Reason for request</label>
                        <textarea name="reason_for_request" class="form-control" id="modal_resource_update_reason_request" placeholder="Reasons of request" required></textarea> 
                        <span id="modal_resource_update_form_reason_for_request_error" class="help-block"></span>
                      </div>
                      <!-- End -->
                      
                      <!-- Description -->
                      <div id="modal_resource_update_formgroup_description" class="form-group">
                        <label  class="control-label" for="modal_resource_update_for_description">Description</label>
                        <textarea name="description" class="form-control" id="modal_resource_update_description" placeholder="Description"></textarea> 
                        <span id="modal_resource_update_form_description_error" class="help-block"></span>
                      </div>
                      <!-- End -->

                      <!-- Comment -->
                      <div id="modal_resource_update_formgroup_comment" class="form-group">
                        <label  class="control-label" for="modal_resource_update_for_comment">Comment</label>
                        <textarea name="comment" class="form-control" id="modal_resource_update_comment" placeholder="Comments"></textarea> 
                        <span id="modal_resource_update_form_comment_error" class="help-block"></span>
                      </div>
                      <!-- End -->

                      <div id="modal_error"></div>

                      </div>

                      <div class="form-group">
                          <div id="modal_resource_update_form_hidden"></div>
                      </div>

            <div class="modal-footer">
                <button type="button" id="modal_action_update_request_button" class="btn btn-success" >Update Request</button>
            </div>
                    </form>



            </div>
          </div>
        </div>
      </div>
      <!-- End of modal update -->
      

<div>


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

              $('#modal_assign_user_form_project').empty();
              $('#modal_assign_user_form_project').append(html);
              // Set selected 
              $('#modal_assign_user_form_project').val(project_list[0].id);
              $('#modal_assign_user_form_project').select2().trigger('change');
            },
            error: function (jqXhr, textStatus, errorMessage) { // error callback 
              console.log('Error: ' + errorMessage);
            }
      });
    }



    $('#modal_assign_user_form_customer').on('change', function() {
      $('select#modal_assign_user_form_project').val($(this).data(''));
      $('select#modal_assign_user_form_project').select2().trigger('change');
      customer_id = $('#modal_assign_user_form_customer').val();
      var customer_link_id = $('select#modal_assign_user_form_customer_link').val();

      // console.log(customer_id);

          change_project_select(customer_id);

    });

    $('#modal_assign_user_form_project').on('change', function() {
      var project_id = $('#modal_assign_user_form_project').val();


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
$("#modal_assign_user_form_customer").select2({
          allowClear: false
      });
 $("#modal_assign_user_form_project").select2({
          allowClear: false
      });

$("#modal_assign_user_form_project_user").select2({
          allowClear: false
      });


$("#modal_request_resource_form_budgted").select2({
          allowClear: false
      });


$("#modal_assign_user_form_domain_user").select2({
          allowClear: false
      });


$("#modal_request_resource_form_case_status").select2({
          allowClear: false
      });


$("#modal_request_resource_form_ewr_status").select2({
          allowClear: false
      });


$("#modal_request_resource_form_currency").select2({
          allowClear: false
      });


$("#modal_request_resource_form_internal_check").select2({
          allowClear: false
      });

// modal_resource_update
$("#modal_resource_update_form_customer").select2({
          allowClear: false
      });
 $("#modal_resource_update_form_project").select2({
          allowClear: false
      });

$("#modal_resource_update_form_project_user").select2({
          allowClear: false
      });


$("#modal_resource_update_form_budgted").select2({
          allowClear: false
      });


$("#modal_resource_update_form_domain_user").select2({
          allowClear: false
      });


$("#modal_resource_update_form_case_status").select2({
          allowClear: false
      });


$("#modal_resource_update_ewr_status").select2({
          allowClear: false
      });


$("#modal_resource_update_form_currency").select2({
          allowClear: false
      });


$("#modal_resource_update_form_internal_check").select2({
          allowClear: false
      });
// send data to controller

// $(document).on('click','#modal_action_update_button',function(){
$(document).on('click', '#modal_action_update_button', function () {

  let user = $('select#modal_assign_user_form_project_user').val();
  let project = $('select#modal_assign_user_form_project').val();
  let budget = $('select#modal_request_resource_form_budgted').val();
  let consulting_request = $('#modal_request_resource_form_consulting_request').val();
  let currecny = $('select#modal_request_resource_form_currency').val();
  let po = $('#po').val();
  let pr = $('#pr').val();
  let practices = $('select#modal_assign_user_form_domain_user').val();
  let contractor_name = $('#contractor_name').val();
  let supplier = $('#supplier').val();
  let case_status = $('select#modal_request_resource_form_case_status').val();
  let duration = $('#modal_request_resource_durarion').val();
  let ewr_status = $('select#modal_request_resource_form_ewr_status').val();
  let revenue = $('#modal_request_resource_revenue').val();
  let cost = $('#modal_request_resource_form_cost').val();
  let margin = $('#margin').val();
  let internal_check = $('select#modal_request_resource_form_internal_check').val();
  let reason_for_request = $('#reason_for_request').val();
  let description = $('#description').val();
  let comment = $('#comment').val();



console.log(currecny);

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
                            $('#assign_user_modal').modal('hide');
                            location.reload();
                        }
                    },
        dataType: "JSON",
    });



  

})


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
    $(document).on('click', '.buttonUpdateRequest', function () {
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
                        $('#modal_resource_update_budgted').val(data[0]['Budgeted']);
                        $('select#modal_resource_update_form_project_user').val();
                        $('select#modal_resource_update_form_project').val();
                        // $('select#modal_resource_update_form_budgted').val();
                        $('#modal_resource_update_form_consulting_request').val(data[0]['consulting_request']);
                        $('select#modal_resource_update_currency').val(data[0]['currency']);
                        $('#modal_resource_update_po').val(data[0]['PO']);
                        $('#modal_resource_update_pr').val(data[0]['PR']);
                        $('select#modal_resource_update_form_domain_user').val(data[0]['practice']);
                        $('#modal_resource_update_contractor_name').val(data[0]['contractor_name']);
                        $('#modal_resource_update_supplier').val(data[0]['supplier']);
                        $('#modal_resource_update_case_status').val(data[0]['case_status']);
                        $('#modal_resource_update_duration').val(data[0]['duration']);

                        $('#modal_resource_update_ewr_status').val(data[0]['EWR_status']);

                        $('#modal_resource_update_revenue').val(data[0]['revenue']);
                        $('#modal_resource_update_form_cost').val(data[0]['cost']);
                        $('#modal_resource_update_margin').val(data[0]['margin']);
                        $('select#modal_resource_update_internal_check').val(data[0]['internal_check']);
                        $('#modal_resource_update_reason_request').val(data[0]['reason_for_request']);
                        $('#modal_resource_update_description').val(data[0]['description']);
                        $('#modal_resource_update_comment').val(data[0]['comments']);

                        $("#modal_resource_update_budgted").select2({
                                allowClear: true
                            });
                        $("#modal_resource_update_case_status").select2({
                                allowClear: true
                            });
                        $("#modal_resource_update_currency").select2({
                                allowClear: true
                            });
                        $("#modal_resource_update_internal_check").select2({
                                allowClear: true
                            });
                        $("#modal_resource_update_form_domain_user").select2({
                                allowClear: true
                            });
                        $("#modal_resource_update_ewr_status").select2({
                                allowClear: true
                            });

                        
                    }
                });
            
        
    });

    $(document).on('click', '#modal_action_update_request_button', function () {

// update modal field 
  let user = $('select#modal_resource_update_form_project_user').val();
  let project = $('select#modal_resource_update_form_project').val();
  let budget = $('select#modal_resource_update_budgted').val();
  let consulting_request = $('#modal_resource_update_form_consulting_request').val();
  let currecny = $('select#modal_resource_update_currency').val();
  let po = $('#modal_resource_update_po').val();
  let pr = $('#modal_resource_update_pr').val();
  let practices = $('select#modal_resource_update_form_domain_user').val();
  let contractor_name = $('#modal_resource_update_contractor_name').val();
  let supplier = $('#modal_resource_update_supplier').val();
  let case_status = $('select#modal_resource_update_case_status').val();
  let duration = $('#modal_resource_update_duration').val();
  let ewr_status = $('select#modal_resource_update_ewr_status').val();
  let revenue = $('#modal_resource_update_revenue').val();
  let cost = $('#modal_resource_update_form_cost').val();
  let margin = $('#modal_resource_update_margin').val();
  let internal_check = $('select#modal_resource_update_internal_check').val();
  let reason_for_request = $('#modal_resource_update_reason_request').val();
  let description = $('#modal_resource_update_description').val();
  let comment = $('#modal_resource_update_comment').val();



console.log(ewr_status);

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
                        $('#modal_resource_update').modal('hide');
                        requestsTable.ajax.reload();
                    }
                });
            
        
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
              { name: 'resources_request.ewr_status', data: 'ewr_status' , searchable: true, visible: true,

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
                      actions +='<button id="'+data.id+'" class="buttonUpdateRequest btn btn-primary" data-toggle="modal" data-target="#modal_resource_update"><span class="glyphicon glyphicon-pencil"></span></button>';
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


</script>
@stop