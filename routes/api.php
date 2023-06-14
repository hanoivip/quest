<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->prefix('api')
    ->namespace('Hanoivip\Quest\Controllers')
    ->group(function () {
        Route::any('/quest/task', 'Quest@refreshTask');
        Route::any('/quest/job', 'Quest@refreshJob');
        Route::any('/quest/finish', 'Quest@refreshFinish');
        Route::any('/quest/reward', 'Quest@reward');
    });