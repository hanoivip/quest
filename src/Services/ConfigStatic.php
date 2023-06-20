<?php

namespace Hanoivip\Quest\Services;

class ConfigStatic implements IQuestStatic
{
    private function array2object1($arr)
    {
        return json_decode(json_encode($arr));    
    }
    
    private function array2object2($arr)
    {
        $obj = new \stdClass();
        if (!empty($arr))
        {
            foreach ($arr as $key => $value)
            {
                $obj->{$key} = $value;
            }
        }
        return $obj;
    }
    
    private function array2object($arr)
    {
        return (object)$arr;
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
        $out = [];
        foreach ($all as $line => $data)
        {
            $out[$line] = [];
            foreach ($data as $tid => $detail)
            {
                
            }
        }
        if (!empty($line))
        {
            $all = $all[$line];
            if (!empty($tid))
            {
                $all = $all[$tid];
            }
        }
        return $this->array2object($all);
    }

    public function getJobs($jid = null)
    {
        $all = config('quest.job', []);
        if (!empty($jid))
        {
            $all = $all[$jid];
        }
        return $this->array2object($all);
    }
    
}