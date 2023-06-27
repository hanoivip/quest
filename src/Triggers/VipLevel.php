<?php

namespace Hanoivip\Quest\Triggers;

use Hanoivip\Quest\Services\ITrigger;
use Hanoivip\Vip\Facades\VipFacade;

class VipLevel implements ITrigger
{
    public function check($userId, $condition)
    {
        $record = VipFacade::getInfo($userId);
        if (!empty($record))
        {
            return $record->level >= $condition;
        }
        return false;
    }

}