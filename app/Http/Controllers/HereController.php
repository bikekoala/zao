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
    public function map()
    {
        // render page
        return View::make('here.map');
    }

    /**
     * 打卡记录
     *
     * @return void
     */
    public function index()
    {
        // render page
        return View::make('here.index');
    }

    /**
     * 新增打卡
     *
     * @return void
     */
    public function create()
    {
        // render page
        return View::make('here.create');
    }
}
