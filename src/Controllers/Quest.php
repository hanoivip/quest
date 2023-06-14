<?php
namespace Hanoivip\Quest\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

/**
 * Task = main quest
 * Job = daily quest
 * @author hanoivip
 */
class Quest extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $service;
    
    
    public function index()
    {
        $userId = Auth::user()->getAuthIdentifier();
        $tasks = $this->service->getTasks($userId);
        $finished = $this->service->getFinished($userId);
        $jobs = $this->service->getJobs($userId);
        return view('hanoivip::quest', [
            'tasks' => $tasks,
            'jobs' => $jobs,
            'finished' => $finished
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