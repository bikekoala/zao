<?php

namespace App\Http\Controllers;

use View;

/**
 * 关于控制器
 *
 * @author popfeng <popfeng@yeah.net> 2016-03-24
 */
class AboutController extends Controller
{

    /**
     * 首页
     *
     * @return Response
     */
    public function index()
    {
        return View::make('about.index')->with('title', '关于');
    }

    /**
     * 打赏记录
     *
     * @return Response
     */
    public function donateList()
    {
        return View::make('about.donate')->with('title', '打赏记录');
    }
}
