<?php

namespace App\Http\Controllers;

use App\{Program, Audio};

use View, Config;

/**
 * 节目控制器
 *
 * @author popfeng <popfeng@yeah.net> 2016-01-11
 */
class ProgramsController extends Controller
{

    /**
     * 首页
     *
     * @return Response
     */
    public function index()
    {
        // query program list, and sort by date
        $programs = Program::with('participants')
            ->enabled()
            ->orderBy('date', 'desc')
            ->get();

        $list = [];
        foreach ($programs as $program) {
            $list[$program->dates->year][$program->dates->month][] = $program;
        }

        // render page
        return View::make('programs.index')->with('list', $list);
    }

    /**
     * 详情
     *
     * @param int $date
     * @return void
     */
    public function detail($date)
    {
        // query the specified dates program and audio data
        $program = Program::dated($date)->enabled()->first();
        $audios = $program->audios()->enabled()->get();

        // filter by source, and sort by time
        $audioGroups = $audios->groupBy('source');
        if (isset($audioGroups[Audio::SOURCE_DEFAULT])) {
            if (1 < $audioGroups->count()) {
                unset($audioGroups[Audio::SOURCE_DEFAULT]);
            } else {
                $domain = Config::get('filesystems.disks.qiniu.domain');
                foreach ($audioGroups[Audio::SOURCE_DEFAULT] as $audio) {
                    $audio->url = sprintf('http://%s%s', $domain, $audio->url);
                }
            }
        }
        $audios = $audioGroups->last()->sortBy('time');

        // get around pages
        $pages = (object) [
            'prev' => Program::find($program->id - 1),
            'next' => Program::find($program->id + 1)
        ];

        // render page
        return View::make('programs/detail')
            ->with('program', $program)
            ->with('audios', $audios)
            ->with('pages', $pages)
            ->with('title', $program->topic);
    }
}
