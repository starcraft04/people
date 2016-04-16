@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md">
            <div class="panel panel-default">
                <div class="panel-heading">Activities list</div>

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
                						<th class="col-md-2">Employee</th>
                                        <th class="col-md-2">Customer</th>
                                        <th class="col-md-2">Year</th>
                                        <th class="col-md-2">Month</th>
                                        <th class="col-md-1">Hours</th>
                						<th class="col-md-1"></th>
                						<th class="col-md-1"></th>
                						<th class="col-md-1">{!! link_to_route('activity.create', 'New', [], ['class' => 'btn btn-info pull-right']) !!}</th>
                					</tr>
                				</thead>
                				<tbody>

                    					@foreach ($activity as $oneactivity)
                    						<tr>
                    							<td class="text-primary"><strong>{!! $oneactivity->employee_name !!}</strong></td>
                                                <td class="text-primary">{!! $oneactivity->project_customer_name !!}</td>
                                                <td class="text-primary">{!! $oneactivity->year !!}</td>
                                                <td class="text-primary">{!! $oneactivity->month !!}</td>
                                                <td class="text-primary">{!! $oneactivity->task_hour !!}</td>
                    							<td>{!! link_to_route('activity.show', 'Info', [$oneactivity->id], ['class' => 'btn btn-success btn-block btn-xs']) !!}</td>
                    							<td>{!! link_to_route('activity.edit', 'Modify', [$oneactivity->id], ['class' => 'btn btn-warning btn-block btn-xs']) !!}</td>
                    							<td>
                    								{!! Form::open(['method' => 'DELETE', 'route' => ['activity.destroy', $oneactivity->id]]) !!}
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
