<?php

namespace App\Http\Controllers;

use App\Services\Duoshuo as DuoshuoClient;
use App\Duoshuo as DuoshuoModel;
use Request, Config, Mail;

/**
 * 多说评论控制器
 *
 * @author popfeng <popfeng@yeah.net> 2016-01-28
 */
class DuoshuoController extends Controller
{

    /**
     * 回复消息
     *
     * @var string
     */
    private $replyMessage = '嗨，稍等一下哦~';

    /**
     * 邮件标题
     *
     * @var string
     */
    private $emailTitle = '早~ 收到 %s 的协助申请';

    /**
     * 多说客户端对象
     *
     * @var DuoshuoClient
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
        $this->ds = new DuoshuoClient($config['short_name'], $config['secret']);
    }

    /**
     * 网站回调
     *
     * @param Request $request
     * @return Response
     */
    public function callback(Request $request)
    {
        // 验证签名
        if ( ! $this->ds->checkSignature($request::all())) {
            return $this->output('Check signature faild.', true);
        }

        // 拉取最近一条日志
        $lastLogId = DuoshuoModel::getLastLogId();
        $list = $this->ds->getLogList($lastLogId, 10);
        if (empty($list['response'])) {
            return $this->output('Empty response.', true);
        }

        // 遍历日志
        foreach ($list['response'] as $log) {
            // 识别指令
            $signs = DuoshuoModel::recognizeCommands($log['meta']['message']);

            // 记录日志 
            DuoshuoModel::import($log, $signs);

            // 只针对评论操作
            if (DuoshuoModel::ACTION['CREATE'] === $log['action'] and ! empty($signs)) {

                // 回复评论
                $this->replyPost(
                    $log['meta']['thread_id'],
                    $log['meta']['post_id']
                );

                // 发送邮件
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
        $subject = sprintf($this->emailTitle, $data['meta']['author_name']);
        Mail::send('emails.duoshuo', $data, function ($message) use ($email, $subject) {
            $message->from($email);
            $message->to($email);
            $message->subject($subject);
        });
    }

    /**
     * 回复评论
     *
     * @param string $threadId
     * @param string $postId
     * @return bool
     */
    private function replyPost($threadId, $postId)
    {
        $config = Config::get('duoshuo');

        return $this->ds->createPost(
            $this->replyMessage,
            $threadId,
            $postId,
            $config['user_name'],
            $config['user_email'],
            $config['user_url']
        );
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
