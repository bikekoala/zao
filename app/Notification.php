<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 通知消息模型
 *
 * @author popfeng <popfeng@yeah.net> 2016-03-22
 */
class Notification extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['message', 'state', 'duration_at'];

    /**
     * 状态常量
     *
     * @var int
     */
    const STATE_ENABLE  = 1;
    const STATE_DISABLE = 0;

    /**
     * 获取最新的一条通知消息
     *
     * @return array
     */
    public static function getLastNotification()
    {
        $result = static::select('id', 'message')
            ->where('state', self::STATE_ENABLE)
            ->where('duration_at', '>=', date('Y-m-d H:i:s'))
            ->orderBy('duration_at', 'desc')
            ->first();

        return $result ? $result->toArray() : [];
    }
}
