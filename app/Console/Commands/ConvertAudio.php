<?php

namespace App\Console\Commands;

use DirectoryIterator;

/**
 * 转换音频格式
 *
 * @host ct
 * @author popfeng <popfeng@yeah.net> 2016-01-25
 */
class ConvertAudio extends AudioCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xaudio:convert {basepath} {task?} {year?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '转换音频格式命令';

    /**
     * 任务编号列表
     * 
     * @var array
     */
    const TASK = [
        'HLS' => 0, // ORIG -> WORK -> HLS
        'MP3' => 1  // ORIG -> WORK
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 检查年份
        $year = $this->argument('year');
        if (is_null($year)) {
            $year = date('Y');
        } elseif (2005 > $year or date('Y') < $year) {
            $this->error("Invalid year {$year}.");
        }

        // 检查任务编号
        $task = $this->argument('task');
        if (is_null($task)) {
            $task = self::TASK['HLS'];
        } elseif ( ! in_array($task, self::TASK)) {
            return $this->error("Invalid task id {$task}.");
        }

        // 检查下载目录
        $dirs = static::BASE_DIRS;
        if (self::TASK['MP3'] == $task) {
            unset($dirs['HLS']);
        }
        $paths = $this->checkPaths($this->argument('basepath'), $dirs, $year);

        // MP3转码
        $files = $this->getPendingOriginalFiles($paths);
        foreach ($files as $file) {
            $this->convertToMP3($file, $paths);
        }

        // HLS转码
        if (self::TASK['HLS'] == $task) {
            $files = $this->getPendingWorkFiles($paths);
            foreach ($files as $file) {
                $this->convertToHLS($file, $paths);
            }
        }

        $this->info('Success.');
    }

    /**
     * 转码为HLS流媒体格式
     *
     * @param string $sourceFilename
     * @param array $paths
     * @return void
     */
    private function convertToHLS($sourceFilename, $paths)
    {
        // 初始化
        $sourceFile = $paths[static::BASE_DIRS['WORK']] . '/' . $sourceFilename;
        $targetPath = $paths[static::BASE_DIRS['HLS']] . '/' .
            substr($sourceFilename, 4, -4);
        $targetFilename = substr($sourceFilename, 0, -4) . '.m3u8';

        // 转码
        passthru(sprintf(
            'ffmpeg -i "%s" -hls_segment_filename "%s/%%03d.ts" -hls_list_size 1000 -hls_time 30 -hls_allow_cache 1 -aq 0.009 "%s/%s"',
            $sourceFile,
            $targetPath,
            $targetPath,
            $targetFilename
        ), $status);
        if ($status) {
            $this->error("Convert to hls faild {$sourceFile}.");
        }
    }

    /**
     * 转码为MP3
     *
     * @param string $file
     * @param array $paths
     * @return void
     */
    private function convertToMP3($file, $paths)
    {
        // 初始化
        $files = array_map(function ($path) use ($file) {
            return $path . '/' . $file;
        }, $paths);

        // 转码
        passthru(sprintf(
            'ffmpeg -i "%s" -aq 9 "%s"',
            $files[static::BASE_DIRS['ORIG']],
            $files[static::BASE_DIRS['WORK']]
        ), $status);
        if ($status) {
            $this->error(sprintf(
                'Convert to mp3 faild %s.',
                $files[self::BASE_DIRS['ORIG']]
            ));
        }
    }

    /**
     * 获取待处理的工作区文件列表
     *
     * @param array $paths
     * @param string $extension
     * @return array
     */
    private function getPendingWorkFiles($paths, $extension = 'mp3')
    {
        $workSigns = [];
        foreach (new DirectoryIterator($paths[static::BASE_DIRS['WORK']]) as $file) {
            if ( ! $file->isFile()) continue;
            if ($extension !== $file->getExtension()) continue;

            $workSigns[] = $file->getBasename('.' . $extension);
        }

        $hlsFiles = [];
        foreach (new DirectoryIterator($paths[static::BASE_DIRS['HLS']]) as $file) {
            if ($file->isDot()) continue;
            if ( ! $file->isDir()) continue;

            $hlsSigns[] = basename($file->getPath()) . $file->getBasename();
        }

        return array_map(
            function ($sign) use ($extension) {
                return $sign . '.' . $extension;
            },
            array_diff($workSigns, $hlsSigns)
        );
    }

    /**
     * 获取待处理的原始区文件列表
     *
     * @param array $paths
     * @param array $extensions
     * @return array
     */
    private function getPendingOriginalFiles($paths, $extensions = ['mp3'])
    {
        $files = [];
        foreach ($paths as $dir => $path) {
            foreach (new DirectoryIterator($path) as $file) {
                if ( ! $file->isFile()) continue;
                if ( ! in_array($file->getExtension(), $extensions)) continue;

                $files[$dir][] = $file->getBasename();
            }
        }

        return array_diff(
            $files[static::BASE_DIRS['ORIG']] ?? [],
            $files[static::BASE_DIRS['WORK']] ?? []
        );
    }
}
