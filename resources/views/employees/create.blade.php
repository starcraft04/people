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
                        {!! Form::open(['url' => 'employee', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}	
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
                                    {!! Form::label('is_manager', 'Is manager?', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::checkbox('is_manager', 'yes', ['class' => 'checkbox']) !!}
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
