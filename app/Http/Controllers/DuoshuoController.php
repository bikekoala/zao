<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Services\Duoshuo as DuoshuoService;
use App\Comment as CommentModel;
use Request, Config, Mail;

/**
 * 多说评论控制器
 *
 * @author popfeng <popfeng@yeah.net> 2016-01-28
 */
class DuoshuoController extends BaseController
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
     * 评论网站回调
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
        $lastLogId = CommentModel::getLastLogId();
        $list = $this->ds->getLogList($lastLogId, 50);
        if (empty($list['response'])) {
            return $this->output('Empty response.', true);
        }

        // 遍历日志
        foreach ($list['response'] as $log) {

            // 识别指令
            $signs = CommentModel::ACTION['CREATE'] === $log['action'] ?
                CommentModel::recognizeCommands($log['meta']['message']) : [];

            // 记录日志 
            $id = CommentModel::import($log, $signs);

            // 通知
            if ( ! empty($signs)) {

                // 回复评论
                /*
                CommentModel::replyPost(
                    $this->replyMessage,
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
        $subject = sprintf($this->emailTitle, $data['meta']['author_name']);

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
