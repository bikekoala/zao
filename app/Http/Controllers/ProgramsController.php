<?php

namespace App\Http\Controllers;

use App\Program;

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
        $list = Program::getList();

        return View::make('programs.index')->with('list', $list);
    }

    /**
     * 详情
     *
     * @param int $date
     * @return void
     */
    public function detail(int $date)
    {
        // render page
        return View::make('programs/detail');
    }
}
