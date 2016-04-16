<?php

use Illuminate\Database\Seeder;
use App\Employee;

class EmployeeTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('employees')->delete();

		// Init
		Employee::create(array(
                'id' => '1',
				'name' => 'MANAGER',
				'manager_id' => 1,
				'is_manager' => 1
			));
		Employee::create(array(
                'id' => '2',
				'name' => 'DAUPHINAIS,John',
				'manager_id' => 1,
				'is_manager' => 1
			));
		Employee::create(array(
                'id' => '3',
				'name' => 'BALY,Mohamed',
				'manager_id' => 1,
				'is_manager' => 1
			));
		Employee::create(array(
                'id' => '4',
				'name' => 'MOHAMED,Hosam',
				'manager_id' => 1,
				'is_manager' => 1
			));
	}
}