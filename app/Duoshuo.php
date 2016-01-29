<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 多说评论模型
 *
 * @author popfeng <popfeng@yeah.net> 2016-01-28
 */
class Duoshuo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'duoshuo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'log_id',
        'user_id',
        'action',
        'meta',
        'date',
        'ext_created_at',
        'ext_program_date',
        'ext_topic',
        'ext_participant'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 操作类型
     *
     * $var array
     */
    const ACTION = [
        'CREATE'         => 'create',        // 创建评论
        'APPROVE'        => 'approve',       // 通过评论
        'SPAM'           => 'spam',          // 标记垃圾评论
        'DELETE'         => 'delete',        // 删除评论
        'DELETE_FOREVER' => 'delete-forever' // 彻底删除评论
    ];

    /**
     * 指令标识
     *
     * @var array
     */
    const COMMAND_SIGNS = [
        'TOPIC'       => '🐶',
        'PARTICIPANT' => '🐰'
    ];



    /**
     * 获取最后一条记录的log_id
     *
     * @return string
     */
    public static function getLastLogId()
    {
        $res = static::orderBy('id', 'desc')->first();
        return $res ? $res->log_id : '0';
    }

    /**
     * 导入日志
     *
     * @param array $data
     * @param array $signs
     * @return void
     */
    public static function import($datas, $signs)
    {
        $record = static::where('log_id', $datas['log_id'])->first();
        if (empty($record)) {
            $data = [
                'log_id'         => $datas['log_id'],
                'user_id'        => $datas['user_id'],
                'action'         => $datas['action'],
                'meta'           => json_encode($datas['meta'], JSON_UNESCAPED_UNICODE),
                'date'           => date('Y-m-d H:i:s', $datas['date']),
                'ext_created_at' => date('Y-m-d H:i:s')
            ];
            if (isset($datas['meta']['thread_key'])) {
                $data['ext_program_date'] = $datas['meta']['thread_key'];
            }
            if (isset($signs['TOPIC'])) {
                $data['ext_topic'] = $signs['TOPIC'];
            }
            if (isset($signs['PARTICIPANT'])) {
                $data['ext_participant'] = implode('|', $signs['PARTICIPANT']);
            }
            return static::create($data);
        }
    }

    /**
     * 识别指令
     *
     * @param string $message
     * @return array
     */
    public static function recognizeCommands($message)
    {
        $result = [];

        foreach (explode("\n", $message) as $line) {
            foreach (self::COMMAND_SIGNS as $name => $sign) {
                if (false !== mb_strpos($line, $sign)) {
                    preg_match("|.*{$sign}(.+){$sign}.*|", $line, $matches);
                    if ( ! empty($matches)) {
                        if ('TOPIC' === $name) {
                            $data = trim($matches[1]);
                        }
                        if ('PARTICIPANT' === $name) {
                            $data = array_map('trim', explode('|', $matches[1]));
                        }
                        $result[$name] = $data ?? [];
                    }
                }
            }
        }

        return $result;
    }
}
