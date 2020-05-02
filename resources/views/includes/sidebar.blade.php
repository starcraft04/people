<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">

    @permission(['otl-upload'])
    <ul class="nav side-menu">
      <li><a><i class="fa fa-home"></i>DB Feed <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          @permission(['otl-upload'])
            <li><a href="{!!route('otluploadform')!!}">Prime upload</a></li>
          @endpermission
          @permission(['samba-upload'])
            <li><a href="{!!route('sambauploadform')!!}">CL upload</a></li>
          @endpermission
          @permission(['revenue-upload'])
            <li><a href="{!!route('revenueuploadform')!!}">Revenue upload</a></li>
          @endpermission
          @permission(['customer-upload'])
            <li><a href="{!!route('customeruploadform')!!}">Customer upload</a></li>
          @endpermission
        </ul>
      </li>
    </ul>
    @endpermission

    @permission(['user-view','user-edit','user-create','user-delete',
    'role-view','role-edit','role-create','role-delete',
    'project-view','project-edit','project-create','project-delete',
    'activity-view','activity-edit','activity-create','activity-delete',
    'skills-addnew','backup-create','backup-download','backup-delete'
    ])
    <ul class="nav side-menu">
      <li><a><i class="fa fa-edit"></i>DB Management <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          @permission(['user-view','user-edit','user-create','user-delete'])
          <li><a href="{!!route('userList')!!}">Users list</a></li>
          @endpermission
          @permission(['role-view','role-edit','role-create','role-delete'])
          <li><a href="{!!route('roles.index')!!}">Roles list</a></li>
          @endpermission
          @permission(['project-view','project-edit','project-create','project-delete'])
          <li><a href="{!!route('projectList')!!}">Projects list</a></li>
          @endpermission
          @permission(['activity-view','activity-edit','activity-create','activity-delete'])
          <li><a href="{!!route('activityList')!!}">Activity list</a></li>
          @endpermission
          @permission(['project-view','project-edit','project-create','project-delete'])
          <li><a href="{!!route('customerList')!!}">Customers list</a></li>
          @endpermission
          @permission(['skills-addnew'])
          <li><a href="{!!route('skillList')!!}">Skills list</a></li>
          @endpermission
          @permission(['backup-create','backup-download','backup-delete'])
          <li><a href="{!!route('backupList')!!}">Backups list</a></li>
          @endpermission
        </ul>
      </li>
    </ul>
    @endpermission

      @permission(['dashboard-view','cluster-view'])
      <ul class="nav side-menu">
        <li><a><i class="fa fa-bar-chart-o"></i>Dashboard<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            @permission(['dashboard-view'])
            <li><a href="{!!route('dashboardLoad')!!}">Users load</a></li>
            <li><a href="{!!route('dashboardLoadChart')!!}">Users load Chart</a></li>
            <li><a href="{!!route('dashboarddscisc')!!}/{{date('Y')}}">ASC vs ISC</a></li>
            @endpermission
            @permission(['cluster-view'])
            <li><a href="{!!route('clusterdashboard')!!}/{{date('Y')}}/0/all">Cluster Dashboard</a></li>
            @endpermission
            @permission(['dashboardRevenue-view'])
            <li><a href="{!!route('revenuedashboard')!!}/{{date('Y')}}/0">Revenue Dashboard</a></li>
            @endpermission
            @permission(['dashboardOrder-view'])
            <li><a href="{!!route('orderdashboard')!!}/{{date('Y')}}/0">Order Dashboard</a></li>
            @endpermission
            @permission(['projectLoe-dashboard_view'])
            <li><a href="{!!route('loedashboard')!!}/{{date('Y')}}">LoE Dashboard</a></li>
            @endpermission
            @permission(['action-view'])
            <li><a href="{!!route('actiondashboard')!!}">Action Dashboard</a></li>
            @endpermission
          </ul>
        </li>
      </ul>
      @endpermission

      @permission(['tools-activity-view','tools-all_projects-view','tools-usersskills','projects-lost','tools-user-summary'])
      <ul class="nav side-menu">
        <li><a><i class="fa fa-wrench"></i>Tools<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            @permission(['tools-activity-view'])
            <li><a href="{!!route('toolsActivities')!!}">Activity list per project</a></li>
            @endpermission
            @permission(['tools-user-summary'])
            <li><a href="{!!route('toolsUserSummary')!!}">User Summary</a></li>
            @endpermission
            @permission(['tools-all_projects-view'])
            <li><a href="{!!route('projectsAll')!!}">Project list</a></li>
            @endpermission
            @permission(['projects-lost'])
            <li><a href="{!!route('projectsLost')!!}">Projects lost</a></li>
            @endpermission
            @permission(['tools-usersskills'])
            <li><a href="{!!route('toolsUsersSkills')!!}">Users skills</a></li>
            @endpermission
          </ul>
        </li>
      </ul>
      @endpermission

      @permission(['tools-unassigned-view','tools-missing_info-view'])
      <ul class="nav side-menu">
        <li><a><i class="fa fa-server"></i>Maintenance<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            @permission(['tools-unassigned-view'])
            <li><a href="{!!route('projectsAssignedAndNot')!!}">Unassigned projects</a></li>
            @endpermission
            @permission(['tools-missing_info-view'])
            <li><a href="{!!route('projectsMissingInfo')!!}">Project missing info</a></li>
            @endpermission
            @permission(['tools-missing_info-view'])
            <li><a href="{!!route('projectsMissingOTL')!!}">Project missing OTL</a></li>
            @endpermission
          </ul>
        </li>
      </ul>
      @endpermission

  </div>
</div>
