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
        return View::make('about')->with('title', '关于');
    }
}
