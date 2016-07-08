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
    protected $description = '拷贝音乐命令（来源id|acrid 目标id|acrid）';

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

        $fromData = (array) DB::table($table)->where(function($query) use($fromId) {
            $query->where(32 === strlen($fromId) ? 'acrid' : 'id', $fromId);
        })->first();

        unset(
            $fromData['id'],
            $fromData['path'],
            $fromData['program_date'],
            $fromData['audio_part'],
            $fromData['audio_start_sec'],
            $fromData['audio_end_sec']
        );

        DB::table($table)->where(function($query) use($toIds) {
            $query->whereIn(32 === strlen($toIds[0]) ? 'acrid' : 'id', $toIds);
        })->update($fromData);

        $this->info('done.');
    }
}
