<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder12 extends Seeder
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
                'id' => 40,
                'name' => 'backup-create',
                'display_name' => 'Backup create',
                'description' => 'Allow to create backups',
            ],
            [
                'id' => 41,
                'name' => 'backup-download',
                'display_name' => 'Backup download',
                'description' => 'Allow to download backups',
            ],
            [
                'id' => 42,
                'name' => 'backup-delete',
                'display_name' => 'Backup delete',
                'description' => 'Allow to delete backups',
            ],
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
