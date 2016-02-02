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
        if (Duoshuo::STATUS['ENABLE'] == $request->state) {
            DB::transaction(function () use ($request, $log) {

                // 参与人
                $participantIds = [];
                foreach (explode('|', $request->participants) as $name) {
                    $participant = Participant::firstOrCreate(['name' => $name]);
                    $participant->increment('counts', 1);
                    $participantIds[] = $participant->id;
                }

                // 节目
                $program = Program::where(
                    'date', date('Y-m-d', strtotime($log->metas->thread_key))
                )->first();

                $program->update(['topic' => $request->topic]);

                $program->participants()->sync($participantIds);

                // 日志
                Duoshuo::where('id', $log->id)->update([
                    'ext_is_agree' => $request->state
                ]);
            });
        }

        // 回复评论
        $state = $this->replyPost(
            $log->metas->author_email,
            $log->metas->thread_id,
            $log->metas->post_id,
            $request->reply_message
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

    /**
     * 回复评论
     *
     * @param string $authorEmail
     * @param string $threadId
     * @param string $postId
     * @param string $message
     * @return bool
     */
    private function replyPost($authorEmail, $threadId, $postId, $message)
    {
        $config = Config::get('duoshuo');
        $ds = new DuoshuoService($config['short_name'], $config['secret']);

        if ($config['user_email'] === $authorEmail) {
            return true;
        } else {
            return $ds->createPost(
                $message,
                $threadId,
                $postId,
                $config['user_name'],
                $config['user_email'],
                $config['user_url']
            );
        }
    }
}
