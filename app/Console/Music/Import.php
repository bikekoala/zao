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
    protected $description = '导入音乐命令（from excel）';

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
                $result = json_decode($result, true);
                if ( ! empty($result)) {
                    $info = isset($result['metadata']['music'][0]) ?
                        $result['metadata']['music'][0] : 
                        $result['metadata']['music'];
                    print_r($info);
                    exit;

                    // Insert
                    $this->insertMusics($info);

                    // Output
                    //$this->info(sprintf("%s\t%s", $data['date'], $topic));
                }
            }
            if ( ! feof($handle)) {
                return $this->error("Error: unexpected fgets() fail.");
            }
            fclose($handle);
        }
    }

    /**
     * 插入音乐记录
     *
     * @param array $info
     * @return void
     */
    protected static function insertMusics(array $info)
    {
        foreach ($group as $data) {
            $list = ['qiniu' => $data, 'other' => $data];

            if ( ! empty($data['file_name'])) {
                $list['qiniu']['src'] = Audio::SOURCE_DEFAULT;
                $list['qiniu']['url'] = self::getQiniuUrl($data['file_name']);
            }

            if ( ! empty($data['original_url'])) {
                $list['other']['src'] = $data['url_source'];
                $list['other']['url'] = $data['original_url'];
            } else unset($list['other']);

            foreach ($list as $item) {
                Audio::create([
                    'date'   => $item['date'],
                    'part'   => $item['part'],
                    'title'  => $item['topic'],
                    'source' => $item['src'],
                    'url'    => $item['url'],
                    'state'  => Audio::STATE_ENABLE
                ]);
            }
        }
    }
}
