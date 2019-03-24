@extends('layouts.app')

@section('style')
<!-- CSS -->
<!-- Select2 -->
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/css/forms.css') }}" rel="stylesheet" />
<!-- bootstrap-daterangepicker -->
<link href="{{ asset('/plugins/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
<link href="{{ asset('/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
<!-- Switchery -->
<link href="{{ asset('/plugins/gentelella/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
@stop

@section('scriptsrc')
<!-- JS -->
<!-- Select2 -->
<script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('/plugins/gentelella/vendors/moment/min/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/sweetalert2/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/gentelella/vendors/switchery/dist/switchery.min.js') }}" type="text/javascript"></script>
<!-- Bootbox -->
<script src="{{ asset('/plugins/bootbox/bootbox.min.js') }}"></script>
<!-- Balloon -->
<script src="{{ asset('/plugins/balloon/jquery.balloon.min.js') }}" type="text/javascript"></script>
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Project </h3>
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
          Create project
          @elseif($action == 'update')
          Update project {{ isset($created_by_user_name) ? '(created by user '.$created_by_user_name.')' : '' }}
          @endif
        </h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        @if($action == 'create')
              {!! Form::open(['url' => 'toolsFormCreate', 'method' => 'post', 'id' => 'myForm']) !!}
              {!! Form::hidden('created_by_user_id', $created_by_user_id, ['class' => 'form-control']) !!}
              @elseif($action == 'update')
              {!! Form::open(['url' => 'toolsFormUpdate', 'method' => 'post', 'id' => 'myForm']) !!}
              {!! Form::hidden('project_id', $project->id, ['class' => 'form-control']) !!}
              <!-- Now we need also to set up id so that it can be used for the ProjectUpdateRequest.php -->
              {!! Form::hidden('id', $project->id, ['class' => 'form-control']) !!}
              {!! Form::hidden('user_id_url', $user_id, ['class' => 'form-control']) !!}
        @endif
        <div class="row">
          <div class="col-md-1">
            <a href="javascript:history.back()" class="btn btn-primary btn-sm">
              <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
            </a>
          </div>
          <div class="col-md-offset-8 col-md-1" style="text-align: right;">
            @if($action == 'update')
            @if(Entrust::can('tools-user_assigned-remove') && $user_id != 0)
            <button type="button" id="remove_user" class="btn btn-danger btn-sm">Remove user</button>
            @endif
            @endif
          </div>
          <div class="col-md-1" style="text-align: right;">
            @if($action == 'update')
            @if(Entrust::can('tools-user_assigned-transfer') && $user_id != 0)
            <button type="button" id="transfer_user" class="btn btn-info btn-sm">Transfer</button>
            @endif
            @endif
          </div>
          <div class="col-md-1" style="text-align: right;">
            @if($action == 'create')
            <input class="btn btn-success btn-sm" type="submit" name="action" value="Create" />
            @elseif($action == 'update')
            <input class="btn btn-success btn-sm" type="submit" name="action" value="Update" />
            @endif
          </div>
        </div>

        <div class="" role="tabpanel" data-example-id="togglable-tabs">
          <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
            <li role="presentation" class="active"><a href="#tab_content1" id="project-tab" role="tab" data-toggle="tab" aria-expanded="true">Project</a>
            </li>
            <li role="presentation" class=""><a href="#tab_content2" id="comments-tab" role="tab" data-toggle="tab" aria-expanded="false">Comments (<span id="num_of_comments">{{ $num_of_comments }}</span>)</a>
            </li>
          </ul>

          <div id="myTabContent" class="tab-content">
            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="project-tab">
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group {!! $errors->has('user_id') ? 'has-error' : '' !!} col-md-12">
                    <div class="col-md-1">
                      {!! Form::label('user_id', 'User', ['class' => 'control-label']) !!}
                      @if($action == 'update')
                      @if($show_change_button)
                      <span class="glyphicon glyphicon-refresh" id="change_user"></span>
                      @endif
                      @endif
                    </div>
                    <div class="col-md-11">
                      <select class="form-control select2" style="width: 100%;" id="user_id" name="user_id" data-placeholder="Select a user to be assigned">
                        <option value="" ></option>
                        @foreach($user_list as $key => $value)
                        <option value="{{ $key }}"
                          @if (old('user_id') == $key) selected
                          @elseif ($key == $user_selected) selected
                          @endif>
                          {{ $value }}
                        </option>
                        @endforeach
                      </select>
                      {!! $errors->first('user_id', '<small class="help-block">:message</small>') !!}
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="user_selected form-group {!! $errors->has('year') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-1">
                          {!! Form::label('year', 'year', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-11">
                          {!! Form::select('year', config('select.year'), (isset($year)) ? $year : '', ['class' => 'form-control']) !!}
                          {!! $errors->first('year', '<small class="help-block">:message</small>') !!}
                      </div>
                  </div>
                </div>
              </div>

              <div class="row_months user_selected">
                <div class="col-md-12">
                  Number of days for each month.
                </div>
              </div>
              <div class="row_months user_selected">
                @if($action == 'create')
                @for($i = 1; $i <= 12; $i++)
                <div class="form-group {!! $errors->has('month['.$i.']') ? 'has-error' : '' !!} col-md-1">
                  {!! Form::label('month['.$i.']', config('select.month_names')[$i], ['class' => 'control-label']) !!}
                  {!! Form::text('month['.$i.']',0, ['class' => 'form-control', 'placeholder' => config('select.month_names')[$i]]) !!}
                  {!! $errors->first('month['.$i.']', '<small class="help-block">:message</small>') !!}
                </div>
                @endfor
                @elseif($action == 'update')
                @for($i = 1; $i <= 12; $i++)
                <div class="form-group {!! $errors->has('month['.$i.']') ? 'has-error' : '' !!} col-md-1">
                  {!! Form::label('month['.$i.']', config('select.month_names')[$i], ['class' => 'control-label']) !!}
                  {!! Form::text('month['.$i.']',isset($activities[$i]) ? $activities[$i] : 0, ['class' => 'form-control', 'placeholder' => config('select.month_names')[$i],!empty($from_otl[$i]) ? 'disabled' : '']) !!}
                  {!! $errors->first('month['.$i.']', '<small class="help-block">:message</small>') !!}
                </div>
                @endfor
                @endif
              </div>

              <div class="clearfix"></div>
              <div class="ln_solid"></div>

              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="form-group {!! $errors->has('project_name') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('project_name', 'Project name *', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('project_name', (isset($project->project_name)) ? $project->project_name : '', 
                        ['class' => 'form-control mandatory', 
                        'placeholder' => 'project name',
                        'title' => "<p>The only mandatory fields to save the project have a * next to them and are:</BR>
                                      <ul>
                                        <li>Project name</li>
                                        <li>Customer name</li>
                                        <li>Each month (leave 0 if you don't know yet or if nothing to be entered for a specific month.</li>
                                      </ul>
                                    </p>
                                    ",
                        $project_name_disabled
                        ]) !!}
                        {!! $errors->first('project_name', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('customer_id') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('customer_id', 'Customer name *', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        <select class="form-control select2" style="width: 100%;" id="customer_id" name="customer_id" data-placeholder="Select a customer name">
                          @foreach($customers_list as $key => $value)
                          <option value="{{ $key }}"
                            @if (old('customer_id') == $key) selected
                            @elseif (isset($project->customer_id) && $key == $project->customer_id) selected
                            @endif>
                            {{ $value }}
                          </option>
                          @endforeach
                        </select>
                        {!! $errors->first('customer_id', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('otl_project_code') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('otl_project_code', 'OTL project code', ['class' => 'control-label']) !!}
                        <a id="help_otl" href="#">(?)</a>
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('otl_project_code', (isset($project->otl_project_code)) ? $project->otl_project_code : '', 
                        ['class' => 'form-control OTL_code', 
                        'placeholder' => 'OTL project code',
                        'title' => "<p>This field is NOT mandatory.</BR>
                                    If you do not know the OTL code yet, then do not enter the OTL code nor the Meta-activity.</BR>
                                    You can come back later to edit it when you will have the right OTL code.</BR>
                                    But if you enter either the OTL code or the Meta-activity, then you will need to fill in the other one too.</BR></p>
                                    <p>Also, keep in mind that the OTL data is fetched every month in this tool for the existing OTL code </BR>
                                    so if you enter the OTL code, you will need to wait the 5th of the month to see the values.</p>
                                    ",
                        $otl_name_disabled]
                        ) !!}
                        {!! $errors->first('otl_project_code', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('meta_activity') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('meta_activity', 'Meta-activity', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        <select class="form-control select2" style="width: 100%;" id="meta_activity" name="meta_activity" data-placeholder="Select a meta-activity">
                          <option value="" ></option>
                          @foreach(config('select.meta_activity') as $key => $value)
                          <option value="{{ $key }}"
                            @if (old('meta_activity') == $key) selected
                            @elseif (isset($project->meta_activity) && $value == $project->meta_activity) selected
                            @endif>
                            {{ $value }}
                          </option>
                          @endforeach
                        </select>
                        {!! $errors->first('meta_activity', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('project_type') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('project_type', 'Project type', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        <select class="form-control select2" style="width: 100%;" id="project_type" name="project_type" data-placeholder="Select a project type">
                          <option value="" ></option>
                          @foreach(config('select.project_type') as $key => $value)
                          <option value="{{ $key }}"
                            @if (old('project_type') == $key) selected
                            @elseif (isset($project->project_type) && $value == $project->project_type) selected
                            @endif>
                            {{ $value }}
                          </option>
                          @endforeach
                        </select>
                        {!! $errors->first('project_type', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('activity_type') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('activity_type', 'Activity type', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        <select class="form-control select2" style="width: 100%;" id="activity_type" name="activity_type" data-placeholder="Select an activity type">
                          <option value="" ></option>
                          @foreach(config('select.activity_type') as $key => $value)
                          <option value="{{ $key }}"
                            @if (old('activity_type') == $key) selected
                            @elseif (isset($project->activity_type) && $value == $project->activity_type) selected
                            @endif>
                            {{ $value }}
                          </option>
                          @endforeach
                        </select>
                        {!! $errors->first('activity_type', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('project_status') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('project_status', 'Project status', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        <select class="form-control select2" style="width: 100%;" id="project_status" name="project_status" data-placeholder="Select a project status">
                          <option value="" ></option>
                          @foreach(config('select.project_status') as $key => $value)
                          <option value="{{ $key }}"
                            @if (old('project_status') == $key) selected
                            @elseif (isset($project->project_status) && $value == $project->project_status) selected
                            @endif>
                            {{ $value }}
                          </option>
                          @endforeach
                        </select>
                        {!! $errors->first('project_status', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('region') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('region', 'Region', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        <select class="form-control select2" style="width: 100%;" id="region" name="region" data-placeholder="Select a region">
                          <option value="" ></option>
                          @foreach(config('select.region') as $key => $value)
                          <option value="{{ $key }}"
                            @if (old('region') == $key) selected
                            @elseif (isset($project->region) && $value == $project->region) selected
                            @endif>
                            {{ $value }}
                          </option>
                          @endforeach
                        </select>
                        {!! $errors->first('region', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('country') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('country', 'Country', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        <select class="form-control select2" style="width: 100%;" id="country" name="country" data-placeholder="Select a country">
                          <option value="" ></option>
                          @foreach(config('countries.country') as $key => $value)
                          <option value="{{ $key }}"
                            @if (old('country') == $key) selected
                            @elseif (isset($project->country) && $value == $project->country) selected
                            @endif>
                            {{ $value }}
                          </option>
                          @endforeach
                        </select>
                        {!! $errors->first('country', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('customer_location') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('customer_location', 'Customer location', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('customer_location', (isset($project)) ? $project->customer_location : '', ['class' => 'form-control', 'placeholder' => 'customer location',$customer_location_disabled]) !!}
                        {!! $errors->first('customer_location', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('technology') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('technology', 'Technology', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('technology', (isset($project)) ? $project->technology : '', ['class' => 'form-control', 'placeholder' => 'technology',$technology_disabled]) !!}
                        {!! $errors->first('technology', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('description', 'description', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('description', (isset($project)) ? $project->description : '', ['class' => 'form-control', 'placeholder' => 'description',$description_disabled]) !!}
                        {!! $errors->first('description', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('comments') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('comments', 'Comments', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('comments', (isset($project)) ? $project->comments : '', ['class' => 'form-control', 'placeholder' => 'Comments',$comments_disabled]) !!}
                        {!! $errors->first('comments', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="form-group {!! $errors->has('estimated_date') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('estimated_date', 'Estimated start to end date', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        <div class="control-group">
                          <div class="controls">
                            <div class="input-prepend input-group">
                              <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                              <input type="text" style="width: 200px" name="estimated_date" id="estimated_date" class="form-control" {{$estimated_date_disabled}} />
                            </div>
                            {!! $errors->first('estimated_date', '<small class="help-block">:message</small>') !!}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('LoE_onshore') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('LoE_onshore', 'LoE onshore (days)', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('LoE_onshore', (isset($project)) ? $project->LoE_onshore : '', ['class' => 'form-control', 'placeholder' => 'LoE onshore (days)',$LoE_onshore_disabled]) !!}
                        {!! $errors->first('LoE_onshore', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('LoE_nearshore') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('LoE_nearshore', 'LoE nearshore (days)', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('LoE_nearshore', (isset($project)) ? $project->LoE_nearshore : '', ['class' => 'form-control', 'placeholder' => 'LoE nearshore (days)',$LoE_nearshore_disabled]) !!}
                        {!! $errors->first('LoE_nearshore', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('LoE_offshore') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('LoE_offshore', 'LoE offshore (days)', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('LoE_offshore', (isset($project)) ? $project->LoE_offshore : '', ['class' => 'form-control', 'placeholder' => 'LoE offshore (days)',$LoE_offshore_disabled]) !!}
                        {!! $errors->first('LoE_offshore', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('LoE_contractor') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('LoE_contractor', 'LoE contractor (days)', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('LoE_contractor', (isset($project)) ? $project->LoE_contractor : '', ['class' => 'form-control', 'placeholder' => 'LoE contractor (days)',$LoE_contractor_disabled]) !!}
                        {!! $errors->first('LoE_contractor', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div id="gold_order_row" class="row">
                    <div class="form-group {!! $errors->has('gold_order_number') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('gold_order_number', 'Gold order', ['class' => 'control-label', 'id' => 'gold_order_text']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('gold_order_number', (isset($project)) ? $project->gold_order_number : '', ['class' => 'form-control', 'placeholder' => 'Gold order',$gold_order_disabled]) !!}
                        {!! $errors->first('gold_order_number', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('product_code') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('product_code', 'Product code', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('product_code', (isset($project)) ? $project->product_code : '', ['class' => 'form-control', 'placeholder' => 'Product code',$product_code_disabled]) !!}
                        {!! $errors->first('product_code', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group {!! $errors->has('revenue') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('revenue', 'Revenue (k€)', ['class' => 'control-label', 'id' => 'revenue_text']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('revenue', (isset($project)) ? $project->revenue : '', ['class' => 'form-control', 'placeholder' => 'Revenue (€)',$revenue_disabled]) !!}
                        {!! $errors->first('revenue', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                  <div id="win_ratio_row" class="row">
                    <div class="form-group {!! $errors->has('win_ratio') ? 'has-error' : '' !!} col-md-12">
                      <div class="col-md-3">
                        {!! Form::label('win_ratio', 'Win ratio (%)', ['class' => 'control-label']) !!}
                      </div>
                      <div class="col-md-9">
                        {!! Form::text('win_ratio', (isset($project)) ? $project->win_ratio : '', ['class' => 'form-control', 'placeholder' => 'Win ratio (%)',$win_ratio_disabled]) !!}
                        {!! $errors->first('win_ratio', '<small class="help-block">:message</small>') !!}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row"></div>
                <div class="row"></div>
              </div>

            </div>
            <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="comments-tab">
              <div class="row">
                <div class="form-group {!! $errors->has('project_comment') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-1">
                    {!! Form::label('project_comment', 'New comment', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-11">
                    <textarea name="project_comment" id="project_comment" class="form-control" placeholder="Have something to say?" rows="3"></textarea>
                    {!! $errors->first('project_comment', '<small class="help-block">:message</small>') !!}
                  </div>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div id="all_comments">
              @if($action == 'update')
              @foreach ($comments as $comment)
                <div class="panel panel-default">
                  <div class="panel-heading">
                    {{$comment->user->name}} said <small class="text-primary">{{$comment->updated_at->diffForHumans()}}</small>
                    @if($comment->user_id == Auth::user()->id || Auth::user()->id == 1)
                    <a id="{{ $comment->id }}" class="pull-right comment_edit"><span class="glyphicon glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                    <a id="{{ $comment->id }}" style="margin-right: 10px;" class="pull-right comment_delete"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                    @endif
                  </div>
                  <div class="panel-body">
                    {{$comment->comment}}
                  </div>
                </div>
              @endforeach
              @endif
              </div>
            </div>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->

@if($action == 'update')
<!-- Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <form id="comment_form" class="form-horizontal" role="form">
          <!-- Modal Header -->
          <div class="modal-header">
              <button type="button" class="close" 
                  data-dismiss="modal">
                      <span aria-hidden="true">&times;</span>
                      <span class="sr-only">Close</span>
              </button>
              <h4 class="modal-title" id="myModalLabel">
                  Edit comment
              </h4>
          </div>
            
          <!-- Modal Body -->
          <div class="modal-body">
              
                <div class="form-group">
                  <label  class="col-sm-2 control-label" for="project_comment_modal">Comment</label>
                  <div class="col-sm-10">
                      <textarea name="project_comment_modal" id="project_comment_modal" class="form-control" placeholder="Have something to say?" rows="3"></textarea>
                  </div>
                  <div id="comment_hidden">
                  </div>
                </div>
              
          </div>
            
          <!-- Modal Footer -->
          <div class="modal-footer">
              <button type="button" class="btn btn-default"
                      data-dismiss="modal">
                          Close
              </button>
              <button type="submit" form="comment_form" value="Submit" class="btn btn-primary">Update</button>
          </div>
        </form> 
        </div>
    </div>
</div>
<!-- Modal -->
@endif
@stop

@section('script')


<script>
var year;

$(document).ready(function() {

  $('.OTL_code,.mandatory').balloon({ 
    position: "right",
    tipSize: 24,
    html: true,
    css: {
      border: 'solid 4px #5baec0',
      padding: '10px',
      fontSize: '100%',
      fontWeight: 'bold',
      lineHeight: '2',
      backgroundColor: '#666',
      color: '#fff'
    } 
  });

  // In case this is baseline, project or pre-sales, we will have different text to be selected

  function project_type_value_check() { 
    switch ($("#project_type option:selected").val()){
      case "Baseline":
        $('#revenue_text').text("MRC (k€)");
        $("#revenue").attr("placeholder", "MRC (k€)");
        $('#gold_order_text').text("Gold Order");
        $("#gold_order_number").attr("placeholder", "Gold Order");
        $("#win_ratio_row").hide();
        break;
      case "Pre-sales":
        $("#win_ratio_row").show();
        $('#gold_order_text').text("Samba ID");
        $("#gold_order_number").attr("placeholder", "Samba ID");
        break;
      default:
        $("#win_ratio_row").hide();
        $('#revenue_text').text("Revenue (k€)");
        $("#revenue").attr("placeholder", "Revenue (k€)");
        $('#gold_order_text').text("Gold Order");
        $("#gold_order_number").attr("placeholder", "Gold Order");
    } 
  }

  // This is when the page loads
  project_type_value_check();

  // This is when the select box changes
  $('#project_type').change(function() {
    project_type_value_check();
  });

  $(document).on('click', '#help_otl', function () {
    swal({
      title: 'How to enter the correct OTL code',
      width: '80%',
      animation: false,
      html:
        'You can fin the <b>OTL code</b> and the <b>Meta-activity</b> by login into OTL and find the below fields</BR></BR></BR>' +
        '<img src="{{ asset("/img/help/OTL_help.jpg") }}">'
    });
  } );

  // Now this is important so that we send the value of all disabled fields
  // What it does is when you try to submit, it will remove the disabled property on all fields with disabled
  jQuery(function ($) {
    $('form').bind('submit', function () {
      $(this).find(':input').prop('disabled', false);
    });
  });

  @if($action == 'update')
  @if($show_change_button)
  $(document).on('click', '#change_user', function () {
    $('#user_id').prop('disabled', false);
  });
  @endif
  @endif

  if($('#user_id').val()===""){
    console.log('empty');
    $('.user_selected').hide();
  }
  else {
    console.log('not empty');
    $('.user_selected').show();
  }

  $('#user_id').change(function() {
    if($(this).val()===""){
      console.log('empty');
      $('.user_selected').hide();
    }
    else {
      console.log('not empty');
      $('.user_selected').show();
    }
  });



  // init DateRange picker
  $('#estimated_date').daterangepicker({
    locale: {
    format: 'YYYY-MM-DD'
    },
    showISOWeekNumbers: true,
    showDropdowns: true,
    autoApply: true,
    disabled: true,
    @if(!empty(old('estimated_date')))
    startDate: '{{ explode(" - ",old("estimated_date"))[0] }}',
    endDate: '{{ explode(" - ",old("estimated_date"))[1] }}'
    @elseif(isset($project->estimated_start_date))
    startDate: '{{ $project->estimated_start_date }}',
    endDate: '{{ $project->estimated_end_date }}'
    @endif
  });

  //Init select2 boxes
  $("#user_id").select2({
    allowClear: true,
    disabled: {{ $user_select_disabled }}
  });

  $("#year").select2({
    allowClear: false
  });

  $("#customer_id").select2({
    allowClear: true,
    disabled: {{ $customer_id_select_disabled }}
  });

  $("#meta_activity").select2({
    allowClear: true,
    disabled: {{ $meta_activity_select_disabled }}
  });

  $("#project_type").select2({
    allowClear: true,
    disabled: {{ $project_type_select_disabled }}
  });

  $("#activity_type").select2({
    allowClear: true,
    disabled: {{ $activity_type_select_disabled }}
  });

  $("#project_status").select2({
    allowClear: true,
    disabled: {{ $project_status_select_disabled }}
  });

  $("#region").select2({
    allowClear: true,
    disabled: {{ $region_select_disabled }}
  });

  $("#country").select2({
    allowClear: true,
    disabled: {{ $country_select_disabled }}
  });

  @if($action == 'update')
    $('#year').on('change', function() {
        year=$(this).val();
        window.location.href = "{!! route('toolsFormUpdate',[$user_id,$project->id,'']) !!}"+"/"+year;
    });
  @endif

  $('#remove_user').on('click', function () {
      bootbox.confirm("Are you sure want to remove the user from this project?", function(result) {
          if (result){
            $('<input />').attr('type', 'hidden')
              .attr('name', 'action')
              .attr('value', 'Remove')
              .appendTo('#myForm');
            $('#myForm').submit();
          }
      });
  });


  @if($action == 'update')
  $('#transfer_user').on('click', function () {
      bootbox.confirm("Are you sure want to transfer the user from this project?", function(result) {
          if (result){
            window.location.href = "{!! route('toolsFormTransfer',[$user_id,$project->id]) !!}";
          }
      });
  });
  @endif

  @if($action == 'update')

  $(document).on('click', '.comment_edit', function () {
    comment_id = this.id;
    $.ajax({
      type: 'get',
      url: "{!! route('comment_show','') !!}/"+comment_id,
      dataType: 'json',
      success: function(data) {
        console.log(data);
        $('textarea#project_comment_modal').val(data.comment);
      }
    }); 
    $('#comment_hidden').empty();
    var hidden = '';
    hidden += '<input class="form-control" id="comment_id" name="comment_id" type="hidden" value="'+comment_id+'">';
    $('#comment_hidden').append(hidden);
    $('#commentModal').modal();
  });

  $("#comment_form").submit(function(e){
    e.preventDefault();
    var comment_id = $('input#comment_id').val();
    var comment_comment = $('textarea#project_comment_modal').val();
    $.ajax({
      type: 'post',
      url: "{!! route('comment_edit','') !!}/"+comment_id,
      dataType: 'json',
      data: {
        'comment': comment_comment,
        '_token':'{{ csrf_token() }}'
      },
      success: function(data) {
        console.log(data);

        $.ajax({
          type: 'get',
          url: "{!! route('comment_list','') !!}/"+{{ $project->id }},
          dataType: 'json',
          success: function(data) {
            console.log(data);
            $('#num_of_comments').text(data.num_of_comments);
            $('#all_comments').empty();

            var comments = '';
            $.each(data.list, function( index, value ) {
              comments += '<div class="panel panel-default">';
              comments += '<div class="panel-heading">';
              comments += value.user_name +' said <small class="text-primary">'+value.time+'</small>';
              if (value.id > 0) {
                comments += '<a id="'+value.id+'" class="pull-right comment_edit"><span class="glyphicon glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
                comments += '<a id="'+value.id+'" style="margin-right: 10px;" class="pull-right comment_delete"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
              }
              comments += '</div>';
              comments += '<div class="panel-body">';
              comments += value.comment;
              comments += '</div>';
              comments += '</div>';
            });
            
            $('#all_comments').append(comments); 

          }
        }); 

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
        console.log(data.msg);
        $('#flash-message').append(box);
        $('#delete-message').delay(2000).queue(function () {
            $(this).addClass('animated flipOutX')
        }); 
      } 
    });

    $('#commentModal').modal('hide');
  });

  $(document).on('click', '.comment_delete', function () {
    var comment_id = this.id;
    bootbox.confirm("Are you sure want to delete this message?", function(result) {
      if (result){
        $.ajax({
          type: 'get',
          url: "{!! route('comment_delete','') !!}/"+comment_id,
          dataType: 'json',
          success: function(data) {
            console.log(data);

            $.ajax({
              type: 'get',
              url: "{!! route('comment_list','') !!}/"+{{ $project->id }},
              dataType: 'json',
              success: function(data) {
                console.log(data);
                $('#num_of_comments').text(data.num_of_comments);
                $('#all_comments').empty();

                var comments = '';
                $.each(data.list, function( index, value ) {
                  comments += '<div class="panel panel-default">';
                  comments += '<div class="panel-heading">';
                  comments += value.user_name +' said <small class="text-primary">'+value.time+'</small>';
                  if (value.id > 0) {
                    comments += '<a id="'+value.id+'" class="pull-right comment_edit"><span class="glyphicon glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
                    comments += '<a id="'+value.id+'" style="margin-right: 10px;" class="pull-right comment_delete"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
                  }
                  comments += '</div>';
                  comments += '<div class="panel-body">';
                  comments += value.comment;
                  comments += '</div>';
                  comments += '</div>';
                });
                
                $('#all_comments').append(comments); 

              }
            }); 

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
            console.log(data.msg);
            $('#flash-message').append(box);
            $('#delete-message').delay(2000).queue(function () {
                $(this).addClass('animated flipOutX')
            });
          }
        });
      }
    });
  } );

  @endif

});
</script>


@stop
