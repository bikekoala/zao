<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\{Program, Participant, Audio};
use itbdw\QiniuStorage\QiniuStorage;
use DB, Config;

/**
 * 导入节目单脚本
 *
 * @author popfeng <popfeng@yeah.net> 2016-01-18
 */
class ImportProgram extends Command
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
        'time',
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
            return $this->error('Invalid file path.');
        }

        // 解析数据
        $list = self::decodeText($path);

        // 插入数据
        foreach ($list as $item) {
            DB::transaction(function () use (&$item) {
                self::insertAudios($item);
                self::insertParticipants($item);
                self::insertPrograms($item);

                $this->info(sprintf("%s\t%s", $item['date'], $item['topic']));
            });
        }
    }

    /**
     * 插入节目记录
     *
     * @param array $data
     * @return void
     */
    protected static function insertPrograms(array $data)
    {
        $program = Program::firstOrCreate([
            'date'  => $data['date'],
            'topic' => $data['topic'],
            'state' => Program::STATE_ENABLE
        ]);

        foreach ($data['participant_ids'] as $participantId) {
            $program->participants()->attach($participantId);
        }
    }

    /**
     * 插入参与人记录
     *
     * @param array $data
     * @return void
     */
    protected static function insertParticipants(array &$data)
    {
        foreach (explode('|', $data['participant']) as $name) {
            $participant = Participant::firstOrCreate(['name' => $name]);
            $participant->increment('counts', 1);

            $data['participant_ids'][] = $participant->id;
        }
    }

    /**
     * 插入声音记录
     *
     * @param array $data
     * @return void
     */
    protected static function insertAudios(array $data)
    {
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
                'time'   => $item['time'],
                'title'  => $item['topic'],
                'source' => $item['src'],
                'url'    => $item['url'],
                'state'  => Audio::STATE_ENABLE
            ]);
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
        return sprintf('/%s.m3u8', strstr($fileName, '.', true));
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
        return $list;
    }
}
