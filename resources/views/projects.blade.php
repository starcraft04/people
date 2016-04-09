{!! Form::open(array('route' => 'route.name', 'method' => 'POST')) !!}
	<ul>
		<li>
			{!! Form::label('customer_name', 'Customer_name:') !!}
			{!! Form::text('customer_name') !!}
		</li>
		<li>
			{!! Form::label('project_name', 'Project_name:') !!}
			{!! Form::text('project_name') !!}
		</li>
		<li>
			{!! Form::label('task_name', 'Task_name:') !!}
			{!! Form::text('task_name') !!}
		</li>
		<li>
			{!! Form::label('meta_activity', 'Meta_activity:') !!}
			{!! Form::text('meta_activity') !!}
		</li>
		<li>
			{!! Form::label('year', 'Year:') !!}
			{!! Form::text('year') !!}
		</li>
		<li>
			{!! Form::label('month', 'Month:') !!}
			{!! Form::text('month') !!}
		</li>
		<li>
			{!! Form::label('task_hours', 'Task_hours:') !!}
			{!! Form::text('task_hours') !!}
		</li>
		<li>
			{!! Form::label('employee_id', 'Employee_id:') !!}
			{!! Form::text('employee_id') !!}
		</li>
		<li>
			{!! Form::submit() !!}
		</li>
	</ul>
{!! Form::close() !!}