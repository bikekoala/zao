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
        'gm_url',
        'gm_place_id',
        'state'
    ];

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
}
