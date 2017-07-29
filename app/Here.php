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
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Scope a query to only include email records.
     *
     * @param string $email
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEmail($query, $email)
    {
        return $query->where('email', $email);
    }
}
