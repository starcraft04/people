@extends('layouts.app')

@section('content')
    <br>
	<div class="col-sm-offset-4 col-sm-4">
		<div class="panel panel-info">
			<div class="panel-heading">Upload OTL xls file</div>
			<div class="panel-body"> 
				@if(session()->has('error'))
					<div class="alert alert-danger">{!! session('error') !!}</div>
				@endif
                @if(session()->has('ok'))
                    <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
                @endif
				{!! Form::open(['url' => 'otlupload/form', 'files' => true]) !!}
					<div class="form-group {!! $errors->has('file') ? 'has-error' : '' !!}">
                        <div class="row">
                            <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!} col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('year', 'Year', ['class' => 'control-label col-xs-2']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::text('year', date('Y'), ['class' => 'form-control', 'placeholder' => 'year']) !!}
                                    {!! $errors->first('year', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-10">
                                <div class="col-md-3">
                                    {!! Form::label('month', 'Month', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::select('month', [
                                                                'Jan'=>'Jan',
                                                                'Feb'=>'Feb',
                                                                'Mar'=>'Mar',
                                                                'Apr'=>'Apr',
                                                                'May'=>'May',
                                                                'Jun'=>'Jun',
                                                                'Jul'=>'Jul',
                                                                'Aug'=>'Aug',
                                                                'Sep'=>'Sep',
                                                                'Oct'=>'Oct',
                                                                'Nov'=>'Nov',
                                                                'Dec'=>'Dec'
                                                            ], '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('month', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
						{!! Form::file('uploadfile', ['class' => 'form-control']) !!}
						{!! $errors->first('uploadfile', '<small class="help-block">:message</small>') !!}
					</div>
					{!! Form::submit('Send !', ['class' => 'btn btn-info pull-right']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop