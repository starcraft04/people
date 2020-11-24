<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder26 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $permissions = [
        'role-view',
        'role-create',
        'role-edit',
        'role-delete',
        'role-assign',
        'user-view',
        'user-create',
        'user-edit',
        'user-delete',
        'user-view-all',
        'activity-view',
        'activity-create',
        'activity-edit',
        'activity-delete',
        'project-view',
        'project-create',
        'project-edit',
        'project-delete',
        'otl-upload',
        'tools-activity-view',
        'tools-activity-new',
        'tools-activity-edit',
        'tools-activity-all-view',
        'tools-activity-all-edit',
        'dashboard-view',
        'dashboard-all-view',
        'tools-unassigned-view',
        'tools-missing_info-view',
        'tools-all_projects-view',
        'tools-user_assigned-change',
        'tools-user_assigned-remove',
        'tools-all_projects-edit',
        'tools-user_assigned-transfer',
        'cluster-view',
        'tools-usersskills',
        'tools-usersskills-editall',
        'skills-addnew',
        'home-extrainfo',
        'tools-usersskills-view-all',
        'backup-create',
        'backup-download',
        'backup-delete',
        'projectRevenue-create',
        'projectRevenue-edit',
        'projectRevenue-delete',
        'dashboardRevenue-view',
        'dashboardOrder-view',
        'otl-upload-all',
        'samba-upload',
        'samba-upload-all',
        'revenue-upload',
        'customer-upload',
        'View projects lost',
        'tools-projects-comments',
        'tools-user-summary',
        'action-create',
        'action-edit',
        'action-delete',
        'action-all',
        'comment-create',
        'comment-edit',
        'comment-delete',
        'comment-all',
        'action-view',
        'tools-update-existing_prime_code',
        'projectLoe-create',
        'projectLoe-edit',
        'projectLoe-delete',
        'projectLoe-view',
        'projectLoe-editAll',
        'projectLoe-deleteAll',
        'projectLoe-dashboard_view',
        'projectLoe-signoff',
        ];


        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}