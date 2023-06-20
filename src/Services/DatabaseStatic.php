<?php

namespace Hanoivip\Quest\Services;

use Illuminate\Support\Facades\DB;

class DatabaseStatic implements IQuestStatic
{
    public function getTriggers($tid = null)
    {
        $query = DB::table('triggers');
        if (!empty($tid))
        {
            $query = $query->where('id', $tid);
        }
        $records = $query->get();
        $out = [];
        if ($records->isNotEmpty())
        {
            foreach ($records as $r)
            {
                $out[$r->id] = $r;
            }
        }
        return $out;
    }
    
    public function getTasks($line = null, $tid = null)
    {
        $query = DB::table('tasks');
        if (!empty($line))
        {
            $query = $query->where('line', $line);
        }
        if (!empty($tid))
        {
            $query = $query->where('id', $tid);
        }
        $records = $query->get();
        // convert to arr
        $out = [];
        if ($records->isNotEmpty())
        {
            foreach ($records as $r)
            {
                if (!isset($out[$r->line]))
                {
                    $out[$r->line] = [];
                }
                $out[$r->line][$r->id] = $r;
            }
        }
        return $out;
    }
    
    public function getJobs($jid = null)
    {}
    
}