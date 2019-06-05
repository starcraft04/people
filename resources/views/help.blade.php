@extends('layouts.app')

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Help</h3>
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
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
          <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
            <li role="presentation" class="active"><a href="#tab_content1" id="documents-tab" role="tab" data-toggle="tab" aria-expanded="true">Documents</a>
            </li>
            <li role="presentation" class=""><a href="#tab_content2" id="videos-tab" role="tab" data-toggle="tab" aria-expanded="true">Videos</a>
            </li>
          </ul>
          <div id="myTabContent" class="tab-content">
            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="documents-tab">
              <div class="row">

                For every <b>users</b>, please download and read <a href="{{ asset('/Samples/Dolphin-user-help-20190605.doc') }}" style="text-decoration: underline;">this file</a>.</BR></BR>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="videos-tab">
              <div class="text-center">
                <video width="1006" height="478" controls>
                    <source src="{{ asset('/video/help.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Window content -->
      
    </div>
  </div>
</div>
<!-- Window -->

@endsection
