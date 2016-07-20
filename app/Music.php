<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 歌曲模型
 *
 * @author popfeng <popfeng@yeah.net> 2016-07-09
 */
class Music extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'musics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'album',
        'genres',
        'label',
        'release_date',
        'acrid',
        'isrc',
        'upc',
        'external_metadata'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the artists for the program.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function artists()
    {
        return $this->belongsToMany('App\Artist', 'music_artist');
    }

    /**
     * Get the programs for the program.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function programs()
    {
        return $this->belongsToMany('App\Program', 'program_music')
            ->orderBy('id', 'desc')
            ->withPivot(
                'program_part',
                'start_sec',
                'end_sec',
                'url'
            );
    }
}
