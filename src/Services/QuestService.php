<?php

namespace Hanoivip\Quest\Services;

use Hanoivip\Quest\Models\UserQuest;

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
        
    }
    
    /**
     * Get all accepted & on going jobs
     * @param number $userId
     * @return array Array of Job Ids
     */
    private function getDoingJobs($userId)
    {
        
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
            foreach ($data as $lineId => $cfg)
            {
                if (!in_array($lineId, $doings))
                {
                    // check first task
                    if ($this->canAccept($userId, $cfg[1]))
                    {
                        // add to database..
                    }
                }
            }
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
            foreach ($data as $jid => $cfg)
            {
                if (!in_array($jid, $doings))
                {
                    if ($this->canAccept($userId, $cfg))
                    {
                        // add to database..
                    }
                }
            }
        }
        // return all records
        $records = UserQuest::where('user_id', $userId)
        ->where('line_id', 0)
        ->get();
        return $records;
    }
    
    public function getFinished($userId) 
    {
    }
    
    public function getReward($userId, $tid)
    {
        
    }
    
}