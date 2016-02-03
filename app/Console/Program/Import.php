<?php

namespace App\Console\Program;

use App\Console\Command;
use App\{Program, Participant, Audio};
use DB;

/**
 * 导入节目单脚本
 *
 * @author popfeng <popfeng@yeah.net> 2016-01-18
 */
class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xprogram:import {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '导入节目单命令（from excel）';

    /**
     * The supportive Excel fields.
     *
     * @var array
     */
    protected static $fields = [
        'date',
        'part',
        'topic',
        'participant',
        'file_name',
        'original_url',
        'url_source'
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 获取文本路径
        $path = $this->argument('path');
        if ( ! is_file($path)) {
            return $this->error("Invalid file path {$path}.");
        }

        // 解析数据
        $list = self::decodeText($path);

        // 插入数据
        foreach ($list as $group) {
            DB::transaction(function () use (&$group) {
                // 插入声音记录
                self::insertAudios($group);

                // 插入参与人记录
                $data = $group['all'] ?? end($group);
                $participantIds = [];
                $participantNames = Participant::filterParticipantNames($data['participant']);
                foreach ($participantNames as $name) {
                    $participant = Participant::firstOrCreate(['name' => $name]);
                    $participant->increment('counts', 1);
                    $participantIds[] = $participant->id;
                }

                // 插入节目记录
                $topic = Program::filterTopic($data['topic']);
                if (empty($group['all'])) {
                    if (in_array(mb_substr($topic, -1), ['a', 'b', 'c'])) {
                        $topic = mb_substr($topic, 0, -1);
                    }
                }
                $program = Program::firstOrCreate([
                    'date'  => $data['date'],
                    'topic' => $topic,
                    'state' => Program::STATE_ENABLE
                ]);
                if ( ! empty($participantIds)) {
                    $program->participants()->sync($participantIds);
                }

                // 输出日期
                $this->info(sprintf("%s\t%s", $data['date'], $topic));
            });
        }
    }

    /**
     * 插入声音记录
     *
     * @param array $group
     * @return void
     */
    protected static function insertAudios(array $group)
    {
        foreach ($group as $data) {
            $list = ['qiniu' => $data, 'other' => $data];

            if ( ! empty($data['file_name'])) {
                $list['qiniu']['src'] = Audio::SOURCE_DEFAULT;
                $list['qiniu']['url'] = self::getQiniuUrl($data['file_name']);
            }

            if ( ! empty($data['original_url'])) {
                $list['other']['src'] = $data['original_url'];
                $list['other']['url'] = $data['url_source'];
            } else unset($list['other']);

            foreach ($list as $item) {
                Audio::create([
                    'date'   => $item['date'],
                    'part'   => $item['part'],
                    'title'  => $item['topic'],
                    'source' => $item['src'],
                    'url'    => $item['url'],
                    'state'  => Audio::STATE_ENABLE
                ]);
            }
        }
    }

    /**
     * 获取七牛音频链接
     *
     * @param string $fileName
     * @return string | false
     */
    protected static function getQiniuUrl(string $fileName)
    {
        $file = strstr($fileName, '.', true);
        $year = substr($file, 0, 4);
        $date = substr($file, 4);

        return sprintf('/%s/%s/%s.m3u8', $year, $date, $file);
    }

    /**
     * 解析节目单数据
     *
     * @param string $path
     * @return array
     */
    protected static function decodeText(string $path)
    {
        $list = [];
        foreach (file($path) as $i => $line) {
            foreach (array_map('trim', explode("\t", $line)) as $k => $v) {
                isset(self::$fields[$k]) && $list[$i][self::$fields[$k]] = $v;
            }
        }
        krsort($list);

        $data = [];
        foreach ($list as $item) {
            $data[$item['date']][$item['part']] = $item;
        }

        return $data;
    }
}
