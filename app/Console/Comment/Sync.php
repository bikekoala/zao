<?php

namespace App\Console\Comment;

use App\Console\Command;
use App\{Program, Participant, Comment};
use DB, Cache, Disqus;

/**
 * 同步评论脚本
 *
 * @author popfeng <popfeng@yeah.net> 2017-06-14
 */
class Sync extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xcomment:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步评论命令';

    /**
     * 指令标识
     *
     * @var array
     */
    const COMMAND_SIGNS = [
        'TOPIC'       => ['🐶', ':dog:'],
        'PARTICIPANT' => ['🐰', ':rabbit:']
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
        $comments = $this->getLatestComments();

        foreach ($comments as $comment) {

            // 识别指令
            $signs = $this->recognizeCommands($comment->raw_message);

            // 记录日志 
            Comment::import($comment, $signs);

            // 更新节目
            if ( ! empty($signs)) {
                $date = program_date_from_url($comment->thread->link);

                $this->updateProgram($date, $signs);
            }

        }

        $this->info('done.');
    }

    /**
     * 获取最新评论列表
     *
     * @return array
     */
    private function getLatestComments()
    {
        $disqus = new Disqus(config('disqus.api_secret'));

        $since = str_replace(' ', 'T', Comment::max('cmt_created_at')); 

        $params = [
            'forum'   => config('disqus.short_name'),
            'offset'  => 0,
            'limit'   => 100,
            'order'   => 'asc',
            'include' => 'approved',
            'related' => 'thread',
            'since'   => $since
        ];

        $comments = $disqus->posts->list($params);

        return $comments ?: [];
    }

    /**
     * 识别指令
     *
     * @param string $message
     * @return array
     */
    private function recognizeCommands($message)
    {
        $result = [];

        foreach (explode("\n", $message) as $line) {
            foreach (self::COMMAND_SIGNS as $name => $signs) {
                foreach ($signs as $sign) {
                    if (false !== mb_strpos($line, $sign)) {
                        preg_match("|.*{$sign}(.+){$sign}.*|", $line, $matches);
                        if ( ! empty($matches)) {
                            if ('TOPIC' === $name) {
                                $data = Program::filterTopic($matches[1]);
                            }
                            if ('PARTICIPANT' === $name) {
                                $data = Participant::filterParticipantNames($matches[1]);
                            }
                            $result[$name] = $data ?? [];
                        }
                    }
                }
            }
        }

        return $result;
    }

    /**
     * 更新节目
     *
     * @param string $date
     * @param array $signs
     * @return void
     */
    private function updateProgram($date, $signs)
    {
        // 参与人
        $participantIds = [];
        if (isset($signs['PARTICIPANT'])) {
            foreach ($signs['PARTICIPANT'] as $name) {
                $participant = Participant::firstOrCreate(['name' => $name]);
                $participant->increment('counts', 1);
                $participantIds[] = $participant->id;
            }
        }

        // 节目
        $program = Program::where('date', $date)->first();
        if (isset($signs['TOPIC'])) {
            $topic = Program::filterTopic($signs['TOPIC']);
            if ( ! empty($topic)) {
                $program->update(['topic' => $topic]);
            }
        }
        if ( ! empty($participantIds)) {
            $program->participants()->sync($participantIds);
        }

        // 刷新首页文件缓存
        Cache::forget(Program::INDEX_CACHE_KEY);

        // 刷新贡献记录页文件缓存
        Cache::forget(Comment::CONTRIBUTION_CACHE_KEY);
    }

}
