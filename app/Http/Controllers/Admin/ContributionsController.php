<?php

namespace App\Http\Controllers\Admin;

use App\Duoshuo as DuoshuoModel;
use App\{Program, Participant};
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

    /**
     * 审核页面
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $log = DuoshuoModel::find($id);
        $signs = DuoshuoModel::recognizeCommands($log->metas->message);
        $program = Program::dated($log->metas->thread_key)->enabled()->first();
        $participants = Participant::get();

        return View::make('admin/contributions/edit', [
            'log'          => $log,
            'signs'        => $signs,
            'program'      => $program,
            'participants' => $participants
        ]);
    }
}
