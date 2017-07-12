<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>People</title>

  <!-- All styles -->
  <!-- Bootstrap core CSS -->
  <link href="{{ asset('/plugins/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- NProgress -->
  <link href="{{ asset('/plugins/gentelella/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ asset('/plugins/gentelella/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="{{ asset('/plugins/gentelella/build/css/custom.min.css') }}" rel="stylesheet">
  @yield('style')
  <!-- END All styles -->


  <!--[if lt IE 9]>
  <script src="../assets/js/ie8-responsive-file-warning.js"></script>
  <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>


<body class="nav-md footer_fixed">
    <div class="container body">
      <div class="main_container">

        <!-- sidebar -->
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{!!route('home')!!}" class="site_title"><i class="fa fa-paw"></i> <span>People</span></a>
            </div>

            <div class="clearfix"></div>

            <br /><br />

            <!-- sidebar menu -->
            @if(Auth::user())
              @include('includes.sidebar')
            @endif
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            @if(Auth::user())
              @include('includes.menu_footer')
            @endif
            <!-- /menu footer buttons -->
          </div>
        </div>
        <!-- sidebar -->

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            @if(Auth::user())
            @include('includes.top_navigation')
            @endif
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            @yield('content')
          </div>
        </div>
        <!-- /page content -->


        <div class="clearfix"></div>
        </br></br>
        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Orange copyright!
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->

      </div>
    </div>
    
    <!-- All script sources -->
    <!-- jQuery -->
    <script src="{{ asset('/plugins/gentelella/vendors/jquery/dist/jquery.min.js') }}" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('/plugins/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="{{ asset('/plugins/gentelella/vendors/fastclick/lib/fastclick.js') }}" type="text/javascript"></script>
    <!-- NProgress -->
    <script src="{{ asset('/plugins/gentelella/vendors/nprogress/nprogress.js') }}" type="text/javascript"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('/plugins/gentelella/build/js/custom.min.js') }}" type="text/javascript"></script>
    <!-- JS cookie -->
    <script src="{{ asset('/plugins/jscookie/js.cookie.js') }}" type="text/javascript"></script>
    @yield('scriptsrc')
    <!-- END All script sources -->
    <!-- All scripts -->
    @yield('script')
    <script>
    $('#logout').on('click', function () {
        Cookies.remove('year');
        Cookies.remove('manager');
        Cookies.remove('user');
        window.location.href = "{{ route('auth.logout') }}";
    });
    </script>
    <!-- END All scripts -->

</body>
</html>
