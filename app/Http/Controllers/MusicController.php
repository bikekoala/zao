<?php

namespace App\Http\Controllers;

use App\{Music, Artist};
use View, Request;

/**
 * 音乐控制器
 *
 * @author popfeng <popfeng@yeah.net> 2016-06-04
 */
class MusicController extends Controller
{ 
    /**
     * 首页
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        // get params
        $cate = $request::get('cate');
        $limit = $request::get('limit', 50);

        // collect data
        $musics = Music::select('id', 'title', 'album', 'counts')
            ->orderBy('counts', 'desc')
            ->take($limit)
            ->get();
        $artists = Artist::orderBy('counts', 'desc')->take($limit)->get();

        $musicCounts = Music::count();
        $artistCounts = Artist::count();

        // TDK
        $title = '飞鱼秀の大歌单';
        $description = '飞鱼秀歌单, 飞鱼秀音乐列表';

        // render
        return View::make('music.index')
            ->with('musics', $musics)
            ->with('artists', $artists)
            ->with('music_counts', $musicCounts)
            ->with('artist_counts', $artistCounts)
            ->with('limit', $limit)
            ->with('title', $title)
            ->with('description', $description);
    }

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
        foreach ($music->programs as $pm) {
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
        // fetch artist
        $artist = Artist::find($id);

        // collect the total counts
        $total = [];
        foreach ($artist->programs as $pm) {
            empty($total[$pm->dates->year]) and $total[$pm->dates->year] = 0;
            $total[$pm->dates->year]++;
        }
        $total = self::fillChartData($total);

        // TDK
        $title = $artist->name;
        $description = '飞鱼秀歌曲歌手, 飞鱼秀音乐艺人';

        return View::make('music.artist')
            ->with('artist', $artist)
            ->with('total', $total)
            ->with('title', $title)
            ->with('description', $description);
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
