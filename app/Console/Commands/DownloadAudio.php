<?php

namespace App\Console\Commands;

use DirectoryIterator;

/**
 * 下载节目音频脚本
 *
 * @host ct
 * @author popfeng <popfeng@yeah.net> 2016-01-24
 */
class DownloadAudio extends AudioCommand
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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 检查下载目录
        $paths = $this->checkPaths($this->argument('basepath'));

        // 获取待下载节目单
        $lastDate = $this->getLastFileDate($paths[static::BASE_DIRS['ORIG']]);
        $list = $this->getProgramList($lastDate);

        // 下载音频
        foreach ($list as $item) {
            $this->download(
                $item['url'],
                $paths[static::BASE_DIRS['ORIG']] . '/' . $item['file']
            );
        }

        $this->info('Success.');
    }

    /**
     * 下载音频
     *
     * @param string $url
     * @param string $path
     * @return void
     */
    private function download($url, $path)
    {
        passthru(sprintf('wget -c %s -O %s', $url, $path), $status);

        $status and $this->error("Download faild {$url}.", false);
    }

    /**
     * 获取最后下载的文件日期 
     *
     * @param string $path
     * @param array $extensions
     * @return string
     */
    private function getLastFileDate($path, $extensions = ['mp3'])
    {
        $ctimes = [];
        foreach (new DirectoryIterator($path) as $file) {
            if ( ! $file->isFile()) continue;
            if ( ! in_array($file->getExtension(), $extensions)) continue;

            $ctimes[] = $file->getCTime();
        }

        if ( ! empty($ctimes)) {
            rsort($ctimes);
            return date('Y-m-d', array_shift($ctimes));
        } else return null;
    }
}
