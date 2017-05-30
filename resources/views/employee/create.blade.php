@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add employee
                </div>
                <div class="panel-body">
                    <div class="row">
                    @if(session()->has('ok'))
                    <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div> 
                    @endif
                    </div>
                        {!! Form::open(['url' => 'employeeForm', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}	
                        <div class="row">
                            <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!} col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('name', 'Name', ['class' => 'control-label col-xs-2']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'name']) !!}
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
                                    {!! Form::select('manager_id', $manager_list, '', ['class' => 'form-control']) !!}
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
                                    {!! Form::select('employee_type', $employee_type, '', ['class' => 'form-control']) !!}
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
                                    {!! Form::text('job_role', null, ['class' => 'form-control', 'placeholder' => 'job role']) !!}
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
                                    {!! Form::text('region', null, ['class' => 'form-control', 'placeholder' => 'region']) !!}
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
                                    {!! Form::text('country', null, ['class' => 'form-control', 'placeholder' => 'country']) !!}
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
                                    {!! Form::text('domain', null, ['class' => 'form-control', 'placeholder' => 'domain']) !!}
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
                                    {!! Form::text('subdomain', null, ['class' => 'form-control', 'placeholder' => 'subdomain']) !!}
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
                                    {!! Form::text('management_code', null, ['class' => 'form-control', 'placeholder' => 'management code']) !!}
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
                                    {!! Form::checkbox('is_manager', 'yes', false, ['class' => 'checkbox']) !!}
                                    {!! $errors->first('manager_id', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-7 col-md-1">
                                {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
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
