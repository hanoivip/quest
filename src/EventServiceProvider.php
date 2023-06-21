<?php

namespace Hanoivip\Quest;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Hanoivip\Events\User\DetailUpdated' => [
            'Hanoivip\Quest\Services\EventHandler'
        ],
        'Hanoivip\Events\User\EmailLoginVerified' => [
            'Hanoivip\Quest\Services\EventHandler'
        ],
        'Hanoivip\Events\User\PassUpdated' => [
            'Hanoivip\Quest\Services\EventHandler'
        ],
        'Hanoivip\Events\UserSecure\User2faUpdated' => [
            'Hanoivip\Quest\Services\EventHandler'
        ],
        'Hanoivip\Events\Gate\UserTopup' => [
            'Hanoivip\Quest\Services\EventHandler'
        ],
        'Hanoivip\Events\Gate\UserRecharge' => [
            'Hanoivip\Quest\Services\EventHandler'
        ],
        'Hanoivip\Events\Vip\UserVipUpdated' => [
            'Hanoivip\Quest\Services\EventHandler'
        ],
    ];
    
    public function boot()
    {
        parent::boot();
    }
}