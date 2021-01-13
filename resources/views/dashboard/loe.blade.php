@extends('layouts.app')

@section('style')
    <!-- CSS -->
    <!-- Select2 -->
    <link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Document styling -->
    <link href="{{ asset('/css/loe.css') }}" rel="stylesheet" />

@stop

@section('scriptsrc')
    <!-- JS -->
    <!-- Select2 -->
    <script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
    <!-- Table Excel -->
    <script src="{{ asset('/plugins/sheetjs/dist/xlsx.core.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/FileSaver/FileSaver.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/TableExport/tableExport.min.js') }}" type="text/javascript"></script>
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>LoE dashboard</h3>
  </div>
</div>
<div class="clearfix"></div>
<!-- Page title -->

<!-- Window -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window content -->
      <div class="x_content">

        <div class="form-group row">
          <div class="col-xs-3">
            <label for="customer" class="control-label">Customer</label>
            <select class="form-control select2" style="width: 100%;" id="customer" name="customer" data-placeholder="Select a customer">
              @foreach($customers_list as $key => $value)
              <option value="{{ $key }}">
                {{ $value }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-xs-3">
            <label for="project" class="control-label">Project</label>
            <select class="form-control select2" style="width: 100%;" id="project" name="project" data-placeholder="Select a project">
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col-md-1">
            <div class="dropdown">
              <button id="options_loe" class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
              <span class="glyphicon glyphicon-cog"></span><i class="fa fa-sort-desc"></i>
              </button>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Report</li>
                <li><a class="dropdown-selection" id="loe_table_to_excel" href="#">Export to Excel</a></li>
                <li class="dropdown-header">Tools</li>
                <li><a class="dropdown-selection hide_columns" href="#">Hide Columns</a></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered table-sm" cellspacing="0" width="100%" id="LoeTable"></table>
          </div>
        </div>

        <!-- Loe hide Modal -->
        <div class="modal fade" id="modal_loe_hidecol" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" style="display:table;">
              <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modal_loe_hidecol_title">Hide columns</h4>
                </div>
                <!-- Modal Header -->
              
                <!-- Modal Body -->
                <div class="modal-body">
                  <form id="modal_loe_hidecol_form" role="form" method="POST" action="">
                  </form>
                </div>
                  
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
          </div>
      </div>
      <!-- Loe hide Modal -->
      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->
@stop

@section('script')
<script>

$(document).ready(function() {
  var customer = $('#customer').val();
  var project_id;
  var project_name;

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

  //region Init
  //Init select2 boxes
  $("#customer").select2({
    allowClear: false
  });
  $("#project").select2({
    allowClear: false
  });

  //Init Customer and projects
  change_project_select(customer);

  function change_project_select(customer_id) {
    $.ajax({
            type: 'get',
            url: "{!! route('loeDashboardProjects','') !!}/"+customer_id,
            dataType: 'json',
            success: function(data) {
              project_list = data;
              //console.log(project_list);
              var html = '';
              project_list.forEach(fill_project_select);
              function fill_project_select (project){
                html += '<option value="'+project.id+'" >'+project.project_name+'</option>';
              }

              $('#project').empty();
              $('#project').append(html);
              // Set selected 
              $('#project').val(project_list[0].id);
              $('#project').select2().trigger('change');
            },
            error: function (jqXhr, textStatus, errorMessage) { // error callback 
              console.log('Error: ' + errorMessage);
            }
          });
  }

  $('#customer').on('change', function() {
    $('select#project').val($(this).data(''));
    $('select#project').select2().trigger('change');
    customer_id = $('#customer').val();
    change_project_select(customer_id);
  });

  $('#project').on('change', function() {
    project_id = $('select#project').children("option:selected").val();
    project_name = $('select#project').children("option:selected").text();
    if (project_id > 0) {
      //console.log(project_id);
      getLoeList(project_id);
    }
    
  });
  //endregion

  //region LoeInit
  // Now we need to check if there is colhide in cookies...
  var load_loe_hide_cookie = Cookies.get("loe_hide_columns");
  if (typeof load_loe_hide_cookie !== 'undefined') {
  var colhide = JSON.parse(load_loe_hide_cookie);
  } else {
  var colhide = [
    {'name':'main_phase','hide':false},
    {'name':'secondary_phase','hide':false},
    {'name':'domain','hide':false},
    {'name':'description','hide':false},
    {'name':'option','hide':false},
    {'name':'assumption','hide':false},
    {'name':'site','hide':false},
    {'name':'quantity','hide':false},
    {'name':'loe_per_unit','hide':false},
    {'name':'formula','hide':false},
    {'name':'recurrent','hide':false},
    {'name':'start_date','hide':false},
    {'name':'end_date','hide':false},
    {'name':'consulting','hide':false},
    {'name':'total_loe','hide':false},
    {'name':'total_cost','hide':false},
    {'name':'total_price','hide':false},
    {'name':'margin','hide':false}
  ];
  }
  //endregion

  //region Loe hide columns
  // LoE hide columns
  $(document).on('click', '.hide_columns', function () {
    $('#modal_loe_hidecol_form').empty();
    var html = '';
    colhide.forEach(hide_columns_choice);
    function hide_columns_choice (col,index){
      if (col.hide) {
        checked_val = 'checked';
      } else {
        checked_val = '';
      }
      html += '<div class="checkbox">';
      html += '<label><input type="checkbox" data-array_id="'+index+'" class="colhidecheckbox" value="" '+checked_val+'>'+col.name+'</label>';
      html += '</div>';
    }
    $('#modal_loe_hidecol_form').prepend(html);

    $('#modal_loe_hidecol').modal("show");
  });
  
  //jQuery listen for checkbox change
  $(document).on('change', '.colhidecheckbox', function () {
    key = $(this).data('array_id');
      if(this.checked) {
        colhide[key].hide = true;
      } else {
        colhide[key].hide = false;
      }
      Cookies.set("loe_hide_columns", JSON.stringify(colhide));
      columns_hide();
  });

  function columns_hide() {
    colhide.forEach(hide_columns);
    function hide_columns (col,index){
      if (col.hide) {
        $('[data-colname="'+col.name+'"]').each(function(){
          $(this).attr('data-tableexport-display','none');
          $(this).hide();
        });
      } else {
        $('[data-colname="'+col.name+'"]').each(function(){
          $(this).attr('data-tableexport-display','');
          $(this).show();
        });
      }
    }
  }
  //endregion

  //region Export table to excel
  $(document).on('click', '#loe_table_to_excel', function () {
    d = new Date();
    date = d.toISOString();
    filename = 'LoE_'+project_name+'_'+date;

    $('.table_recurrent').empty();
    $('.table_recurrent').html('yes');

    if (loe_data.col.site.length>0) {
      $('.sites_header').empty();
      $('td.formula_cell').each(function () {
        formula_text = $(this).find('.formula_text').html();
        $(this).empty();
        $(this).append(formula_text);
      });
    }
    
    if (loe_data.col.cons.length>0) {
      $('.consultants_header').empty();
      $('.consultants_main_header').each(function () {
        value = $(this).html().split('<div');
        const search = '<br>';
        const replaceWith = '-';
        const html = value[0].split(search).join(replaceWith);
        $(this).empty();
        $(this).append(html);
      });
    }
    
    $('#LoeTable').tableExport({
      fileName: filename, 
      type:'excel',
      exportHiddenCells: false,
      htmlContent: false,
      mso: {
          fileFormat:'xlsx'
      }
    });

    getLoeList(project_id);

  });
  //endregion

  //region Show table
  function getBusinessDatesCount(start, end) {
    var startDate = new Date(start);
    var endDate = new Date(end);
    var count = 0;
    var curDate = startDate;
    while (curDate <= endDate) {
        var dayOfWeek = curDate.getDay();
        if(!((dayOfWeek == 6) || (dayOfWeek == 0)))
          count++;
        curDate.setDate(curDate.getDate() + 1);
    }
    return count;
  }

  function td_no_null(item,end='',colname='') {
    if (item != null && item != '') {
      return '<td data-colname="'+colname+'">'+item+end+'</td>';
    } else {
      return '<td data-colname="'+colname+'"></td>';
    }
  }

  function getLoeList(project_id){
      $('#LoeTable').empty();
      $.ajax({
        type: 'get',
        url: "{!! route('listFromProjectID','') !!}/"+project_id,
        dataType: 'json',
        success: function(data) {

          loe_data = data;
          console.log(data);

          if (data.length != 0) {
            // First we need to hide the create button
            $('#create_loe').hide();
            $('#options_loe').show();

            // Then we need to create the headers for the table
            html = '<thead>';
            //region First header
            html += '<tr>';
            html += '<th rowspan="3" data-colname="main_phase" style="min-width:150px;">'+'Main Phase'+'</th>';
            html += '<th rowspan="3" data-colname="secondary_phase" style="min-width:150px;">'+'Secondary Phase'+'</th>';
            html += '<th rowspan="3" data-colname="domain" style="min-width:150px;">'+'Domain'+'</th>';
            html += '<th rowspan="3" data-colname="description" style="min-width:250px;">'+'Description'+'</th>';
            html += '<th rowspan="3" data-colname="option" style="min-width:150px;">'+'Option'+'</th>';
            html += '<th rowspan="3" data-colname="assumption" style="min-width:250px;">'+'Assumption'+'</th>';
            if (data.col.site.length>0) {
              html += '<th data-colname="site" colspan="'+2*data.col.site.length+'">'+'Site calculation'+'</th>';
            }
            html += '<th data-colname="quantity" rowspan="3">'+'Quantity'+'</th>';
            html += '<th data-colname="loe_per_unit" rowspan="3">'+'LoE<br>(per unit)<br>in days'+'</th>';
            if (data.col.site.length>0) {
              html += '<th data-colname="formula" rowspan="3" style="min-width:150px;">'+'Formula'+'</th>';
            }
            
            html += '<th data-colname="recurrent" rowspan="3">'+'recurrent'+'</th>';
            html += '<th data-colname="start_date" rowspan="3" style="min-width:150px;">'+'Start date'+'</th>';
            html += '<th data-colname="end_date" rowspan="3" style="min-width:150px;">'+'End date'+'</th>';
            if (data.col.cons.length>0) {
              html += '<th data-colname="consulting" colspan="'+4*data.col.cons.length+'">'+'Consulting type'+'</th>';
            }
            
            html += '<th data-colname="total_loe" rowspan="3">'+'Total Loe'+'</th>';
            if (data.col.cons.length>0) {
              html += '<th data-colname="total_cost" rowspan="3">'+'Total Cost (€)'+'</th>';
              html += '<th data-colname="total_price" rowspan="3">'+'Total Price (€)'+'</th>';
              html += '<th data-colname="margin" rowspan="3">'+'Margin (%)'+'</th>';
            }
            html += '</tr>';
            //endregion
            //region Second header
            html += '<tr>';
            
            data.col.site.forEach(function(site){
              html += '<th data-colname="site" colspan="2">';
              html += '<span class="inline">'+site.name+'</span>';
              html += `<div class="dropdown sites_header">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-sort-desc"></i></a>
                        <ul class="dropdown-menu">
                          <li class="dropdown-header">Calculation</li>
                          <li><a class="dropdown-selection site_edit" data-name="`+site.name+`" href="#">Edit</a></li>
                          <li><a class="dropdown-selection site_delete" data-name="`+site.name+`" href="#">Delete</a></li>
                        </ul>
                      </div>`;
              html += '</th>';
            });
            
            data.col.cons.forEach(function(cons){
              html += '<th class="consultants_main_header" data-colname="consulting" colspan="4" style="min-width:180px;">'
              html += cons.name;
              html += '<br>';
              if (cons.seniority != null) {
                html += cons.seniority;
              } else {
                html += '';
              }
              html += '<br>';
              if (cons.location != null) {
                html += cons.location;
              } else {
                html += '';
              }
              html += `<div class="dropdown consultants_header">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-sort-desc"></i></a>
                        <ul class="dropdown-menu">
                          <li class="dropdown-header">Consulting type</li>
                          <li><a class="dropdown-selection cons_edit" data-name="`+cons.name+`" data-seniority="`+cons.seniority+`" data-location="`+cons.location+`" href="#">Edit</a></li>
                          <li><a class="dropdown-selection cons_delete" data-name="`+cons.name+`" data-seniority="`+cons.seniority+`" data-location="`+cons.location+`" href="#">Delete</a></li>
                        </ul>
                      </div>`;
              html += '</th>';
            });

            html += '</tr>';
            //endregion
            //region Third header
            html += '<tr>';
            
            data.col.site.forEach(function(site){
              html += '<th data-colname="site">Quantity</th>';
              html += '<th data-colname="site">LoE<br>(per unit)<br>in days</th>';
            });
            data.col.cons.forEach(function(cons){
              html += '<th data-colname="consulting" data-tableexport-xlsxformatid="49">%</th>';
              html += '<th data-colname="consulting">MD</th>';
              html += '<th data-colname="consulting">Cost (€)</th>';
              html += '<th data-colname="consulting">Price (€)</th>';
            });

            html += '</tr>';

            html += '</thead>';
            //endregion
            // Data filling
            var grand_total_loe = 0;
            var grand_total_cost = 0;
            var grand_total_price = 0;
            var total_loe = 0;

            //region Body
            html += '<tbody>';
            data.data.loe.forEach(function(row){

              html += '<tr data-id="'+row.id+'">';
              html += td_no_null(row.main_phase,'','main_phase');
              html += td_no_null(row.secondary_phase,'','secondary_phase');
              html += td_no_null(row.domain,'','domain');
              description_formatted = row.description.replace(/\r?\n|\r/g,'<br>');
              html += td_no_null(description_formatted,'','description');
              html += td_no_null(row.option,'','option');
              assumption_formatted = row.assumption.replace(/\r?\n|\r/g,'<br>');
              html += td_no_null(assumption_formatted,'','assumption');

              //console.log('row: '+row.id);
              data.col.site.forEach(fill_site_data);
              function fill_site_data (site){
                
                if (data.data.site.hasOwnProperty(row.id) && data.data.site[row.id].hasOwnProperty(site.name)) {
                  //console.log(site.name+': '+data.data.site[row.id][site.name]['quantity']);
                  fill_quantity = data.data.site[row.id][site.name].quantity;
                  fill_loe_per_quantity = data.data.site[row.id][site.name].loe_per_quantity;
                } else {
                  //console.log(site.name+': -');
                  fill_quantity = 0;
                  fill_loe_per_quantity = 0;
                }
                html += '<td data-colname="site">'+fill_quantity+'</td>';
                html += '<td data-colname="site">'+fill_loe_per_quantity+'</td>';
              }

              html += '<td data-colname="quantity">'+row.quantity+'</td>';
              html += '<td data-colname="loe_per_unit">'+row.loe_per_quantity+'</td>';

              if (data.col.site.length>0) {
                if (row.formula != null && row.formula != '') {
                  html +=  '<td class="formula_cell" data-colname="formula">';
                  html += `<div class="dropdown">
                        
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-check"></i></a>
                            
                            <ul class="dropdown-menu">
                              <li class="dropdown-header">Calculation</li>
                              <li class="formula_text" >`+row.formula+`</li>
                            </ul>
                          </div>`;
                    html +=  '</td>';
                } else {
                  html +=  '<td data-colname="formula"></td>';
                }
              }
              
              if (row.recurrent == 1) {
                html += '<td data-colname="recurrent" class="table_recurrent"><i class="fa fa-check"></i></td>';
              } else {
                html += '<td data-colname="recurrent"></td>';
              }
              
              html += td_no_null(row.start_date,'','start_date');
              html += td_no_null(row.end_date,'','end_date');

              var total_price = 0;
              var total_cost = 0;
              data.col.cons.forEach(fill_cons_data);
              function fill_cons_data (cons){
                
                if (data.data.cons.hasOwnProperty(row.id) && data.data.cons[row.id].hasOwnProperty(cons.name)) {
                  //console.log(site.name+': '+data.data.site[row.id][site.name]['quantity']);
                  fill_percent = data.data.cons[row.id][cons.name].percentage;
                  if (data.data.cons[row.id][cons.name].cost != null) {
                    fill_cost = data.data.cons[row.id][cons.name].cost;
                  } else {
                    fill_cost = 0;
                  }
                  if (data.data.cons[row.id][cons.name].price != null) {
                    fill_price = data.data.cons[row.id][cons.name].price;
                  } else {
                    fill_price = 0;
                  }
                  if (row.recurrent == 0) {
                    fill_md = row.quantity*row.loe_per_quantity*fill_percent/100;
                  } else {
                    fill_md = row.quantity*row.loe_per_quantity*getBusinessDatesCount(row.start_date,row.end_date)*fill_percent/100;
                  }
                  if (fill_price != null) {
                    total_price += fill_md*fill_price;
                  }
                  if (fill_cost != null) {
                    total_cost += fill_md*fill_cost;
                  }
                  
                } else {
                  //console.log(site.name+': -');
                  fill_percent = 0;
                  fill_md = 0;
                  fill_cost = 0;
                  fill_price = 0;
                }
                html += '<td data-colname="consulting">'+fill_percent+'</td>';
                html += '<td data-colname="consulting">'+fill_md+' </td>';
                html += '<td data-colname="consulting">'+fill_cost.toFixed(1)+'</td>';
                html += '<td data-colname="consulting">'+fill_price.toFixed(1)+'</td>';
              }

              if (row.recurrent == 0) {
                total_loe = row.quantity*row.loe_per_quantity;
              } else {
                total_loe = row.quantity*row.loe_per_quantity*getBusinessDatesCount(row.start_date,row.end_date);
                //console.log(getBusinessDatesCount(row.start_date,row.end_date));
              }
              if (total_loe != null && total_loe != '') {
                html += '<td data-colname="total_loe">'+total_loe+'</td>';
              } else {
                html += '<td data-colname="total_loe"></td>';
              }
              grand_total_loe += total_loe;
              
              if (data.col.cons.length>0) {
                html += td_no_null(total_cost.toFixed(1), '','total_cost');
                html += td_no_null(total_price.toFixed(1), '','total_price');
                if (total_price > 0) {
                  gross_profit_margin = 100*(total_price-total_cost)/total_price;
                } else {
                  gross_profit_margin = 0;
                }
                html += td_no_null(gross_profit_margin.toFixed(1), '','margin');
              }
              
              grand_total_cost += total_cost;
              grand_total_price += total_price;

              html += '</tr>';
            });
            html += '</tbody>';
            //endregion
            //region Footer
            html += '<tfoot>';
            //console.log(data.col.site.length);
            //console.log(data.col.cons.length);

            html += '<td data-colname="main_phase" class="grand_total">Grand Total</td>';
            html += '<td data-colname="secondary_phase"></td>';
            html += '<td data-colname="domain"></td>';
            html += '<td data-colname="description"></td>';
            html += '<td data-colname="option"></td>';
            html += '<td data-colname="assumption"></td>';
            // We need to remove one column named formula in case there is no calculation
            for (let index = 0; index < data.col.site.length; index++) {
              html += '<td data-colname="site"></td>';
              html += '<td data-colname="site"></td>';
            }
            html += '<td data-colname="quantity"></td>';
            html += '<td data-colname="loe_per_unit"></td>';
            if (data.col.site.length != 0) {
              html += '<td data-colname="formula"></td>';
            }
            html += '<td data-colname="recurrent"></td>';
            html += '<td data-colname="start_date"></td>';
            html += '<td data-colname="end_date"></td>';
            for (let index = 0; index < data.col.cons.length; index++) {
              html += '<td data-colname="consulting"></td>';
              html += '<td data-colname="consulting"></td>';
              html += '<td data-colname="consulting"></td>';
              html += '<td data-colname="consulting"></td>';
            }


            if (grand_total_loe != null && grand_total_loe != '') {
              html += '<td data-colname="total_loe" class="grand_total">'+grand_total_loe+'</td>';
            } else {
              html += '<td data-colname="total_loe"></td>';
            }

            if (data.col.cons.length>0) {
              if (grand_total_cost != null && grand_total_cost != '') {
                html += '<td data-colname="total_cost" class="grand_total">'+grand_total_cost.toFixed(1)+'</td>';
              } else {
              html += '<td data-colname="total_cost"></td>';
              }
              if (grand_total_price != null && grand_total_price != '') {
                html += '<td data-colname="total_price" class="grand_total">'+grand_total_price.toFixed(1)+'</td>';
              } else {
              html += '<td data-colname="total_price"></td>';
              }
              if (grand_total_cost != null && grand_total_cost != '' && grand_total_price != null && grand_total_price != '' && grand_total_price > 0) {
                grand_total_gpm = 100*(grand_total_price-grand_total_cost)/grand_total_price;
                html += '<td data-colname="margin" class="grand_total">'+grand_total_gpm.toFixed(1)+'</td>';
              } else {
              html += '<td data-colname="margin"></td>';
              }
              
            }
            
            html += '</tfoot>';
            //endregion

            $('#LoeTable').prepend(html);

            columns_hide();

          } else {
            $('#create_loe').show();
            $('#options_loe').hide();
          }

        }
      });
  }
  //endregion



  // Remove the formatting to get integer data for summation
  var intVal = function ( i ) {
    return typeof i === 'string' ?
      i.replace(/[\$,]/g, '')*1 :
      typeof i === 'number' ?
          i : 0;
  };

});


</script>
@stop