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
        'ext_has_topic',
        'ext_has_participant'
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
     * 状态集合
     *
     * @var array
     */
    const STATUS = [
        'DISABLE' => -1,
        'DEFAULT' => 0,
        'ENABLE'  => 1,
    ];

    /**
     * Scope a query to only include contributed programs.
     *
     * @param string $programDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeContributed($query, $programDate = null)
    {
        $query->where('action', self::ACTION['CREATE']);
        $query->where(function ($query) {
            $query->orWhere('ext_has_topic', self::STATUS['ENABLE']);
            $query->orWhere('ext_has_participant', self::STATUS['ENABLE']);
        });
        if ($programDate) {
            $query->where('ext_program_date', $programDate);
            $query->where('exit_is_agree', self::STATUS['ENABLE']);
        }
        return $query;
    }

    /**
     * Get the meta data.
     *
     * @return object
     */
    public function getMetasAttribute()
    {
        return json_decode($this->meta);
    }

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
     * @return int
     */
    public static function import($datas, $signs)
    {
        $record = static::where('log_id', $datas['log_id'])->first();
        if ( ! empty($record)) {
            return $record->id;
        } else {
            // 原始数据
            $data = [
                'log_id'  => $datas['log_id'],
                'user_id' => $datas['user_id'],
                'action'  => $datas['action'],
                'meta'    => json_encode($datas['meta']),
                'date'    => date('Y-m-d H:i:s', $datas['date'])
            ];

            // 扩展数据
            $data['ext_created_at'] = date('Y-m-d H:i:s');
            if (isset($datas['meta']['thread_key'])) {
                $data['ext_program_date'] = $datas['meta']['thread_key'];
            }
            if (isset($signs['TOPIC'])) {
                $data['ext_has_topic'] = self::STATUS['ENABLE'];
            }
            if (isset($signs['PARTICIPANT'])) {
                $data['ext_has_participant'] = self::STATUS['ENABLE'];
            }

            return static::insertGetId($data);
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
