<?php

namespace App\Http\Controllers;

use App\{Program, Audio, Duoshuo};

use View, Config, Request, Cache;

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
    public function index(Request $request)
    {
        $isFlush = $request::get('flush');

        $html = Cache::get(Program::INDEX_CACHE_KEY);
        if ($isFlush or empty($html)) {
            $html = $this->getProgramsHtml();
            Cache::forever(Program::INDEX_CACHE_KEY, $html);
        }

        echo $html;
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
        $audios = $this->getAudios($program);

        // get around pages
        $pages = (object) [
            'prev' => Program::find($program->id - 1),
            'next' => Program::find($program->id + 1)
        ];

        // get contributions info
        $contributers = $this->getProgramContributers($program->date);

        // render page
        return View::make('programs/detail')
            ->with('program', $program)
            ->with('audios', $audios)
            ->with('pages', $pages)
            ->with('title', $program->topic)
            ->with('contributers', $contributers);
    }

    /**
     * 获取节目单HTML字符串
     *
     * @return string
     */
    private function getProgramsHtml()
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
        return (string) View::make('programs.index')->with('list', $list);
    }

    /**
     * get audio list
     *
     * @param Program $program
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getAudios($program)
    {
        // filter by source, and sort by time
        $audios = $program->audios()->enabled()->get();
        $domain = Config::get('filesystems.disks.qiniu.domain');

        $audioList = [];
        $audioGroups = $audios->groupBy('part');
        foreach ($audioGroups as $group) {
            $group = $group->groupBy('source');
            if (isset($group[Audio::SOURCE_DEFAULT])) {
                if (1 < $group->count()) {
                    unset($group[Audio::SOURCE_DEFAULT]);
                } else {
                    $audio = $group[Audio::SOURCE_DEFAULT][0];
                    $audio->url = sprintf('http://%s%s', $domain, $audio->url);
                }
            }
            $audioList[] = $group->first()->first();
        }
        $audios = collect($audioList);

        // get default title
        if (empty(array_filter(array_column($audios->toArray(), 'title')))) {
            foreach ($audios as $audio) {
                $audio->title = $audio->part;
            }
        }

        return $audios;
    }

    /**
     * 获取本节目的贡献者
     *
     * @param int $date
     * @return array
     */
    private function getProgramContributers($date)
    {
        $contributers = [
            'topic'        => null,
            'participants' => null
        ];

        $logs = Duoshuo::contributed($date)->agreed()->get()->sortByDesc('id');
        foreach ($logs as $log) {
            $author = [
                'name' => $log->metas->author_name,
                'url'  => $log->metas->author_url
            ];

            if (Duoshuo::STATUS['ENABLE'] === $log->ext_has_topic) {
                $contributers['topic'] = $author;
            }
            if (Duoshuo::STATUS['ENABLE'] === $log->ext_has_participant) {
                $contributers['participants'] = $author;
            }

            if ($contributers['topic'] and $contributers['participants']) {
                break;
            }
        }

        return $contributers;
    }
}
