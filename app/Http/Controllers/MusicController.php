<?php

namespace App\Http\Controllers;

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
        return View::make('music.song')
            ->with('title', '500 Miles - The Innocence Mission');
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
}
