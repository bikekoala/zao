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
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'participants';

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

    public function programs()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Scope a query to only include searched participants.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearched($query, $keyword)
    {
        $keyword = strtolower($keyword);
        return $query->where('name', 'like', "%{$keyword}%");
    }

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
