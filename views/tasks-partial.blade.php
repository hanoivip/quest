<script>
function getTaskReward()
{
	event.preventDefault(event);
	var ele = event.target
	console.log(ele)
	var url = $(ele).attr('data-action')
	var updateId = $(ele).attr('data-update-id')
	var line = $(ele).attr('data-line')
	var task = $(ele).attr('data-task')
	var template = $(ele).attr('data-template')
	var param = new FormData();  
	param.append("line", line)
	param.append("task", task)
	param.append("template", template)
	$.ajax({
        url: url,
        method: 'POST',
        contentType: 'application/x-www-form-urlencoded',
        data: new URLSearchParams(param).toString(),
        dataType : 'html',
        cache: false,
        processData: false,
        success:function(response)
        {
        	console.log(response)
        	$('#' + updateId).html(response)
        },
        error: function(response) {
        }
    })
}
</script>
@foreach ($tasks as $task)
	@php 
		$static = $static_tasks[$task->line_id][$task->task_id]
	@endphp
	<div id="quest-task-{{$task->line_id}}-{{$task->task_id}}">
		@include('hanoivip::task-partial', ['task' => $task, 'static' => $static, 'can_reward' => isset($reward_tasks[$task->line_id * 1000000 + $task->task_id])])
	</div>
@endforeach
