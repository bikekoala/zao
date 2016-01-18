<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 节目模型
 *
 * @author popfeng <popfeng@yeah.net> 2016-01-18
 */
class Program extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['date', 'day', 'topic', 'state'];

    /**
     * 状态常量
     *
     * @var int
     */
    const STATE_ENABLE  = 1;
    const STATE_DISABLE = 0;

    /**
     * Get the participants for the program.
     *
     * @return void
     */
    public function participants()
    {
        return $this->belongsToMany('App\Participant', 'program_participant');
    }
}
