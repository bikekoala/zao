<?php

namespace App\Console\Tool;

use App\Console\Command;
use App\Console\Audio\Command as AudioCommand;
use Cache;

/**
 * 同步App节目日期
 *
 * @author popfeng <popfeng@yeah.net> 2016-03-24
 */
class SyncAppProgram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xtool:sync-app-program';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步 App 节目日期';

    /**
     * App 节目日期 KEY
     */
    const DATE_CACHE_KEY = 'app_program_date';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $list = AudioCommand::getProgramList(date('Y-m-d', strtotime('-2 day')));
        if ( ! empty($list)) {
            $title = $list[0]['title'];
            $date = substr($title, strpos($title, '-') + 1);

            $result = date_parse_from_format('Ymd', $date);
            if ( ! empty($result['errors']) or ! empty($result['warnings'])) {
                return $this->error("Invalid date format - {$title}");
            }

            Cache::forever(self::DATE_CACHE_KEY, $date);
        }

        return $this->info('Success.');
    }
}
