<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder18 extends Seeder
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
                'id' => 52,
                'name' => 'customer-upload',
                'display_name' => 'Customers upload',
                'description' => 'Allow to upload data from Customers excel file',
            ],
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
