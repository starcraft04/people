@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md">
            <div class="panel panel-default">
                <div class="panel-heading">Projects list</div>

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
                						<th class="col-md-3">Customer name</th>
                                        <th class="col-md-3">Project name</th>
                                        <th class="col-md-3">Task name</th>
                						<th class="col-md-1"></th>
                						<th class="col-md-1"></th>
                						<th class="col-md-1">{!! link_to_route('project.create', 'New', [], ['class' => 'btn btn-info pull-right']) !!}</th>
                					</tr>
                				</thead>
                				<tbody>

                    					@foreach ($projects as $project)
                    						<tr>
                    							<td class="text-primary"><strong>{!! $project->customer_name !!}</strong></td>
                                                <td class="text-primary">{!! $project->project_name !!}</td>
                                                <td class="text-primary">{!! $project->task_name !!}</td>
                    							<td>{!! link_to_route('project.show', 'Info', [$project->id], ['class' => 'btn btn-success btn-block btn-xs']) !!}</td>
                    							<td>{!! link_to_route('project.edit', 'Modify', [$project->id], ['class' => 'btn btn-warning btn-block btn-xs']) !!}</td>
                    							<td>
                    								{!! Form::open(['method' => 'DELETE', 'route' => ['project.destroy', $project->id]]) !!}
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
