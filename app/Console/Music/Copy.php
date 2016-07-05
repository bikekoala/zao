<?php

namespace App\Console\Music;

use App\Console\Command;
use DB;

/**
 * 拷贝音乐脚本
 * 临时脚本
 *
 * @author popfeng <popfeng@yeah.net> 2016-07-04
 */
class Copy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xmusic:copy {from_id} {to_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '拷贝音乐命令（from_id to_id）';

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
        $fromId = $this->argument('from_id');
        $toIds = explode(',', $this->argument('to_id'));
        $table = 'tmp_musics';

        $fromData = (array) DB::table($table)->find($fromId);
        unset(
            $fromData['id'],
            $fromData['path'],
            $fromData['program_date'],
            $fromData['audio_part'],
            $fromData['audio_start_sec'],
            $fromData['audio_end_sec']
        );

        DB::table($table)->whereIn('id', $toIds)->update($fromData);

        $this->info('done.');
    }
}
