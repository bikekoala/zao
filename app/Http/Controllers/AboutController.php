<?php

namespace App\Http\Controllers;

use App\{Comment, Donation};
use View, Request, Cache;

/**
 * 关于控制器
 *
 * @author popfeng <popfeng@yeah.net> 2016-03-24
 */
class AboutController extends Controller
{

    /**
     * 首页
     *
     * @return Response
     */
    public function index()
    {
        return View::make('about.index')->with('title', '关于');
    }

    /**
     * 打赏记录
     *
     * @return Response
     */
    public function donationList()
    {
        $list = Donation::orderBy('id', 'desc')->get();

        return View::make('about.donation')
            ->with('list', $list)
            ->with('title', '打赏记录');
    }

    /**
     * 贡献记录
     *
     * @param Request $request
     * @return Response
     */
    public function contributionList(Request $request)
    {
        // get params
        $isFlush = $request::get('flush');

        // cache it
        $cacheKey = Comment::CONTRIBUTION_CACHE_KEY;
        $archive = Cache::get($cacheKey);
        if ($isFlush or empty($archive)) {
            $comments = Comment::contributed()->orderBy('id', 'DESC')->get();

            $archive = (string) View::make('about.contribution.archive')
                ->with('title', '贡献记录')
                ->with('comments', $comments);

            Cache::forever($cacheKey, $archive);
        }

        // render page
        return View::make('about.contribution.frame')->with('archive', $archive);
    }
}
