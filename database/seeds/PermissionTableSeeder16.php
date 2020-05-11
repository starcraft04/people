<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder16 extends Seeder
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
                'id' => 49,
                'name' => 'samba-upload',
                'display_name' => 'Samba upload',
                'description' => 'Allow to upload data from Samba',
            ],
            [
                'id' => 50,
                'name' => 'samba-upload-all',
                'display_name' => 'Samba upload all users',
                'description' => 'Allow to upload and modify all users',
            ],
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
