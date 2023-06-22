<?php
namespace Hanoivip\Quest\Controllers;

use Carbon\Exceptions\Exception;
use Hanoivip\Quest\Models\UserQuest;
use Hanoivip\Quest\Services\QuestService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
                    $rewardTasks[$task->line_id * 1000000 + $task->task_id] = 1;
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
                    $jobRewards[$task->task_id] = 1;
                }
            }
        }
        return view('hanoivip::quest', [
            'tasks' => $tasks, 'reward_tasks' => $rewardTasks, 'static_tasks' => $staticTasks,
            'jobs' => $jobs, 'reward_jobs' => $jobRewards,
        ]);
    }
    
    public function refreshTask(Request $request)
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
                    $rewardTasks[$task->line_id * 1000000 + $task->task_id] = 1;
                }
            }
        }
        $staticTasks = $this->static->getTasks();
        $template = 'hanoivip::tasks';
        if ($request->has('template'))
        {
            $template = $request->input('template');
        }
        return view($template, ['tasks' => $tasks, 'reward_tasks' => $rewardTasks, 'static_tasks' => $staticTasks]);
    }
    
    public function refreshJob()
    {
        
    }
    
    public function refreshFinish()
    {
        
    }
    
    public function reward(Request $request)
    {
        $userId = Auth::user()->getAuthIdentifier();
        $line = $request->input('line');
        $tid = $request->input('task');
        try 
        {
            $result = $this->service->getReward($userId, $line, $tid);
            if ($request->has('template'))
            {
                $template = $request->input('template');
                $record = UserQuest::where('line_id', $line)->where('task_id', $tid)->first();
                $staticTasks = $this->static->getTasks();
                $static = $staticTasks[$line][$tid];
                $canGet = $this->service->canFinished($userId, $record);
                return view($template, ['task' => $record, 'static' => $static, 'can_reward' => $canGet]);
            }
            else
            {
                return view('hanoivip::quest-result', [
                    'message' => $result ? 'success' : null,
                    'error_message' => $result ? 'failure' : null,
                ]);
            }
        } 
        catch (Exception $ex) 
        {
            Log::error("Quest get reward exception: " . $ex->getMessage());
        }
    }
}