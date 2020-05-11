<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder7 extends Seeder
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
                'id' => 34,
                'name' => 'cluster-view',
                'display_name' => 'Cluster dashboard view',
                'description' => 'Allow cluster managers to view the cluster dashboard',
            ],
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
