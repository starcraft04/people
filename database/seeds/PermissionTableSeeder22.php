<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder22 extends Seeder
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
        		'id' => 60,
        		'name' => 'comment-create',
        		'display_name' => 'Create comments',
        		'description' => 'Allow to create a comment'
            ],
            [
        		'id' => 61,
        		'name' => 'comment-edit',
        		'display_name' => 'Edit comments',
        		'description' => 'Allow to edit a comment'
            ],
            [
        		'id' => 62,
        		'name' => 'comment-delete',
        		'display_name' => 'Delete comments',
        		'description' => 'Allow to delete a comment'
            ],
            [
        		'id' => 63,
        		'name' => 'comment-all',
        		'display_name' => 'Work on all comments',
        		'description' => 'Allow to work on all comments'
            ],
            [
              'id' => 64,
              'name' => 'action-view',
              'display_name' => 'View actions',
              'description' => 'Allow to view the actions'
              ],
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
}
