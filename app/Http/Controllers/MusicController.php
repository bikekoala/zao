<?php

namespace App\Http\Controllers;

use App\Music;
use View;

/**
 * 音乐控制器
 *
 * @author popfeng <popfeng@yeah.net> 2016-06-04
 */
class MusicController extends Controller
{ 

    /**
     * 音乐页面
     *
     * @param int $id
     * @return Response
     */
    public function titlePage($id)
    {
        // fetch music
        $music = Music::find($id);

        // collect the total counts
        $total = [];
        foreach ($music->programMusics as $pm) {
            empty($total[$pm->dates->year]) and $total[$pm->dates->year] = 0;
            $total[$pm->dates->year]++;
        }
        $total = self::fillChartData($total);

        // TDK
        $title = implode(' - ', [
            $music->title,
            $music->artists->pluck('name')->implode(', ')
        ]);
        $description = '飞鱼秀歌单, 飞鱼秀音乐列表';

        // render
        return View::make('music.song')
            ->with('music', $music)
            ->with('total', $total)
            ->with('title', $title)
            ->with('description', $description);
    }

    /**
     * 艺术家页面
     *
     * @param int $id
     * @return Response
     */
    public function artistPage($id)
    {
        return View::make('music.artist')
            ->with('title', 'The Innocence Mission');
    }

    /**
     * 填充图表数据
     *
     * @param array $data
     * @return array
     */
    private static function fillChartData($data)
    {
        $list = [];
        foreach (range(2004, 2016) as $year) {
            $list[] = isset($data[$year]) ? $data[$year] : 0;
        }
        return $list;
    }
}
