@extends('hanoivip::layouts.app')

@section('title', 'Web Quest')

@push('scripts')
    <script src="/js/quest.js"></script>
@endpush

@section('content')

<p>Tasks</p>
<div id="quest-tasks-list">
	@include('hanoivip::tasks-partial', ['tasks' => $tasks, 'reward_tasks' => $reward_tasks, 'static_tasks' => $static_tasks])
</div>
<a id="quest-tasks-refresh" data-action="/api/quest/task" data-template="hanoivip::tasks-partial" data-update-id="quest-tasks-list">Refresh</a>

<p>Job - Daily tasks</p>
@include('hanoivip::jobs-partial', ['jobs' => $jobs, 'reward_jobs' => $reward_jobs])

<a href="">Refresh</a>

@endsection
