<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder2 extends Seeder
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
            'id' => 27,
                'name' => 'tools-unassigned-view',
                'display_name' => 'Tools assigned and not',
                'description' => 'View the tools assigned and not page',
            ],
          [
            'id' => 28,
                'name' => 'tools-missing_info-view',
                'display_name' => 'Tools missing info view',
                'description' => 'View the tools missing info page',
            ],
          [
            'id' => 29,
                'name' => 'tools-all_projects-view',
                'display_name' => 'Tools all projects view',
                'description' => 'View the tools all projects page',
            ],
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
