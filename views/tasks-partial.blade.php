@foreach ($tasks as $task)
	@php 
		$static = $static_tasks[$task->line_id][$task->task_id]
	@endphp
	<div id="quest-task-{{$task->line_id}}-{{$task->task_id}}">
		@include('hanoivip::task-partial', ['task' => $task, 'static' => $static, 'can_reward' => isset($reward_tasks[$task->line_id * 1000000 + $task->task_id])])
	</div>
@endforeach
