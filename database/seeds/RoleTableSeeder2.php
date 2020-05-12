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
        Role::create(['id' => 2, 'name' => 'Super Manager']);
        Role::create(['id' => 3, 'name' => 'Manager']);
        Role::create(['id' => 4, 'name' => 'User']);
        Role::create(['id' => 5, 'name' => 'User Extended']);
        Role::create(['id' => 6, 'name' => 'Super Viewer']);
        Role::create(['id' => 7, 'name' => 'Super Manager Extended']);
        Role::create(['id' => 8, 'name' => 'ASC managers']);
        Role::create(['id' => 9, 'name' => 'Only Skills']);
        Role::create(['id' => 10, 'name' => 'ASC Consultant']);
        Role::create(['id' => 11, 'name' => 'Viewer For Projects And Activities']);
        Role::create(['id' => 12, 'name' => 'Viewer For All Skills']);
        Role::create(['id' => 13, 'name' => 'Consulting Cluster Head']);
   
    }
}