@extends('layouts.app')

@section('content')
    <br>
	<div class="col-sm-offset-4 col-sm-4">
		<div class="panel panel-info">
			<div class="panel-heading">Upload STEP xls file</div>
			<div class="panel-body"> 
				@if(session()->has('error'))
					<div class="alert alert-danger">{!! session('error') !!}</div>
				@endif
                @if(session()->has('ok'))
                    <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
                @endif
				{!! Form::open(['url' => 'stepupload/form', 'files' => true]) !!}
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
                                    {!! Form::label('half', 'Half', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::select('half', [
                                                                'H1'=>'H1',
                                                                'H2'=>'H2'
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
            @if(session()->has('results'))
                <div class="alert alert-success alert-dismissible">
                    <?php 
                        foreach(session('results') as $result)
                        {
                            echo '<b>'.$result['name'].'</b>: '.$result['status'].'</BR>';
                        }
                    ?>
                </div>
            @endif
		</div>
	</div>
@stop