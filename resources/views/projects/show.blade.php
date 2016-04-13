@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Project info</div>
                <div class="panel-body">
				<p>Customer name : {{ $project->customer_name }}</p>
				<p>Project name : {{ $project->project_name }}</p>
                <p>Task name : {{ $project->task_name }}</p>
                </div>
            </div>
            <a href="javascript:history.back()" class="btn btn-primary">
                <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
            </a>
        </div>
    </div>
</div>
@stop