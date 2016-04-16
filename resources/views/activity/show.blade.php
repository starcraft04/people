@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Activity info</div>
                <div class="panel-body">
                <p>Employee : {{ $employee->name }}</p>
				<p>Customer name : {{ $project->customer_name }}</p>
                <p>Project name : {{ $project->project_name }}</p>
                <p>Task name : {{ $project->task_name }}</p>
                <p>Date : {{ $activity->month.' '.$activity->year }}</p>
                <p>Meta activity : {{ $activity->meta_activity }}</p>
                <p>Hours : {{ $activity->task_hour }}</p>
                </div>
            </div>
            <a href="javascript:history.back()" class="btn btn-primary">
                <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
            </a>
        </div>
    </div>
</div>
@stop