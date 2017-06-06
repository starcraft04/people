<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
                <a href="#">
                <i class="fa fa-files-o"></i> <span>XLS Uploads</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                <i class="fa fa-table"></i> <span>Data Management</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @permission('user-view')
                      <li><a href="{!!route('userList')!!}"><i class="fa fa-circle-o"></i> Users List</a></li>
                    @endpermission
                    @permission('role-view')
                      <li><a href="{!!route('roles.index')!!}"><i class="fa fa-circle-o"></i> Roles List</a></li>
                    @endpermission
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
