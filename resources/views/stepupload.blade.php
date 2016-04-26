@extends('layouts.app')

@section('style')
    <!-- Select2 -->
    <link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <!-- upload widget -->
    <div class="box box-info">
        @if(session()->has('error'))
            <div class="alert alert-danger">{!! session('error') !!}</div>
        @endif
        <div class="box-header">
            <i class="fa fa-cloud-upload"></i>
            <h3 class="box-title">STEP upload</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box-tools -->
        </div>
        <div class="box-body">
            {!! Form::open(['url' => 'stepupload', 'files' => true]) !!}
            
            <div class="form-group {!! $errors->has('year') ? 'has-error' : '' !!}">
                {!! Form::label('year', 'Year', ['class' => 'control-label']) !!}
                {!! Form::text('year', date('Y'), ['class' => 'form-control', 'placeholder' => 'year']) !!}
                {!! $errors->first('year', '<small class="help-block">:message</small>') !!}
            </div>
            <!-- /.form-group -->
            <div class="form-group {!! $errors->has('month') ? 'has-error' : '' !!}">
                <label for="half">Half</label>
                <select class="form-control select2" style="width: 100%;" id="half" name="half">
                    <option selected="selected">H1</option>
                    <option>H2</option>
                </select>
                {!! $errors->first('month', '<small class="help-block">:message</small>') !!}
            </div>
            <!-- /.form-group -->
            <div class="form-group {!! $errors->has('uploadfile') ? 'has-error' : '' !!}">
                {!! Form::label('uploadfile', 'STEP excel file', ['class' => 'control-label']) !!}
                {!! Form::file('uploadfile', ['class' => 'form-control']) !!}
                {!! $errors->first('uploadfile', '<small class="help-block">:message</small>') !!}
            </div>
            <div class="box-footer clearfix">
                <button class="pull-right btn btn-default" id="submit">Send <i class="fa fa-arrow-circle-right"></i></button>
            </div>

            {!! Form::close() !!}
        </div>
        <div class="box-footer">
            @if(session()->has('ok'))
                <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            @endif            
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

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();
        });
    </script> 
@stop