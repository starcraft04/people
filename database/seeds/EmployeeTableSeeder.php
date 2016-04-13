<?php

use Illuminate\Database\Seeder;
use App\Employee;

class EmployeeTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('employees')->delete();

		// Init
		Employee::create(array(
				'name' => 'MANAGER',
				'manager_id' => 1,
				'is_manager' => 1
			));
		Employee::create(array(
				'name' => 'DAUPHINAIS,John',
				'manager_id' => 1,
				'is_manager' => 1
			));
		Employee::create(array(
				'name' => 'BALY,Mohamed',
				'manager_id' => 1,
				'is_manager' => 1
			));
		Employee::create(array(
				'name' => 'MOHAMED,Hosam',
				'manager_id' => 1,
				'is_manager' => 1
			));
	}
}