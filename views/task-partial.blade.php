<br/>
<p>{{ $static->detail }}</p>
@if ($task->status == 1)
	<p>Da hoan thanh, da nhan thuong</p>
@elseif (!isset($reward_tasks[$task->line_id * 1000000 + $task->task_id]))
	<p>Dang thuc hien</p>
	<a href="{{ $static->guide }}">Thuc hien</a>
@else
	<p>Da xong, co the nhan thuong</p>
	{{-- <form method="post" action="{{route('quest.reward')}}">
		{{ csrf_field() }}
		<input type="hidden" id="line" name="line" value="{{$task->line_id}}"/>
		<input type="hidden" id="task" name="task" value="{{$task->task_id}}"/>
		<button type="submit">Reward</button>
	</form> --}}
	<a onclick="javascript:getTaskReward()" data-line="{{$task->line_id}}" data-task="{{$task->task_id}}"
	data-action="/api/quest/reward" data-template="hanoivip::task-partial" data-update-id="quest-task-{{$task->line_id}}-{{$task->task_id}}">Reward</a>
@endif