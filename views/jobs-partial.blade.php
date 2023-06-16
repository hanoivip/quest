@foreach ($jobs as $job)
	<div>
		<p>{{ $job->task_id }}</p>
	</div>
@endforeach