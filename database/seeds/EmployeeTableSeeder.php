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
				'name' => 'Dauphinais,John',
				'manager_id' => 1,
				'is_manager' => 1,
				'region' => 'Europe',
				'domain' => 'Hybrid',
				'subdomain' => 'All',
				'country' => 'Belgium',
				'management_code' => 'DPS22',
				'job_role' => 'DSC',
				'employee_type' => 'onshore'
			));

		// Michel
		Employee::create(array(
				'name' => 'Nolf,Michel',
				'manager_id' => 2,
				'region' => 'Europe',
				'country' => 'Belgium',
				'subdomain' => 'Security',
				'domain' => 'Hybrid',
				'management_code' => 'DPS22',
				'job_role' => 'DSC',
				'employee_type' => 'onshore'
			));

		// Johny
		Employee::create(array(
				'name' => 'Gasser,Johny',
				'manager_id' => 2,
				'region' => 'Europe',
				'country' => 'Switzerland',
				'subdomain' => 'Security',
				'domain' => 'Hybrid',
				'management_code' => 'DPS22',
				'job_role' => 'DSC',
				'employee_type' => 'onshore'
			));

		// Marco
		Employee::create(array(
				'name' => 'Mulder,Marco',
				'manager_id' => 2,
				'region' => 'Europe',
				'country' => 'The Netherlands',
				'subdomain' => 'Security',
				'domain' => 'Hybrid',
				'management_code' => 'DPS22',
				'job_role' => 'DSC'
			));

		// Fred Lo
		Employee::create(array(
				'name' => 'Lo Jacono,Frederic',
				'manager_id' => 2,
				'region' => 'Europe',
				'country' => 'Switzerland',
				'subdomain' => 'Security',
				'domain' => 'Hybrid',
				'management_code' => 'DPS26',
				'job_role' => 'DSC',
				'employee_type' => 'onshore'
			));

		// Fred Bo
		Employee::create(array(
				'name' => 'Bauer,Frederik',
				'manager_id' => 2,
				'region' => 'Europe',
				'country' => 'Germany',
				'subdomain' => 'Security',
				'domain' => 'Hybrid',
				'management_code' => 'DPS22',
				'job_role' => 'DSC',
				'employee_type' => 'onshore'
			));

		// Michael
		Employee::create(array(
				'name' => 'Horne,Michael',
				'manager_id' => 2,
				'region' => 'Europe',
				'country' => 'Switzerland',
				'subdomain' => 'Security',
				'domain' => 'Hybrid',
				'management_code' => 'DPS22',
				'job_role' => 'DSC',
				'employee_type' => 'onshore'
			));

		// Ben
		Employee::create(array(
				'name' => 'Jones,Benedict David',
				'manager_id' => 2,
				'region' => 'Europe',
				'country' => 'United Kingdom',
				'subdomain' => 'Security',
				'domain' => 'Hybrid',
				'management_code' => 'DPS22',
				'job_role' => 'DSC',
				'employee_type' => 'onshore'
			));
	}
}