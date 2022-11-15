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
  @if(env('APP_DEBUG') == 'true') <link href="{{ asset('/css/debug.css') }}" rel="stylesheet"> @endif
  <link href="{{ asset('/css/animate.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/alert.css') }}" rel="stylesheet">
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


<body id="main_body" class="@if(isset($_COOKIE['left_menu_minimized']) && $_COOKIE['left_menu_minimized'] == 1) nav-sm @else nav-md @endif footer_fixed">
  <div class="container body">
    <div class="main_container">

      <!-- sidebar -->
      <div class="col-md-3 left_col menu_fixed">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="{!!route('home')!!}" class="site_title"><img src="{{ asset("/img/dolphin-logo.png") }}">
              <span>Dolphin @if(env('APP_DEBUG') == 'true') TEST @endif</span>
            </a>
          </div>
          <span style="color: white; float:right;margin-right: 10%;">V1.0.0</span>
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

          <!-- Here we print the success or error message if it exists  -->
          <div id="flash-message">
            @if ($message = Session::get('success'))
            <div id="flash-success" class="alert alert-success alert-dismissible flash-success" role="alert">
              <button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
              {{ $message }}
            </div>
            @endif
            @if ($message = Session::get('error'))
            <div id="flash-error" class="alert alert-danger alert-dismissible flash-error" role="alert">
              <button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
              {{ $message }}
            </div>
            @endif
          </div>
          <!-- END print success or error  -->

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
  <script src="{{ asset('/plugins/gentelella/build/js/customV1.3.min.js') }}" type="text/javascript"></script>
  <!-- JS cookie -->
  <script src="{{ asset('/plugins/jscookie/js.cookie.js') }}" type="text/javascript"></script>
  <!-- Some functions made by John -->
  <script src="{{ asset('/js/people_general_functions.js') }}" type="text/javascript"></script>
  @yield('scriptsrc')
  <!-- END All script sources -->
  <!-- All scripts -->
  @yield('script')
  <script>
    $(document).ready(function() {

      @if($message = Session::get('success'))
      $('#flash-success').delay(2000).queue(function() {
        $(this).addClass('animated flipOutX')
      });
      @endif
      @if($message = Session::get('error'))
      $('#flash-error').delay(2000).queue(function() {
        $(this).addClass('animated flipOutX')
      });
      @endif

      $('#logout').on('click', function() {
        Cookies.remove('year');
        Cookies.remove('manager');
        Cookies.remove('user');
        window.location.href = "{{ route('logout') }}";
      });

      // This is to remember if the left menu is minimized or not
      $('#menu_toggle').on('click', function() {
        body_class = $('#main_body').attr('class');
        if (body_class.search('nav-md') == -1) {
          Cookies.set('left_menu_minimized', '1');
        } else {
          Cookies.set('left_menu_minimized', '0');
        }
      });

    });
  </script>
  <!-- END All scripts -->

</body>

</html>