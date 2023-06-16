<?php

namespace Hanoivip\Quest\Services;

use Hanoivip\Quest\Models\UserQuest;
use Exception;

class QuestService
{
    private $static;
    
    public function __construct(IQuestStatic $static)
    {
        $this->static = $static;
    }
    
    /**
     * Get all accepted & on going tasks
     * @param number $userId
     * @return array Array of doing Line Ids
     */
    private function getDoingTasks($userId)
    {
        return UserQuest::where('user_id', $userId)
        ->where('line', '>', 0)
        ->pluck('line')// nho long
        ->toArray();
    }
    
    /**
     * Get all accepted & on going jobs
     * @param number $userId
     * @return array Array of Job Ids
     */
    private function getDoingJobs($userId)
    {
        return UserQuest::where('user_id', $userId)
        ->where('line', 0)
        ->pluck('line')// nho long
        ->toArray();
    }
    private function canAccept($userId, $quest)
    {
        $data = $this->static->getTriggers();
        $triggers = $quest->triggers;
        if (!empty($triggers))
        {
            foreach ($triggers as $tid)
            {
                if (isset($data[$tid]))
                {
                    $type = $data[$tid]->type;
                    $condition = $data[$tid]->condition;
                    switch ($type)
                    {
                        case "VIPLevel":
                        case "Recharge":
                        case "Login":
                            break;
                    }
                }
            }
        }
        return true;
    }
    /**
     * Get all acceptable tasks
     * @param number $userId
     */
    public function getTasks($userId) 
    {
        $doings = $this->getDoingTasks($userId);
        // scan for acceptable tasks
        $data = $this->static->getTasks();
        if (!empty($data))
        {
            $newQuest = [];
            foreach ($data as $lineId => $cfg)
            {
                if (!in_array($lineId, $doings))
                {
                    // find first task in line?
                    $first = $cfg[1];
                    if ($this->canAccept($userId, $first))
                    {
                        $newQuest[] = [
                            'user_id' => $userId,
                            'line_id' => $first->line,
                            'task_id' => $first->id,
                        ];
                    }
                }
            }
            // add in batch
            UserQuest::insert($newQuest);
        }
        // return all records
        $records = UserQuest::where('user_id', $userId)
        ->where('line_id', '>', 0)
        ->get();
        return $records;
    }
    /**
     * Get all acceptable jobs
     * @param number $userId
     */
    public function getJobs($userId) 
    {
        $doings = $this->getDoingJobs($userId);
        // scan for acceptable jobs
        $data = $this->static->getJobs();
        if (!empty($data))
        {
            $newQuest = [];
            foreach ($data as $jid => $cfg)
            {
                if (!in_array($jid, $doings))
                {
                    if ($this->canAccept($userId, $cfg))
                    {
                        $newQuest[] = [
                            'user_id' => $userId,
                            'line_id' => 0,
                            'task_id' => $cfg->id,
                        ];
                    }
                }
            }
            // add in batch
            UserQuest::insert($newQuest);
        }
        // return all records
        $records = UserQuest::where('user_id', $userId)
        ->where('line_id', 0)
        ->get();
        return $records;
    }
    /**
     * 
     * @param number $userId
     * @param UserQuest $quest
     */
    public function canFinished($userId, $quest) 
    {
        $cfg = null;
        if ($quest->line_id == 0)
        {
            $cfg = $this->static->getJobs($quest->task_id);
        }
        else 
        {
            $cfg = $this->static->getTasks($quest->line_id, $quest->task_id);
        }
        if (empty($cfg))
        {
            throw new Exception("Quest quest is bogus");
        }
        $target = 0;
        return $quest->target >= $target;
    }
    
    public function getReward($userId, $line, $qid)
    {
        
    }
    
}