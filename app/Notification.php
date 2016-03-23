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
}
