@extends('layouts.app')

@section('style')
    <!-- CSS -->
    <!-- Select2 -->
    <link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/forms.css') }}" rel="stylesheet" />
    <!-- DataTables -->
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

@stop

@section('scriptsrc')
    <!-- JS -->
    <!-- Select2 -->
    <script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
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

@stop

@section('content')

<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>User Skill</h3>
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
        <h2>
          @if($action == 'create')
          Create skill
          @elseif($action == 'update')
          Update skill
          @endif
        </h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      @if($action == 'create' && $skill == null)
      <!-- Window content -->
      <div class="x_content">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="skill-tab" role="tab" data-toggle="tab" aria-expanded="true">Skills</a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2" id="certification-tab" role="tab" data-toggle="tab" aria-expanded="false">Certifications</a>
                </li>
            </ul>

            <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="skill-tab">
                    <table id="skillTable" class="table table-striped table-hover table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th>Skill ID</th>
                                <th>Domain</th>
                                <th>Sub Domain</th>
                                <th>technology</th>
                                <th>Skill</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="certification-tab">
                    <table id="certificationTable" class="table table-striped table-hover table-bordered mytable" width="100%">
                        <thead>
                            <tr>
                                <th>Skill ID</th>
                                <th>Domain</th>
                                <th>Sub Domain</th>
                                <th>technology</th>
                                <th>Certification</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
      </div>
      <!-- Window content -->

    @else
      <!-- Window content -->
      <div class="x_content">

          @if($action == 'create')
          {!! Form::open(['url' => 'userskillFormCreate', 'method' => 'post', 'class' => 'form-horizontal']) !!}
          {!! Form::hidden('skill_id', $skill->id, ['class' => 'form-control']) !!}

          @elseif($action == 'update')
          {!! Form::open(['url' => 'userskillFormUpdate/'.$userskill->id, 'method' => 'post', 'class' => 'form-horizontal']) !!}
          @endif
          <div class="row">
            <div class="col-md-1"><b>Domain</b></div>
            <div class="col-md-2"><b>Sub-domain</b></div>
            <div class="col-md-2"><b>Technology</b></div>
            <div class="col-md-2"><b>Skill</b></div>
          </div>
          <div class="row">
            <div class="col-md-1">{!! $skill->domain !!}</div>
            <div class="col-md-2">{!! $skill->subdomain !!}</div>
            <div class="col-md-2">{!! $skill->technology !!}</div>
            <div class="col-md-2">{!! $skill->skill !!}</div>
          </div>
          <br />

        <div class="row">
          <div class="form-group {!! $errors->has('user_id') ? 'has-error' : '' !!} col-md-12">
            <div class="col-md-2">
              {!! Form::label('user_id', 'User', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-10">
              {!! Form::select('user_id', $user_list, (isset($userskill)) ? $userskill->user_id : '', ['class' => 'form-control']) !!}
              {!! $errors->first('user_id', '<small class="help-block">:message</small>') !!}
            </div>
          </div>
        </div>

        <div class="row" @if($skill->certification == 1)style="display:none;"@endif>
          <div class="form-group {!! $errors->has('rating') ? 'has-error' : '' !!} col-md-12">
            <div class="col-md-2">
              {!! Form::label('rating', 'Rating', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-10">
              {!! Form::select('rating', $select, (isset($userskill)) ? $userskill->rating : '', ['class' => 'form-control']) !!}
              {!! $errors->first('rating', '<small class="help-block">:message</small>') !!}
            </div>
          </div>
        </div>

          <div class="row">
            <div class="col-md-offset-11 col-md-1">
              @if($action == 'create')
              {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
              @elseif($action == 'update')
              {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
              @endif
            </div>
          </div>
          {!! Form::close() !!}

      </div>
      <!-- Window content -->
    @endif

    </div>
  </div>
</div>
<!-- Window -->

@stop

@section('script')

<script>
var skillTable;
var certificationTable;
var record_id;

$(document).ready(function() {
  $("#user_id").select2({
    allowClear: false
    @if($action == 'update')
      ,disabled: true
    @endif
  });
  $("#rating").select2({
    allowClear: false
  });

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

skillTable = $('#skillTable').DataTable({
    serverSide: true,
    processing: true,
    stateSave: true,
    ajax: {
            url: "{!! route('listOfSkills',['0']) !!}",
            type: "POST",
            dataType: "JSON"
        },
    columns: [
        { name: 'id', data: 'id', searchable: false , visible: false },
        { name: 'domain', data: 'domain', searchable: true , visible: true },
        { name: 'subdomain', data: 'subdomain', searchable: true , visible: true },
        { name: 'technology', data: 'technology', searchable: true , visible: true },
        { name: 'skill', data: 'skill', searchable: true , visible: true },
        ],
    order: [[1, 'asc'],[2, 'asc'],[3, 'asc'],[4, 'asc']],
    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
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
        // Restore state
        var state = skillTable.state.loaded();
        if (state) {
            skillTable.columns().eq(0).each(function (colIdx) {
                var colSearch = state.columns[colIdx].search;

                if (colSearch.search) {
                    $('input', skillTable.column(colIdx).footer()).val(colSearch.search);
                }
            });

            skillTable.draw();
        }
    }
});

certificationTable = $('#certificationTable').DataTable({
    serverSide: true,
    processing: true,
    stateSave: true,
    ajax: {
            url: "{!! route('listOfSkills',['1']) !!}",
            type: "POST",
            dataType: "JSON"
        },
    columns: [
        { name: 'id', data: 'id', searchable: false , visible: false },
        { name: 'domain', data: 'domain', searchable: true , visible: true },
        { name: 'subdomain', data: 'subdomain', searchable: true , visible: true },
        { name: 'technology', data: 'technology', searchable: true , visible: true },
        { name: 'skill', data: 'skill', searchable: true , visible: true },
        ],
    order: [[1, 'asc'],[2, 'asc'],[3, 'asc'],[4, 'asc']],
    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
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
        // Restore state
        var state = certificationTable.state.loaded();
        if (state) {
            certificationTable.columns().eq(0).each(function (colIdx) {
                var colSearch = state.columns[colIdx].search;

                if (colSearch.search) {
                    $('input', certificationTable.column(colIdx).footer()).val(colSearch.search);
                }
            });

            certificationTable.draw();
        }
    }
});

$('#skillTable').on('click', 'tbody td', function() {
      var table = skillTable;
      var tr = $(this).closest('tr');
      var row = table.row(tr);
      //get the initialization options
      var columns = table.settings().init().columns;
      //get the index of the clicked cell
      var colIndex = table.cell(this).index().column;
      //console.log('you clicked on the column with the name '+columns[colIndex].name);
      //console.log('the user id is '+row.data().user_id);
      //console.log('the project id is '+row.data().project_id);
      // If we click on the name, then we create a new project
      //console.log(row.data().id);
      window.location.href = "{!! route('userskillFormCreate',['']) !!}/"+row.data().id;
    });


$('#certificationTable').on('click', 'tbody td', function() {
      var table = certificationTable;
      var tr = $(this).closest('tr');
      var row = table.row(tr);
      //get the initialization options
      var columns = table.settings().init().columns;
      //get the index of the clicked cell
      var colIndex = table.cell(this).index().column;
      //console.log('you clicked on the column with the name '+columns[colIndex].name);
      //console.log('the user id is '+row.data().user_id);
      //console.log('the project id is '+row.data().project_id);
      // If we click on the name, then we create a new project
      //console.log(row.data().id);
      window.location.href = "{!! route('userskillFormCreate',['']) !!}/"+row.data().id;
    });

});
</script>

@stop
