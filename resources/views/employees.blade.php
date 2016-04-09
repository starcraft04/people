@extends('layouts.app')

@section('content')
{!! Form::open(array('route' => 'route.name', 'method' => 'POST')) !!}
	<ul>
		<li>
			{!! Form::label('employee_name', 'Employee_name:') !!}
			{!! Form::text('employee_name') !!}
		</li>
		<li>
			{!! Form::label('manager_id', 'Manager_id:') !!}
			{!! Form::text('manager_id') !!}
		</li>
		<li>
			{!! Form::submit() !!}
		</li>
	</ul>
{!! Form::close() !!}
@endsection