@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Update project
                </div>
                    <div class="panel-body">
                        {!! Form::model($project, ['route' => ['project.update', $project->id], 'method' => 'put', 'class' => 'form-horizontal panel']) !!}	
                        {!! Form::hidden('id', null, ['class' => 'form-control', 'placeholder' => 'id']) !!}
                        <div class="row">
                            <div class="form-group {!! $errors->has('customer_name') ? 'has-error' : '' !!} col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('customer_name', 'Customer name', ['class' => 'control-label col-md-3']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::text('customer_name', $project->customer_name, ['class' => 'form-control', 'placeholder' => 'Customer name']) !!}
                                    {!! $errors->first('customer_name', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group {!! $errors->has('project_name') ? 'has-error' : '' !!} col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('project_name', 'Project name', ['class' => 'control-label col-md-3']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::text('project_name', $project->project_name, ['class' => 'form-control', 'placeholder' => 'Project name']) !!}
                                    {!! $errors->first('project_name', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group {!! $errors->has('task_name') ? 'has-error' : '' !!} col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('task_name', 'Task name', ['class' => 'control-label col-md-3']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::text('task_name', $project->task_name, ['class' => 'form-control', 'placeholder' => 'Task name']) !!}
                                    {!! $errors->first('task_name', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-7 col-md-1">
                            {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
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
