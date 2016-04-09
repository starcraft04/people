@extends('layouts.app')

@section('content')
    <br>
    <div class="col-sm-offset-4 col-sm-4">
    	@if(session()->has('ok'))
			<div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
		@endif
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Employees list</h3>
			</div>
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($employees as $employee)
						<tr>
							<td>{!! $employee->id !!}</td>
							<td class="text-primary"><strong>{!! $employee->employee_name !!}</strong></td>
							<td>{!! link_to_route('employee.show', 'Info', [$employee->id], ['class' => 'btn btn-success btn-block']) !!}</td>
							<td>{!! link_to_route('employee.edit', 'Modify', [$employee->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
							<td>
								{!! Form::open(['method' => 'DELETE', 'route' => ['employee.destroy', $employee->id]]) !!}
									{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm(\'Are you sure you want to delete ?\')']) !!}
								{!! Form::close() !!}
							</td>
						</tr>
					@endforeach
	  			</tbody>
			</table>
		</div>
		{!! link_to_route('employee.create', 'Add an employee', [], ['class' => 'btn btn-info pull-right']) !!}
		{!! $links !!}
	</div>
@stop