<?php

namespace App\Http\Controllers;

use App\{Music, Artist};
use View, Request, Cache;

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
        $cate = $request::get('cate', 'all');
        $limit = 'all' === $cate ? $request::get('limit', 50) : 100000;

        // collect data
        $cacheKey = Music::INDEX_ALL_CACHE_PREFIX . $cate;
        $data = Cache::get($cacheKey) ?: [];
        if (empty($data)) {
            if (in_array($cate, ['all', 'music'])) {
                $musics = Music::select('id', 'title', 'album', 'counts')
                    ->orderBy('counts', 'desc')
                    ->take($limit)
                    ->get();
                $musicCounts = Music::count();

                $data['music'] = ['list' => $musics, 'counts' => $musicCounts];
            }

            if (in_array($cate, ['all', 'artist'])) {
                $artists = Artist::orderBy('counts', 'desc')->take($limit)->get();
                $artistCounts = Artist::count();

                $data['artist'] = ['list' => $artists, 'counts' => $artistCounts];
            }

            Cache::forever($cacheKey, $data);
        }

        // TDK
        $title = '飞鱼秀 の 大歌单';
        if ('artist' === $cate) {
            $title = $title . ' - 全部歌手';
        }
        if ('music' === $cate) {
            $title = $title . ' - 全部歌曲';
        }
        $description = '飞鱼秀歌单, 飞鱼秀音乐列表';

        // render
        return View::make('music.index')
            ->with('data', $data)
            ->with('cate', $cate)
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
