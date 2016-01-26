<?php

namespace App\Console\Audio;

use App\Console\Abst;

/**
 * 音频处理抽象类
 *
 * @author popfeng <popfeng@yeah.net> 2016-01-24
 */
abstract class Abst extends Abst
{
    /**
     * App API
     *
     * @var string
     */
    const API = 'http://ezfm.china-plus.cn/index.php?m=index&a=cat_list&cid=224';

    /**
     * 目录列表
     *
     * @var array
     */
    const BASE_DIRS = [
        'ORIG' => 'general_original', // 原始区
        'WORK' => 'general_work',     // 工作区
        'HLS'  => 'general_hls'       // 流媒体区
    ];

    /**
     * 检查下载目录
     *
     * @param string $path
     * @param array $dirs
     * @param int $year
     * @return array
     */
    protected function checkPaths($path, array $dirs = null, int $year = null)
    {
        if (is_dir($path)) {
            $paths = [];
            $dirs = $dirs ? : static::BASE_DIRS;
            foreach ($dirs as $dir) {
                if ( ! is_dir($path . '/' . $dir)) {
                    return $this->error("Invalid basepath {$path}/{$dir}.");
                } else {
                    $paths[$dir] = sprintf(
                        '%s/%s/%s', $path, $dir, $year ? : date('Y')
                    );

                    is_dir($paths[$dir]) or mkdir($paths[$dir]);
                }
            }
            return $paths;
        } else return $this->error("Invalid basepath {$path}.");
    }

    /**
     * 根据API获取节目单，并按日期进行筛选
     *
     * @param string $lastDate
     * @return array
     */
    protected function getProgramList($lastDate = '')
    {
        // 识别日期
        $lastDate = $lastDate ? : date('Y-m-d', strtotime('-1 day')); 

        // 查询App API
        $list = [];
        if ($data = json_decode(file_get_contents(static::API))) {
            foreach ($data->data as $i => $item) {
                if (strtotime($lastDate) < strtotime($item->update_time)) {
                    $list[] = (array) $item;
                }
            }
            krsort($list);
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
}
