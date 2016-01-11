<?php

namespace App\Http\Controllers;

use View;

/**
 * 节目控制器
 *
 * @author popfeng <popfeng@yeah.net> 2016-01-11
 */
class ProgramsController extends Controller
{

    /**
     * 首页
     *
     * @return Response
     */
    public function index()
    {
        // render page
        return View::make('programs/index');
    }

    /**
     * 详情
     *
     * @param int $date
     * @return void
     */
    public function detail($date)
    {
        // render page
        return View::make('programs/detail');
    }
}
