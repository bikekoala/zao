<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Notification;
use App\Console\Tool\SyncAppProgram;
use View, Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Instance
     *
     * @return void
     */
    public function __construct()
    {
        $notification = Notification::getLastNotification();
        $appProgramDate = Cache::get(SyncAppProgram::DATE_CACHE_KEY);

        View::share('notification', collect($notification)->toJson());
        View::share('app_program_date', $appProgramDate);
    }
}
