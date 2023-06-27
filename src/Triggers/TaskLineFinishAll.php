<?php

namespace Hanoivip\Quest\Triggers;

use Hanoivip\Quest\Models\UserQuest;
use Hanoivip\Quest\Services\ITrigger;
use Hanoivip\Quest\Services\QuestService;
use Hanoivip\Quest\Services\IQuestStatic;
use Illuminate\Support\Facades\Log;

class TaskLineFinishAll implements ITrigger
{
    private $static;
    
    public function __construct(IQuestStatic $static)
    {
        $this->static = $static;
    }
        
    /**
     * 
     * @param $condition Line/Task Group
     */
    public function check($userId, $condition)
    {
        $finished = UserQuest::where('user_id', $userId)
        ->where('status', QuestService::QUEST_FINISHED)
        ->where('line_id', $condition)
        ->orderBy('task_id', 'desc')
        ->first();
        $maxTaskId = 0;
        $tasks = $this->static->getTasks($condition);
        if (!empty($tasks))
        {
            $tasks = $tasks[$condition];
            $maxTaskId = max(array_keys($tasks));
            Log::debug("TaskLineFinishAll max task in line $condition is $maxTaskId");
        }
        return !empty($finished) && $finished->task_id >= $maxTaskId;
    }

}