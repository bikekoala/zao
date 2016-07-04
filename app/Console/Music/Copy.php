<?php

namespace App\Console\Music;

use App\Console\Command;
use DB;

/**
 * 拷贝音乐脚本
 * 临时脚本
 *
 * @author popfeng <popfeng@yeah.net> 2016-07-04
 */
class Copy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xmusic:copy {from_id} {to_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '拷贝音乐命令（from_id to_id）';

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
        $fromId = $this->argument('from_id');
        $toIds = explode(',', $this->argument('to_id'));
        $table = 'tmp_musics';

        $fromData = (array) DB::table($table)->find($fromId);
        unset(
            $fromData['id'],
            $fromData['path'],
            $fromData['program_date'],
            $fromData['audio_part'],
            $fromData['audio_start_sec'],
            $fromData['audio_end_sec']
        );

        DB::table($table)->whereIn('id', $toIds)->update($fromData);

        $this->info('done.');
    }

    /**
     * 插入音乐记录
     *
     * @param string $path
     * @param array $info
     * @return bool
     */
    protected static function insertMusics($path, $info)
    {
        $table = DB::table('tmp_musics');

        if ($table->where('path', $path)->count()) {
            return false;
        }

        preg_match('|\d{4}\/(\d{8})([a-z]?)\.mp3\/(\d+)\.(\d+)\.mp3|', $path, $file);
        return (bool) $table->insert([
            'path'              => $path,
            'program_date'      => $file[1],
            'audio_part'        => $file[2] ? : 'all',
            'audio_start_sec'   => $file[3],
            'audio_end_sec'     => $file[4],
            'title'             => $info['title'] ?? '',
            'album'             => $info['album']['name'] ?? '',
            'artists'           => isset($info['artists']) ? implode('|', array_column($info['artists'], 'name')) : '',
            'genres'            => isset($info['genres']) ? implode('|', array_column($info['genres'], 'name')) : '',
            'release_date'      => $info['release_date'] ?? '',
            'label'             => $info['label'] ?? '',
            'acrid'             => $info['acrid'] ?? '',
            'isrc'              => $info['external_ids']['isrc'] ?? '',
            'upc'               => $info['external_ids']['upc'] ?? '',
            'external_metadata' => ! empty($info['external_metadata']) ? json_encode($info['external_metadata'], JSON_UNESCAPED_UNICODE) : ''
        ]);
    }
}
