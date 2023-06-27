<?php

namespace Hanoivip\Quest\Triggers;

use Carbon\Carbon;
use Hanoivip\Quest\Services\ITrigger;
use Hanoivip\User\Facades\UserFacade;

class LastChangePass implements ITrigger
{
    public function check($userId, $condition)
    {
        $lastTime = UserFacade::getLastChangePassword($userId);
        return Carbon::now()->diffInDays($lastTime) >= $condition;
    }

}