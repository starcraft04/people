<?php

use Illuminate\Database\Seeder;
use App\Activity;

class ActivityTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('employees')->delete();

		// Init
		Activity::create(array(
                'id' => 1,
				'meta_activity' => 'BILLABLE',
                'year' => '2016',
                'month' => 'Jan',
                'task_hour' => 12,
				'employee_id' => 2,
				'project_id' => 1
			));
		Activity::create(array(
                'id' => 2,
				'meta_activity' => 'BILLABLE',
                'year' => '2016',
                'month' => 'Feb',
                'task_hour' => 15,
				'employee_id' => 2,
				'project_id' => 1
			));
	}
}