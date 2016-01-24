<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;

/**
 * 下载节目音频脚本
 *
 * @host ct
 * @author popfeng <popfeng@yeah.net> 2016-01-24
 */
class DownloadAudio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xaudio:download {basepath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '下载节目音频命令';

    /**
     * 目录列表
     *
     * @var array
     */
    const BASE_DIRS = [
        'ORIG' => 'general_original',
        'WORK' => 'general'
    ];

    /**
     * App API
     *
     * @var string
     */
    const API = 'http://ezfm.china-plus.cn/index.php?m=index&a=cat_list&cid=224';

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
        // 检查下载目录
        $paths = $this->checkPaths();

        // 获取待下载节目单
        //$lastDate = $this->getLastFileDate($path);
        $lastDate = '2015-12-31';
        $list = self::getProgramList($lastDate);

        // 下载音频，并转码
        foreach ($list as $item) {
            $this->download($item['url'], $item['file'], $paths);
        }
    }

    /**
     * 下载音频，并转码
     *
     * @param string $url
     * @param string $filename
     * @param array $paths
     * @return void
     */
    protected function download($url, $filename, $paths)
    {
        // 初始化
        $files = array_map(function ($path) use ($filename) {
            return $path . '/' . $filename;
        }, $paths);

        // 下载
        passthru(sprintf(
            'wget -c %s -O %s', $url, $files[self::BASE_DIRS['ORIG']]
        ), $status);
        $status and $this->error("{$url} download faild.");

        // 转码
        passthru(sprintf(
            'ffmpeg -i "%s" -aq 9 "%s"',
            $files[self::BASE_DIRS['ORIG']],
            $files[self::BASE_DIRS['WORK']]
        ), $status);
        $status and $this->error($files[self::BASE_DIRS['ORIG']] . ' convert faild.');
    }

    /**
     * 获取最后下载的文件日期 
     *
     * @param string $path
     * @param array $extensions
     * @return string
     */
    protected function getLastFileDate($path, $extensions = ['mp3'])
    {
    }

    /**
     * 检查下载目录
     *
     * @return array
     */
    protected function checkPaths()
    {
        $path = $this->argument('basepath');
        if (is_dir($path)) {
            $paths = [];
            foreach (self::BASE_DIRS as $dir) {
                if ( ! is_dir($path . '/' . $dir)) {
                    return $this->error("Invalid {$dir} basepath.");
                } else {
                    $paths[$dir] = sprintf(
                        '%s/%s/%s', $path, $dir, date('Y')
                    );

                    is_dir($paths[$dir]) or mkdir($paths[$dir]);
                }
            }
            return $paths;
        } else return $this->error('Invalid basepath.');
    }

    /**
     * 根据API获取节目单，并按日期进行筛选
     *
     * @param string $lastDate
     * @return array
     */
    public static function getProgramList($lastDate = '')
    {
        // 识别日期
        $lastDate = $lastDate ? : date('Y-m-d', strtotime('-1 day')); 

        // 查询App API
        $list = [];
        if ($data = json_decode(file_get_contents(self::API))) {
            foreach ($data->data as $i => $item) {
                if (strtotime($lastDate) < strtotime($item->update_time)) {
                    $list[] = (array) $item;
                }
            }
        } else return [];

        // 重组字段
        foreach ($list as &$item) {
            $title = trim($item['title']);
            if ('资讯' === mb_substr($title, -2)) {
                $part = 'a';
            } elseif ('a' === substr($title, -1)) {
                $part = 'b';
            } elseif ('b' === substr($title, -1)) {
                $part = 'c';
            } else {
                $part = '';
            }

            $item['file'] = date('Ymd', strtotime($item['update_time'])) .
                $part . substr($item['url'], strrpos($item['url'], '.'));
            $item['title'] = $title;
        }

        return $list;
    }

    /**
     * 输出错误信息，并记录日志
     *
     * @param string $message
     * @param bool $isExit
     * @return void
     */
    public function error($message, $isExit = true)
    {
        parent::error($message);
        Log::error($message);

        if ($isExit) {
            exit;
        }
    }
}
