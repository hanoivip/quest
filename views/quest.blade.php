@extends('hanoivip::layouts.app')

@section('title', 'Web Quest')

@push('scripts')
    <script src="/js/quest.js"></script>
@endpush

@section('content')

<p>Tasks</p>
@include('hanoivip::tasks-partial', ['tasks' => $tasks, 'reward_tasks' => $reward_tasks])

<p>Job - Daily tasks</p>
@include('hanoivip::jobs-partial', ['jobs' => $jobs, 'job_rewards' => $job_rewards])


@endsection
