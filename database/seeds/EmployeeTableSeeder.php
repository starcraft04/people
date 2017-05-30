<?php

use Illuminate\Database\Seeder;
use App\Employee;

class EmployeeTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('employee')->delete();

		// Manager
		Employee::create(array(
				'name' => 'MANAGER',
				'manager_id' => 1,
				'is_manager' => 1
			));

		// John
		Employee::create(array(
				'name' => 'DAUPHINAIS,John',
				'manager_id' => 1,
				'is_manager' => 1,
				'region' => 'Europe',
				'domain' => 'Hybrid',
				'subdomain' => 'All'
			));
	}
}