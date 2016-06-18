<?php

namespace App\Console\Music;

use App\Console\Command;
use DB;

/**
 * 导入音乐脚本
 *
 * @author popfeng <popfeng@yeah.net> 2016-05-31
 */
class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xmusic:import {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '导入音乐命令（from txt）';

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
        // 获取文本路径
        $path = $this->argument('path');
        if ( ! is_file($path)) {
            return $this->error("Invalid file path {$path}.");
        }

        // 解析数据，并插入数据库
        $handle = fopen($path, 'r');
        if ($handle) {
            while (false !== ($buffer = fgets($handle))) {
                list($path, $result) = explode("\t", $buffer);
                $info = json_decode($result, true);
                if ( ! empty($info)) {
                    $info = isset($info['metadata']['music'][0]) ?
                        $info['metadata']['music'][0] : 
                        $info['metadata']['music'];
                }

                // Insert
                $status = $this->insertMusics($path, $info);

                // Output
                $status and $this->info(sprintf("%s\t%s", $path, $info['title'] ?? ''));
            }
            if ( ! feof($handle)) {
                return $this->error("Error: unexpected fgets() fail.");
            }
            fclose($handle);

            $this->info('done.');
        }
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
