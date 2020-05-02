<nav class="navbar">
  <!-- Bars to close left menu -->
  <div class="nav toggle">
    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
  </div>
  <ul class="navbar-right">
    <!-- Logged in user and drop down -->
    <li class="nav-item dropdown" style="padding-left: 15px; padding-right: 15px;">
      <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false" id="navbarDropdown">
        <div class="row">
          {{ Auth::user()->name }} <span class="fa fa-angle-down"></span>
        </div>
      </a>
      <ul class="dropdown-menu dropdown-usermenu" aria-labelledby="navbarDropdown">
        <li><a href="{{ route('profile',Auth::user()->id) }}">Profile</a></li>
        <li><a href="{{ route('help') }}">Tutorial</a></li>
        <li><a id="logout"><i class="fa fa-sign-out pull-right"></i>Log Out</a></li>
      </ul>
    </li>

    @permission(['action-view'])
    @if(isset($num_of_actions_logged_in_user))
    <!-- Logged in user and drop down -->
    <li class="nav-item dropdown" style="padding-left: 15px; padding-right: 15px;">
      <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" id="navbarDropdown1">
        <i class="fa fa-file-text-o"></i>
        <span class="badge bg-green">{{ $num_of_actions_logged_in_user }}</span>
      </a>
      <ul class="dropdown-menu msg_list" style="width:500px;" role="menu" aria-labelledby="navbarDropdown1">
        @foreach($top_actions as $key => $value)
        <li class="nav-item">
          <a class="dropdown-item" href="{{ route('toolsFormUpdate',[Auth::user()->id,$value->project_id,date('Y'),'tab_action']) }}">
          <span>
            Action: {{ $value->action_name }}
          </span>
          <span><b>From: {{ $value->user_name }}</b></span></BR>
          <span><b>End date: {{ $value->end_date }}</b></span></BR>
          <span><b>{{ $value->customer_name }}</b></span></BR>
          <span><b>{{ $value->project_name }}</b></span></BR>
          </a>
        </li>
        @endforeach
        <li class="nav-item">
          <div class="text-center">
            <a class="dropdown-item" href="{{ route('actiondashboard',[Auth::user()->name]) }}">
              <strong>See All My Actions</strong>
              <i class="fa fa-angle-right"></i>
            </a>
          </div>
        </li>
      </ul>
    </li>
    @endif
    @endpermission

  </ul>
</nav>


