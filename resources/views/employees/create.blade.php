@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Add employee</div>

                <div class="panel-body">
					{!! Form::open(['url' => 'employee', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}	
					<div class="form-group {!! $errors->has('first_name') ? 'has-error' : '' !!} col-md-8">
					  	{!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'First name']) !!}
					  	{!! $errors->first('first_name', '<small class="help-block">:message</small>') !!}
					</div>
                    <div class="form-group {!! $errors->has('last_name') ? 'has-error' : '' !!} col-md-8">
					  	{!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Last name']) !!}
					  	{!! $errors->first('last_name', '<small class="help-block">:message</small>') !!}
					</div>
					<div class="form-group col-md-8">
                        {!! Form::label('manager_id', 'Manager', ['class' => 'form-control']) !!}
					  	{!! Form::select('manager_id', $manager_list, ['class' => 'form-control']) !!}
					  	{!! $errors->first('manager_id', '<small class="help-block">:message</small>') !!}
					</div>					
                    <div class="form-group col-md-8">
                        {!! Form::label('is_manager', 'Is manager?', ['class' => 'form-control']) !!}
					  	{!! Form::checkbox('is_manager', 'yes', ['class' => 'form-control']) !!}
					  	{!! $errors->first('manager_id', '<small class="help-block">:message</small>') !!}
					</div>
					{!! Form::submit('Create', ['class' => 'btn btn-primary pull-right']) !!}
					{!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop
