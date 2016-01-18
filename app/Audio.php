<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 声音模型
 *
 * @author popfeng <popfeng@yeah.net> 2016-01-18
 */
class Audio extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['date', 'time', 'title', 'source', 'state', 'url'];

    /**
     * 状态常量
     *
     * @var int
     */
    const STATE_ENABLE  = 1;
    const STATE_DISABLE = 0;

    /**
     * 默认地址源
     *
     * $var string
     */
    const SOURCE_DEFAULT = 'qiniu';
}
