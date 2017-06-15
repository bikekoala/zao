<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 捐助模型
 *
 * @author popfeng <popfeng@yeah.net> 2017-06-15
 */
class Donation extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'donation';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

}
