<?php

namespace App\Http\Controllers\Admin;

use View;

/**
 * 协同列表控制器
 *
 * @author popfeng <popfeng@yeah.net> 2016-01-30
 */
class ContributionsController extends Controller
{
    protected $module = 'contributions';

    /**
     * 首页
     *
     * @return Response
     */
    public function index()
    {
        return View::make('admin/contributions/index');
    }

    /**
     * 详情页
     *
     * @param int $duoshuoId
     * @return Response
     */
    public function show($duoshuoId)
    {
    }
}
