<?php

namespace Hanoivip\Quest\Services;

interface ITrigger
{
    /**
     * 
     * @param number $userId
     * @param number $condition
     * @return boolean True trigger is pass, quest might be accepted, Failure trigger is blocked, quest still not avaible
     */
    public function check($userId, $condition);
}