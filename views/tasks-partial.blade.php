@foreach ($tasks as $task)
	<div>
		@php 
			$static = $static_tasks[$task->line_id][$task->task_id]
		@endphp
		<p>{{ $static->detail }}</p>
		@if (!isset($reward_tasks[$task->line_id * 1000000 + $task->task_id]))
			<p>Chua xong</p>
			<a href="{{ $static->guide }}">Thuc hien</a>
		@else
			<p>Da xong</p>
			<form></form>
		@endif
	</div>
@endforeach