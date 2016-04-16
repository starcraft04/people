<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EmployeeTableSeeder::class);
        $this->call(ProjectTableSeeder::class);
        $this->call(ActivityTableSeeder::class);
    }
}
