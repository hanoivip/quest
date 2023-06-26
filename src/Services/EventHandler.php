<?php

namespace Hanoivip\Quest\Services;

use Illuminate\Support\Facades\Log;

class EventHandler
{
    private $service;
    
    public function __construct(QuestService $service)
    {
        $this->service = $service;
    }
    /**
     * All event class name == Progress Type
     * All event must have $uid public attribute;
     */
    public function handle($event)
    {
        $eventClass = class_basename($event);
        Log::debug("Event handler event $eventClass hit");
        if (!property_exists($event, 'uid'))
        {
            Log::error("Event handler event $eventClass has no uid.. Dropped!");
            return;
        }
        $userId = $event->uid;
        $target = null;
        switch ($eventClass)
        {
            case 'User2faUpdated': $target = $event->method;
                break;
            case 'UserTopup': $target = $event->type . $event->coin;
                break;
        }
        $this->service->updateTaskProgress($userId, $eventClass, 1, $target);
    }
}