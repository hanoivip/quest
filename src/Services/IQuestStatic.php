<?php

namespace Hanoivip\Quest\Services;

interface IQuestStatic
{
    public function getTasks($line = null, $tid = null);
    
    public function getJobs($jid = null);
    
    public function getTriggers($tid = null);
}