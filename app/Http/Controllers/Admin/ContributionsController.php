<?php

namespace App\Http\Controllers\Admin;

use App\Duoshuo as DuoshuoModel;
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
     * 列表页
     *
     * @return Response
     */
    public function index()
    {
        $list = DuoshuoModel::contributed()
            ->orderBy('id', 'desc')
            ->paginate(100);
        return View::make('admin/contributions/index', ['list' => $list]);
    }
}
