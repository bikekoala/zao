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

    /**
     * Get the musics for the artist.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function musics()
    {
        return $this->belongsToMany('App\Music', 'music_artist');
    }

    /**
     * Get the programs for the artist.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function programs()
    {
        return $this->belongsToMany('App\Program', 'program_artist')
            ->orderBy('id', 'desc')
            ->withPivot(
                'program_part',
                'start_sec',
                'end_sec',
                'url'
            );
    }
}
