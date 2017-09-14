<?php

use Illuminate\Database\Seeder;
use App\Permission;

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
        		'name' => 'cluster-view',
        		'display_name' => 'Cluster dashboard view',
        		'description' => 'Allow cluster managers to view the cluster dashboard'
        	]
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
}
