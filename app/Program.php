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
    protected $fillable = ['date', 'topic', 'state'];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function participants()
    {
        return $this->belongsToMany('App\Participant', 'program_participant');
    }

    /**
     * Scope a query to only include enabled programs.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnabled($query)
    {
        return $query->where('state', self::STATE_ENABLE);
    }

    /**
     * Get the date info.
     *
     * @param  string  $value
     * @return string
     */
    public function getDateAttribute($value)
    {
        $date = array_combine(['year', 'month', 'day'], explode('-', $value));
        $date['id'] = implode('', $date);
        $date['day_num'] = ['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($value))];

        return (object) $date;
    }

    /**
     * 获取节目单列表
     *
     * @return array
     */
    public static function getList()
    {
        $programs = static::with('participants')
            ->enabled()
            ->orderBy('date', 'desc')
            ->get();

        $list = [];
        foreach ($programs as $program) {
            $list[$program->date->year][$program->date->month][] = $program;
        }

        return $list;
    }
}
