<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder24 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
            [
                'id' => 66,
                'name' => 'projectLoe-create',
                'display_name' => 'Project Loe create',
                'description' => 'Allow to create Loe for projects',
            ],
            [
                'id' => 67,
                'name' => 'projectLoe-edit',
                'display_name' => 'Project Loe edit',
                'description' => 'Allow to edit Loe for projects',
            ],
            [
                'id' => 68,
                'name' => 'projectLoe-delete',
                'display_name' => 'Project Loe delete',
                'description' => 'Allow to delete Loe for projects',
            ],
            [
                'id' => 69,
                'name' => 'projectLoe-view',
                'display_name' => 'Project Loe view',
                'description' => 'Allow to view Loe for projects',
            ],
            [
                'id' => 70,
                'name' => 'projectLoe-editAll',
                'display_name' => 'Project Loe edit All',
                'description' => 'Allow to edit other users Loe',
            ],
            [
                'id' => 71,
                'name' => 'projectLoe-deleteAll',
                'display_name' => 'Project Loe delete All',
                'description' => 'Allow to delete other users Loe',
            ],
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
