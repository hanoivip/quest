<?php

namespace Hanoivip\Quest\Triggers;

use Hanoivip\Quest\Models\UserQuest;
use Hanoivip\Quest\Services\ITrigger;
use Hanoivip\Quest\Services\QuestService;

class TaskLineFinishAny implements ITrigger
{
    /**
     *
     * @param $condition Line/Task Group
     */
    public function check($userId, $condition)
    {
        $finished = UserQuest::where('user_id', $userId)
        ->where('status', QuestService::QUEST_FINISHED)
        ->where('line_id', $condition)
        ->get();
        return $finished->isNotEmpty();
    }

}