<?php

namespace Hanoivip\Quest\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $incrementing = false;
    // The casting is done when you convert the model to an array or json format.
    protected $casts = [
        'triggers' => 'array',
        'rewards' => 'array',
        'progress_ids' => 'array'
    ];
    
}
