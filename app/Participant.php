<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 参与人模型
 *
 * @author popfeng <popfeng@yeah.net> 2016-01-18
 */
class Participant extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'counts'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 过滤参与人姓名
     *
     * @param string $names
     * @return array
     */
    public static function filterParticipantNames($names)
    {
        return array_filter(array_map('trim', explode('|', $names)));
    }
}
