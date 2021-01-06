<?php
  
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

  
class RoleTableSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['id' => 1, 'name' => 'Admin','guard_name' => 'web']);
        $role = Role::find(1);
        $role->givePermissionTo('role-view');
        $role->givePermissionTo('role-create');
        $role->givePermissionTo('role-edit');
        $role->givePermissionTo('role-delete');
        $role->givePermissionTo('role-assign');
        $role->givePermissionTo('user-view');
        $role->givePermissionTo('user-create');
        $role->givePermissionTo('user-edit');
        $role->givePermissionTo('user-delete');
        $role->givePermissionTo('user-view-all');
    }
}