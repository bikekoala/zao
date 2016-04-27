<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Services\Duoshuo as DuoshuoService;
use App\{User, Comment};
use Request, Redirect, Config, Mail;

/**
 * 多说评论控制器
 *
 * @author popfeng <popfeng@yeah.net> 2016-01-28
 */
class DuoshuoController extends BaseController
{

    /**
     * 多说客户端对象
     *
     * @var DuoshuoService
     */
    private $ds;

    /**
     * 初始化
     *
     * @return void
     */
    public function __construct()
    {
        $config = Config::get('duoshuo');
        $this->ds = new DuoshuoService($config['short_name'], $config['secret']);
    }

    /**
     * 登录回调
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        // 获取 access token
        $accessTokenInfo = $this->ds->getAccessToken('code', [
            'code' => $request::get('code')
        ]);
        if (is_string($accessTokenInfo)) {
            return $this->output($accessTokenInfo, true);
        }

        // 获取用户信息
        $userProfile = $this->ds->getUserProfile($accessTokenInfo['user_id']);
        if (empty($userProfile['response'])) {
            return $this->output('Get user profile faild.', true);
        }

        // 存储 session，并跳转
        $request::session()->put(User::SESSION_KEY, $userProfile['response']);
        return Redirect::to($request::get('callback', Config::get('app.url')));
    }

    /**
     * 登出回调
     *
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request)
    {
        // 删除 session，并跳转
        $request::session()->forget(User::SESSION_KEY);
        return Redirect::to($request::get('callback', Config::get('app.url')));
    }

    /**
     * 评论回调
     *
     * @param Request $request
     * @return Response
     */
    public function comment(Request $request)
    {
        // 验证签名
        if ( ! $this->ds->checkSignature($request::all())) {
            return $this->output('Check signature faild.', true);
        }

        // 拉取最近一条日志
        $lastLogId = Comment::getLastLogId();
        $list = $this->ds->getLogList($lastLogId, 50);
        if (empty($list['response'])) {
            return $this->output('Empty response.', true);
        }

        // 遍历日志
        foreach ($list['response'] as $log) {

            // 识别指令
            $signs = Comment::ACTION['CREATE'] === $log['action'] ?
                Comment::recognizeCommands($log['meta']['message']) : [];

            // 记录日志 
            $id = Comment::import($log, $signs);

            // 通知
            if ( ! empty($signs)) {

                // 回复评论
                /*
                Comment::replyPost(
                    '嗨，稍等一下哦~',
                    $log['meta']['thread_id'],
                    $log['meta']['post_id'],
                    $log['meta']['author_email']
                );
                 */

                // 发送邮件
                $log = $log + ['id' => $id];
                $this->sendMail($log);
            }
        }

        $this->output('Success.', true);
    }

    /**
     * 发送通知邮件
     *
     * @param array $data
     * @return void
     */
    private function sendMail($data)
    {
        $email = Config::get('duoshuo.user_email');
        $subject = sprintf('早~ 收到 %s 的协助申请', $data['meta']['author_name']);

        Mail::send('emails.duoshuo', $data, function ($message) use ($email, $subject) {
            $message->from($email);
            $message->to($email);
            $message->subject($subject);
        });
    }

    /**
     * 输出内容
     *
     * @param string $message
     * @param bool $isError
     * @return void
     */
    private function output($message, $isError = false)
    {
        $result = [
            'message' => $message,
            'error'   => $isError
        ];

        echo json_encode($result, JSON_UNESCAPED_UNICODE);

        if ($isError) {
            exit;
        }
    }
}
