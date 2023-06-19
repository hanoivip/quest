<?php

namespace Hanoivip\Quest\Services;

class ConfigStatic implements IQuestStatic
{
    private function array2object($arr)
    {
        return json_decode(json_encode($arr));    
    }
    
    public function getTriggers($tid = null)
    {
        $all = config('quest.trigger', []);
        if (!empty($tid) && isset($all[$tid]))
        {
            return $this->array2object($all[$tid]);
        }
    }

    public function getTasks($line = null, $tid = null)
    {
        $all = config('quest.task', []);
        if (!empty($line))
        {
            $all = $all[$line];
            if (!empty($tid))
            {
                $all = $all[$tid];
            }
        }
        return $all;
    }

    public function getJobs($jid = null)
    {
        $all = config('quest.job', []);
        if (!empty($jid))
        {
            $all = $all[$jid];
        }
        return $all;
    }
    
}