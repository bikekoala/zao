<?php

namespace App\Http\Controllers;

use View;

/**
 * 打卡控制器
 *
 * @author popfeng <popfeng@yeah.net> 2016-04-19
 */
class HereController extends Controller
{ 

    /**
     * 首页
     *
     * @return Response
     */
    public function index()
    {
        // render page
        return View::make('here');
    }
}
