<?php
use Illuminate\Support\Facades\Route;

Route::middleware([
    'web',
    'auth:web'
])->namespace('Hanoivip\Quest\Controllers')->group(function () {
    Route::get('/quest', 'Quest@index')->name('quest');
});

Route::middleware([
    'web',
    'admin'
])->namespace('Hanoivip\Quest\Controllers')
->prefix('ecmin')
->group(function () {
    Route::get('/quest', 'Admin@index')->name('ecmin.quest');
});