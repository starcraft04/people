@extends('layouts.app')

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Update Password for user {{ $user->name }}</h3>
  </div>
</div>
<div class="clearfix"></div>
<!-- Page title -->

<!-- Window -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window content -->
      <div class="x_content">
        <form id="update_password" role="form" method="POST" action="{{ route('updatePasswordStore',Auth::user()->id) }}">
          @CSRF
          <div class="form-group {!! $errors->has('password') ? 'has-error' : '' !!}">
              <label  class="control-label" for="password">Password</label>
              <input type="password" name="password" class="form-control" placeholder="password"></input>
              @error('password') <span class="help-block">{{ $message }}</span> @enderror
          </div>
          <div class="form-group {!! $errors->has('confirm-password') ? 'has-error' : '' !!}">
              <label  class="control-label" for="confirm-password">Confirm</label>
              <input type="password" name="confirm-password" class="form-control" placeholder="confirm"></input>
              @error('confirm-password') <span class="help-block">{{ $message }}</span> @enderror
          </div>
          <input class="btn btn-success btn-sm" type="submit" value="Update">
        </form>
      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->
@stop