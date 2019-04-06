<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder17 extends Seeder
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
        		'id' => 51,
        		'name' => 'revenue-upload',
        		'display_name' => 'Revenue upload',
        		'description' => 'Allow to upload data from Revenue OT'
            ]
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
}
