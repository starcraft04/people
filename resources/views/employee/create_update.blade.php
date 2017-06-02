@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Update employee
                </div>
                <div class="panel-body">
                    <div class="row">
                    @if(session()->has('ok'))
                    <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
                    @endif
                    </div>
                        @if($action == 'create')
                          {!! Form::open(['url' => 'employeeFormCreate', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
                        @elseif($action == 'update')
                          {!! Form::open(['url' => 'employeeFormUpdate/'.$employee->id, 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
                          {!! Form::hidden('id', $employee->id, ['class' => 'form-control', 'placeholder' => 'id']) !!}
                        @endif

                        <div class="row">
                            <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!} col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('name', 'Name', ['class' => 'control-label col-xs-2']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::text('name', (isset($employee)) ? $employee->name : '', ['class' => 'form-control', 'placeholder' => 'name']) !!}
                                    {!! $errors->first('name', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('manager_id', 'Manager', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::select('manager_id', $manager_list, (isset($employee)) ? $employee->manager_id : '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('manager_id', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('employee_type', 'Type', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::select('employee_type', config('select.employee_type'), (isset($employee)) ? $employee->employee_type : '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('employee_type', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('job_role', 'Team', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::select('job_role', config('select.job_role'), (isset($employee)) ? $employee->job_role : '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('job_role', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('region', 'Region', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::select('region', config('select.region'), (isset($employee)) ? $employee->region : '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('region', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('country', 'Country', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::select('country', config('select.country'), (isset($employee)) ? $employee->country : '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('country', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('domain', 'Domain', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::select('domain', config('select.domain'), (isset($employee)) ? $employee->domain : '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('domain', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('subdomain', 'Subdomain', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::select('subdomain', config('select.subdomain'), (isset($employee)) ? $employee->subdomain : '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('subdomain', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('management_code', 'MC', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::text('management_code', (isset($employee)) ? $employee->management_code : '', ['class' => 'form-control', 'placeholder' => 'management code']) !!}
                                    {!! $errors->first('management_code', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('is_manager', 'Is manager?', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::checkbox('is_manager', 'yes', (isset($employee)) ? $employee->is_manager : '', ['class' => 'checkbox']) !!}
                                    {!! $errors->first('manager_id', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-7 col-md-1">
                              @if($action == 'create')
                                {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
                              @elseif($action == 'update')
                                {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                              @endif

                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
            </div>
            <a href="javascript:history.back()" class="btn btn-primary">
                <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
            </a>
        </div>
    </div>
</div>
@stop
