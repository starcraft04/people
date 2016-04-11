@extends('layouts.app')

@section('content')
    <div class="col-sm-offset-4 col-sm-4">
    	<br>
		<div class="panel panel-primary">	
			<div class="panel-heading">Edit employee</div>
			<div class="panel-body"> 
				<div class="col-sm-12">
					{!! Form::model($employee, ['route' => ['employee.update', $employee->id], 'method' => 'put', 'class' => 'form-horizontal panel']) !!}
					{!! Form::hidden('id', null, ['class' => 'form-control', 'placeholder' => 'id']) !!}
					<div class="form-group {!! $errors->has('employee_name') ? 'has-error' : '' !!}">
					  	{!! Form::text('employee_name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
					  	{!! $errors->first('employee_name', '<small class="help-block">:message</small>') !!}
					</div>
					<div class="form-group {!! $errors->has('manager_id') ? 'has-error' : '' !!}">
					  	{!! Form::text('manager_id', null, ['class' => 'form-control', 'placeholder' => 'Manager ID']) !!}
					  	{!! $errors->first('manager_id', '<small class="help-block">:message</small>') !!}
					</div>
						{!! Form::submit('Update', ['class' => 'btn btn-primary pull-right']) !!}
					{!! Form::close() !!}
				</div>
			</div>
		</div>
		<a href="javascript:history.back()" class="btn btn-primary">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a>
	</div>
@stop