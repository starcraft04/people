@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Employees list</div>

                <div class="panel-body">
                    <br>
                    <div class="col-md">
                      @if(session()->has('ok'))
                      <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
                      @endif
                		<div class="panel panel-default">

                			<table class="table">
                				<thead>
                					<tr>
                						<th>Employee name</th>
                                        <th>Manager name</th>
                                        <th>Is manager</th>
                						<th class="col-md-1"></th>
                						<th class="col-md-1"></th>
                						<th class="col-md-1">{!! link_to_route('employee.create', 'New', [], ['class' => 'btn btn-info pull-right']) !!}</th>
                					</tr>
                				</thead>
                				<tbody>

                    					@foreach ($employees as $employee)
                                            <?php if ($employee->id == 1){continue;}; ?>
                    						<tr>
                    							<td class="text-primary"><strong>{!! $employee->first_name." ".$employee->last_name !!}</strong></td>
                                                <td class="text-primary">{!! $employee->manager_first_name." ".$employee->manager_last_name !!}</td>
                                                <td class="text-primary">{!! $employee->is_manager !!}</td>
                    							<td>{!! link_to_route('employee.show', 'Info', [$employee->id], ['class' => 'btn btn-success btn-block btn-xs']) !!}</td>
                    							<td>{!! link_to_route('employee.edit', 'Modify', [$employee->id], ['class' => 'btn btn-warning btn-block btn-xs']) !!}</td>
                    							<td>
                    								{!! Form::open(['method' => 'DELETE', 'route' => ['employee.destroy', $employee->id]]) !!}
                    									{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block btn-xs', 'onclick' => 'return confirm(\'Are you sure you want to delete ?\')']) !!}
                    								{!! Form::close() !!}
                    							</td>
                    						</tr>
                    					@endforeach
                    	  			</tbody>
                    			</table>
                    		</div>
                    		{!! $links !!}
                    	</div>

                </div>
            </div>
        </div>
    </div>
</div>
@stop
