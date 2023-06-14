<?php
namespace Hanoivip\Quest\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 *
 * @author hanoivip
 */
class Admin extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}