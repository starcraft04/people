<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder5 extends Seeder
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
            'id' => 32,
                'name' => 'tools-all_projects-edit',
                'display_name' => 'Tools all projects edit',
                'description' => 'Allow to update all projects',
            ],
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
