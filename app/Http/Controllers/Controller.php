<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Console\Tool\SyncAppProgram;
use App\{User, Notification};
use View, Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * 用户数据
     *
     * @var array
     */
    public $user;

    /**
     * Instance
     *
     * @return void
     */
    public function __construct()
    {
        $notification = Notification::getLastNotification();
        View::share('notification', collect($notification)->toJson());
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
