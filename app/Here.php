<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 打卡模型
 *
 * @author popfeng <popfeng@yeah.net> 2016-05-14
 */
class Here extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'heres';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'date',
        'lat',
        'lng',
        'country',
        'province',
        'location',
        'gm_place_id',
        'state'
    ];

    /**
     * 状态常量
     *
     * @var int
     */
    const STATE_ENABLE  = 1;
    const STATE_DISABLE = 0;

    /**
     * Scope a query to only include usered records.
     *
     * @param int $userId 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUsered($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include dated records.
     *
     * @param string $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDated($query, $date)
    {
        return $query->where('date', $date);
    }

    /**
     * Scope a query to only include enabled records.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnabled($query)
    {
        return $query->where('state', self::STATE_ENABLE);
    }
}
