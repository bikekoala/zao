<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Console\Tool\UpdateBingCover;
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
        $this->showCoverInfo();
        $this->showNotification();
    }

    /**
     * 展示封图信息
     *
     * @return void
     */
    protected function showCoverInfo()
    {
        $coverInfo = Cache::get(UpdateBingCover::COVER_CACHE_KEY);
        View::share('cover', $coverInfo);
    }

    /**
     * 展示通知
     *
     * @return void
     */
    protected function showNotification()
    {
        $notification = Notification::getLastNotification();
        View::share('notification', collect($notification)->toJson());
    }
}
