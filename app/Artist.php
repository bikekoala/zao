<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 歌手模型
 *
 * @author popfeng <popfeng@yeah.net> 2016-07-09
 */
class Artist extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'artists';

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
}
