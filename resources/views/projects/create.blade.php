@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add project
                </div>
                <div class="panel-body">
                        {!! Form::open(['url' => 'project', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
                        
                        <div class="row">
                            <div class="form-group {!! $errors->has('customer_name') ? 'has-error' : '' !!} col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('customer_name', 'Customer name', ['class' => 'control-label col-xs-2']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::text('customer_name', null, ['class' => 'form-control', 'placeholder' => 'customer name']) !!}
                                    {!! $errors->first('customer_name', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group {!! $errors->has('project_name') ? 'has-error' : '' !!} col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('project_name', 'Project name', ['class' => 'control-label col-xs-2']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::text('project_name', null, ['class' => 'form-control', 'placeholder' => 'project name']) !!}
                                    {!! $errors->first('project_name', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group {!! $errors->has('task_name') ? 'has-error' : '' !!} col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('task_name', 'Task name', ['class' => 'control-label col-xs-2']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::text('task_name', null, ['class' => 'form-control', 'placeholder' => 'task name']) !!}
                                    {!! $errors->first('task_name', '<small class="help-block">:message</small>') !!}
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
