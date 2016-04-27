<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Console\Tool\SyncAppProgram;
use App\{User, Notification};
use View, Cache, Session;

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
        View::share('notification', collect($notification)->toJson());

        View::share('user', Session::get(User::SESSION_KEY));
    }

    /**
     * 获取App节目日期
     *
     * @return string
     */
    protected function getAppProgramDate()
    {
        return Cache::get(SyncAppProgram::DATE_CACHE_KEY, '20040802');
    }
}
