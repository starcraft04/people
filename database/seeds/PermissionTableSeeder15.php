<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder15 extends Seeder
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
                'id' => 48,
                'name' => 'otl-upload-all',
                'display_name' => 'OTL upload all users',
                'description' => 'Allow to upload and modify all users',
            ],
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
