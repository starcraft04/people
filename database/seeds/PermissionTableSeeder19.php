<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder19 extends Seeder
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
                'id' => 53,
                'name' => 'projects-lost',
                'display_name' => 'View projects lost',
                'description' => 'Allow to view the projects lost in the tools section',
            ],
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
