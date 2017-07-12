@extends('tools.list')

@section('content')
<!-- Window -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window title -->
      <div class="x_title">
        <h2>Tools</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <br />
          <div class="row">
            <div class="form-group col-xs-2">
              <label for="month" class="control-label">Year</label>
              <select class="form-control select2" style="width: 100%;" id="year" name="year" data-placeholder="Select a year">
                @foreach($authUsersForDataView->year_list as $key => $value)
                <option value="{{ $key }}"
                  @if(isset($authUsersForDataView->year_selected) && $key == $authUsersForDataView->year_selected) selected
                  @endif>
                  {{ $value }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-xs-2">
              <label for="manager" class="control-label">Manager</label>
              <select class="form-control select2" style="width: 100%;" id="manager" name="manager" data-placeholder="Select a manager" multiple="multiple">
                @foreach($authUsersForDataView->manager_list as $key => $value)
                <option value="{{ $key }}"
                  @if(isset($authUsersForDataView->manager_selected) && $key == $authUsersForDataView->manager_selected) selected
                  @endif>
                  {{ $value }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-xs-2">
              <label for="user" class="control-label">User</label>
              <select class="form-control select2" style="width: 100%;" id="user" name="user" data-placeholder="Select a user" multiple="multiple">
                @foreach($authUsersForDataView->user_list as $key => $value)
                <option value="{{ $key }}"
                  @if(isset($authUsersForDataView->user_selected) && $key == $authUsersForDataView->user_selected) selected
                  @endif>
                  {{ $value }}
                </option>
                @endforeach
              </select>
            </div>
          </div>
      </div>
      <!-- Window content -->

      <!-- Window script -->
      <script>
        $(document).ready(function() {
          //Init select2 boxes
          $("#year").select2({
            allowClear: false,
            disabled: {{ $authUsersForDataView->year_select_disabled }}
          });
          //Init select2 boxes
          $("#manager").select2({
            allowClear: false,
            disabled: {{ $authUsersForDataView->manager_select_disabled }}
          });
          //Init select2 boxes
          $("#user").select2({
            allowClear: false,
            disabled: {{ $authUsersForDataView->user_select_disabled }}
          });
        });
      </script>
      <!-- Window script -->

    </div>
  </div>
</div>
<!-- Window -->
@stop
