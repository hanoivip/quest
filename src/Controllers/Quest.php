<?php
namespace Hanoivip\Quest\Controllers;

use Hanoivip\Quest\Services\QuestService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Hanoivip\Quest\Services\IQuestStatic;

/**
 * Task = main quest
 * Job = daily quest
 * @author hanoivip
 */
class Quest extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $service;
    
    private $static;
    
    public function __construct(QuestService $service, IQuestStatic $static)
    {
        $this->service = $service;
        $this->static = $static;
    }
    
    public function index()
    {
        $userId = Auth::user()->getAuthIdentifier();
        $tasks = $this->service->getTasks($userId);
        $rewardTasks = [];
        if (!empty($tasks))
        {
            foreach ($tasks as $task)
            {
                if ($this->service->canFinished($userId, $task))
                {
                    $rewardTasks[] = $task->line_id * 1000000 + $task->task_id;
                }
            }
        }
        $staticTasks = $this->static->getTasks();
        $jobs = $this->service->getJobs($userId);
        $jobRewards = [];
        if (!empty($jobs))
        {
            foreach ($jobs as $job)
            {
                if ($this->service->canFinished($userId, $job))
                {
                    $jobRewards[] = $task->task_id;
                }
            }
        }
        return view('hanoivip::quest', [
            'tasks' => $tasks, 'reward_tasks' => $rewardTasks, 'static_tasks' => $staticTasks,
            'jobs' => $jobs, 'reward_jobs' => $jobRewards,
        ]);
    }
    
    public function refreshTask()
    {
        
    }
    
    public function refreshJob()
    {
        
    }
    
    public function refreshFinish()
    {
        
    }
    
    public function reward()
    {
        
    }
}