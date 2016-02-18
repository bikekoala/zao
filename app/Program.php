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
     * 首页缓存KEY
     */
    const INDEX_CACHE_KEY = 'programs_html';

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
     * Get the audios for program.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function audios()
    {
        return $this->hasMany('App\Audio', 'date', 'date');
    }

    /**
     * Scope a query to only include enabled programs.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnabled($query)
    {
        return $query->where('state', self::STATE_ENABLE);
    }

    /**
     * Scope a query to only include dated programs.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDated($query, int $date)
    {
        return $query->where('date', date('Y-m-d', strtotime($date)));
    }

    /**
     * Get the date info.
     *
     * @return object
     */
    public function getDatesAttribute()
    {
        $dates = array_combine(['year', 'month', 'day'], explode('-', $this->date));
        $dates['id'] = implode('', $dates);
        $dates['dayNum'] = ['日', '一', '二', '三', '四', '五', '六'][
            date('w', strtotime($this->date))
        ];

        return (object) $dates;
    }

    /**
     * 过滤话题名称
     *
     * @param string $topic
     * @return string
     */
    public static function filterTopic($topic)
    {
        return trim($topic);
    }
}
