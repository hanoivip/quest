<?php

namespace Hanoivip\Quest\Services;

use Hanoivip\Quest\Models\Task;
use Hanoivip\Quest\Models\UserQuest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Exception;

class QuestService
{
    const QUEST_WORKING = 0;
    const QUEST_FINISHED = 1;
    
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
        ->where('line_id', '>', 0)
        ->pluck('line_id')// nho long
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
        ->where('line_id', 0)
        ->pluck('line_id')// nho long
        ->toArray();
    }
    /**
     * 
     * @param number $userId
     * @param Task $quest
     * @return boolean
     */
    private function canAccept($userId, $quest)
    {
        $data = $this->static->getTriggers();
        $triggers = $quest->triggers;
        //TODO: cast column not works?
        $triggers = json_decode($triggers, true);
        if (!empty($triggers))
        {
            foreach ($triggers as $tid)
            {
                if (isset($data[$tid]))
                {
                    $type = $data[$tid]->type;
                    $condition = $data[$tid]->condition;
                    try {
                        $clazz = app()->make($type);
                        if (!$clazz->check($userId, $condition))
                        {
                            return false;
                        }
                    } 
                    catch (Exception $ex) 
                    {
                        Log::error("Quest check trigger exception: " . $ex->getMessage());
                        return false;
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
        // Log::debug(print_r($data, true));
        if (!empty($data))
        {
            $newQuest = [];
            foreach ($data as $lineId => $cfg)
            {
                if (!in_array($lineId, $doings))
                {
                    // find first task in line?
                    $ftid = min(array_keys($cfg));
                    $first = $cfg[$ftid];
                    //Log::debug(print_r($first, true));
                    if ($this->canAccept($userId, $first))
                    {
                        $newQuest[] = [
                            'user_id' => $userId,
                            'line_id' => $first->line,
                            'task_id' => $first->id,
                            'target' => 0,
                            'status' => self::QUEST_WORKING,
                        ];
                        continue;
                    }
                }
            }
            // add in batch
            UserQuest::insert($newQuest);
        }
        // return all records
        $records = UserQuest::where('user_id', $userId)
        ->where('line_id', '>', 0)
        ->where('status', self::QUEST_WORKING)
        ->orderBy('line_id')
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
        // TODO: reset job?
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
        $cfg = $cfg[$quest->line_id][$quest->task_id];
        $target = $cfg->target;
        //Log::debug(print_r($cfg, true));
        return $quest->target >= $target;
    }
    
    public function getReward($userId, $line, $tid)
    {
        $record = UserQuest::where('user_id', $userId)
        ->where('line_id', $line)
        ->where('task_id', $tid)
        ->first();
        if (empty($record))
        {
            Log::error("Quest task not taken $line $tid");
            return false;
        }
        if ($record->status == self::QUEST_FINISHED)
        {
            Log::error("Quest task is finished $line $tid");
            return false;
        }
        if (!$this->canFinished($userId, $record))
        {
            Log::error("Quest task is not finished $line $tid");
            return false;
        }
        // send reward..
        $task = $this->static->getTasks($line, $tid);
        if (empty($task))
        {
            throw new Exception("Quest task is bogus $line $tid");
        }
        $this->sendReward($userId, $task);
        $record->rewarded_at = Carbon::now();
        $record->status = self::QUEST_FINISHED;
        $record->save();
        // trigger next?
        $next = $this->static->getTasks($line, $tid + 1);
        //Log::debug(print_r($next, true));
        if (!empty($next) && $this->canAccept($userId, $next[$line][$tid+1]))
        {
            //$this->userAcceptTask($userId, $next[$line][$tid+1]);
            // accept
            $new = new UserQuest();
            $new->user_id = $userId;
            $new->line_id = $line;
            $new->task_id = $tid+1;
            $new->target = 0;
            $new->status = self::QUEST_WORKING;
            $new->save();
        }
        return true;
    }
    
    private function sendReward($userId, $task)
    {
        Log::debug("Quest send $userId rewards...");
    }
    
    public function updateTaskProgress($userId, $eventType, $times = 1, $target = null)
    {
        $records = UserQuest::where("user_id", $userId)
        ->where('status', self::QUEST_WORKING)
        ->get();
        $tasks = $this->static->getTasks();
        if ($records->isNotEmpty())
        {
            foreach ($records as $record)
            {
                $add = false;
                $static = $tasks[$record->line_id][$record->task_id];
                //Log::debug(print_r($static, true));
                //Log::debug(print_r($eventType, true));
                if ($eventType == $static->progress_type)
                {
                    if (!empty($static->progress_ids))
                    {
                        if (!empty($target) && $static->progress_ids == $target)
                        {
                            $add = true;
                        }
                    }
                    else
                    {
                        $add = true;
                    }
                }
                if ($add)
                {
                    Log::debug(print_r($record, true));
                    $record->target = $record->target + $times;
                    $record->save();
                }
            }
        }
    }
}