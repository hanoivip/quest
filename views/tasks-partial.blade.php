@foreach ($tasks as $task)
	<div>
		<p>{{ $task->line_id }} {{ $task->task_id }}</p>
	</div>
@endforeach