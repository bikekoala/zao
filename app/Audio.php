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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'audios';

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

    /**
     * Scope a query to only include enabled programs.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnabled($query)
    {
        return $query->where('state', self::STATE_ENABLE);
    }
}
