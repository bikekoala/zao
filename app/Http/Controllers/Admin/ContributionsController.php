<?php

namespace App\Http\Controllers\Admin;

use App\Services\Duoshuo as DuoshuoService;
use App\{Duoshuo, Program, Participant};
use Illuminate\Http\Request;
use View, DB, Config, Redirect;

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
        $list = Duoshuo::contributed()
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
        $log = Duoshuo::find($id);
        $signs = Duoshuo::recognizeCommands($log->metas->message);
        $program = Program::dated($log->metas->thread_key)->enabled()->first();
        $participants = Participant::get();

        return View::make('admin/contributions/edit', [
            'log'          => $log,
            'signs'        => $signs,
            'program'      => $program,
            'participants' => $participants
        ]);
    }

    /**
     * 更新请求
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        // 验证
        $this->validate($request, [
            'topic'         => 'string',
            'participants'  => 'string',
            'state'         => 'required|in:1,-1',
            'reply_message' => 'required|string'
        ]);
        $log = Duoshuo::find($id);

        // 更新
        DB::transaction(function () use ($request, $log) {

            if (Duoshuo::STATUS['ENABLE'] == $request->state) {
                // 参与人
                $participantIds = [];
                $participantNames = Participant::filterParticipantNames($request->participants);
                if ( ! empty($participantNames)) {
                    foreach ($participantNames as $name) {
                        $participant = Participant::firstOrCreate(['name' => $name]);
                        $participant->increment('counts', 1);
                        $participantIds[] = $participant->id;
                    }
                }

                // 节目
                $program = Program::where(
                    'date', date('Y-m-d', strtotime($log->metas->thread_key))
                )->first();

                $topic = Program::filterTopic($request->topic);
                if ( ! empty($topic)) {
                    $program->update(['topic' => $topic]);
                }

                if ( ! empty($participantIds)) {
                    $program->participants()->sync($participantIds);
                }
            }

            // 日志
            Duoshuo::where('id', $log->id)->update([
                'ext_is_agree' => $request->state
            ]);
        });

        // 回复评论
        $state = Duoshuo::replyPost(
            $request->reply_message,
            $log->metas->thread_id,
            $log->metas->post_id,
            $log->metas->author_email
        );

        // 跳转
        $status = [
            'status'  => $state ? 'success' : 'error',
            'message' => $state ? '审核成功~' : '审核成功，回复失败'
        ];
        return Redirect::to($request->_redirect_url)->with(
            $status['status'],
            $status['message']
        );
    }
}
