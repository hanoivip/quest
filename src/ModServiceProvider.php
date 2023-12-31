<?php

namespace Hanoivip\Quest;

use Illuminate\Support\ServiceProvider;
use Hanoivip\Quest\Services\ConfigStatic;
use Hanoivip\Quest\Services\IQuestStatic;
use Hanoivip\Quest\Services\DatabaseStatic;
use Hanoivip\Quest\Triggers\LastChangePass;
use Hanoivip\Quest\Triggers\TaskLineFinishAll;
use Hanoivip\Quest\Triggers\TaskLineFinishAny;
use Hanoivip\Quest\Triggers\VipLevel;

class ModServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/hanoivip'),
            __DIR__.'/../resources/langs' => resource_path('lang/vendor/hanoivip'),
            __DIR__.'/../resources/images' => public_path('images'),
        ]);
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        $this->loadViewsFrom(__DIR__ . '/../views', 'hanoivip');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadTranslationsFrom( __DIR__.'/../resources/langs', 'hanoivip.quest');
        $this->mergeConfigFrom( __DIR__.'/../config/quest.php', 'quest');
    }

    public function register()
    {
        $static = config('quest.static', 'database');
        
        if ($static == 'file')
        {
            $this->app->bind(IQuestStatic::class, ConfigStatic::class);
        }
        else
        {
            $this->app->bind(IQuestStatic::class, DatabaseStatic::class);
        }
        // bind triggers
        $this->app->bind('LastChangePass', LastChangePass::class);
        $this->app->bind('VipLevel', VipLevel::class);
        $this->app->bind('TaskLineFinishAny', TaskLineFinishAny::class);
        $this->app->bind('TaskLineFinishAll', TaskLineFinishAll::class);
    }
}
