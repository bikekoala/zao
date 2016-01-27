<?php

namespace App\Console\Program;

use App\Console\Command;
use App\Console\Audio\Command as AudioCommand;
use App\{Program, Audio};
use DB;

/**
 * 更新节目单脚本
 *
 * @author popfeng <popfeng@yeah.net> 2016-01-27
 */
class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xprogram:update {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新节目单命令';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 验证日期
        $date = $this->argument('date');
        if ($date) {
            $result = date_parse_from_format('Y-m-d', $date);
            if ( ! empty($result['errors'])) {
                return $this->error(current($result['errors']) . " {$date}.");
            }
            if ( ! empty($result['warnings'])) {
                return $this->error(current($result['warnings']) . " {$date}.");
            }
        }

        // 获取近期的节目列表
        $list = $this->getProgramList($date);
        extract($list);

        // 导入数据
        foreach ($programs as $date => $program) {
            DB::transaction(function () use ($program, $audios, $date) {
                self::insertAudios($audios[$date]);
                self::insertProgram($program);

                $this->info(sprintf("%s\t%s", $program['date'], $program['topic']));
            });
        }
    }

    /**
     * 插入节目记录
     *
     * @param array $data
     * @return void
     */
    protected static function insertProgram(array $data)
    {
        $data['state'] = Program::STATE_ENABLE;
        Program::firstOrCreate($data);
    }

    /**
     * 插入声音记录
     *
     * @param array $data
     * @return void
     */
    protected static function insertAudios(array $data)
    {
        foreach ($data as $item) {
            $item['state'] = Audio::STATE_ENABLE;
            Audio::firstOrCreate($item);
        }
    }

    /**
     * 获取指定日期以来的节目列表
     *
     * @param string $date
     * @return array
     */
    protected function getProgramList($date)
    {
        $list = AudioCommand::getProgramList($date);

        $audios = [];
        foreach ($list as $item) {
            $title = substr($item['title'], strpos($item['title'], '-') + 1);
            $title = is_numeric(substr($title, 0, 4)) ? '资讯' : $title;
            $audios[$item['update_time']][] = [
                'title'  => $title,
                'date'   => $item['update_time'],
                'time'   => $item['part'] ? : 'all',
                'url'    => $item['url'],
                'source' => $item['source']
            ]; 
        }

        $programs = [];
        foreach ($audios as $date => $items) {
            foreach ($items as $item) {
                $topic = $item['title'];
                if ('a' === substr($item['title'], -1)) {
                    $topic = substr($item['title'], 0, -1);
                    break;
                }
            }
            $programs[$date] = [
                'date' => $date,
                'topic' => $topic
            ];
        }

        return compact('audios', 'programs');
    }
}
