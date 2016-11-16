<?php

namespace App\Console\Music;

use App\Console\Command;
use App\{Artist, Music, Program, ProgramMusic};
use DB;

/**
 * 部署音乐脚本
 * 临时脚本
 *
 * @author popfeng <popfeng@yeah.net> 2016-07-04
 */
class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xmusic:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '部署音乐命令';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $list = [];
        $n = 0;

        DB::table('tmp_musics')->chunk(10000, function($data) use(&$list, &$n) {
            foreach ($data as $record) {
                ++$n;

                // 合并整段记录
                $key = implode('_', [$record->audio_part, $record->acrid]);
                if (empty($list) or isset($list[$key])) {
                    $list[$key][] = $record;
                    if ( ! empty($record->acrid)) {
                        continue;
                    }
                // 插入数据
                } else {
                    // 插入歌手记录
                    $list = current($list);
                    $first = current($list);
                    $end = end($list);
                    $artistIds = [];
                    foreach (explode('|', $first->artists) as $name) {
                        $artist = Artist::firstOrCreate(['name' => $name]);
                        //$artist->increment('counts', 1);
                        $artistIds[] = $artist->id;
                    }

                    // 插入音乐记录
                    $music = Music::firstOrCreate([
                        'title'             => $first->title,
                        'album'             => $first->album,
                        'genres'            => $first->genres,
                        'label'             => $first->label,
                        'release_date'      => $first->release_date,
                        'acrid'             => $first->acrid,
                        'isrc'              => $first->isrc,
                        'upc'               => $first->upc,
                        'external_metadata' => $first->external_metadata
                    ]);

                    // 插入音乐歌手记录
                    $music->artists()->sync($artistIds);

                    // 插入节目音乐记录
                    $musicStartSec = $first->audio_start_sec ?
                        $first->audio_start_sec - 10 : 0;

                    Program::where(
                        'date',
                        $first->program_date
                    )->first()->musics()->attach($music->id, [
                        'program_part' => $first->audio_part,
                        'start_sec'    => $musicStartSec,
                        'end_sec'      => $end->audio_start_sec,
                        'url'          => self::getQiniuUrl(
                            $first->program_date,
                            $first->audio_part,
                            $musicStartSec,
                            $end->audio_start_sec
                        )
                    ]);

                    // 插入节目歌手记录
                    foreach ($music->artists as $artist) {
                        Program::where(
                            'date',
                            $first->program_date
                        )->first()->artists()->attach($artist->id);
                    }

                    // 输出日志
                    $this->info(implode("\t", [
                        $n,
                        $music->id,
                        $first->artists,
                        $first->title
                    ]));
                }

                // 清空列表
                $list = [];
            }
        });
    }

    /**
     * 获取七牛音频链接
     *
     * @param string $date
     * @param string $part
     * @param string $start
     * @param string $end
     * @return string
     */
    private static function getQiniuUrl($date, $part, $start, $end)
    {
        $dateParts = explode('-', $date);
        $audioPart = 'all' === $part ? '' : $part;

        return sprintf(
            '/%s/%s/music/%d-%d.mp3',
            $dateParts[0],
            $dateParts[1] . $dateParts[2] . $audioPart,
            $start,
            $end
        );
    }
}
