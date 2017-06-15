<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Disqus 评论模型
 *
 * @author popfeng <popfeng@yeah.net> 2017-06-15
 */
class Comment extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 状态集合
     *
     * @const array
     */
    const STATUS = [
        'DISABLE' => -1,
        'DEFAULT' => 0,
        'ENABLE'  => 1,
    ];

    /**
     * 贡献记录页缓存KEY
     *
     * @const string
     */
    const CONTRIBUTION_CACHE_KEY = 'about_contribution_html';

    /**
     * Scope a query to only include contributed programs.
     *
     * @param string $programDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeContributed($query, $programDate = null)
    {
        $query->where(function ($query) {
            $query->orWhere('has_topic', self::STATUS['ENABLE']);
            $query->orWhere('has_participant', self::STATUS['ENABLE']);
        });
        if ($programDate) {
            $query->where('program_date', $programDate);
        }
        return $query;
    }

    /**
     * 导入评论
     *
     * @param array $comment
     * @param array $signs
     * @return int
     */
    public static function import($comment, $signs)
    {
        // 查询是否存在
        $record = static::where('cmt_id', $comment->id)->first();
        if ( ! empty($record)) {
            return $record->id;
        }

        // 新增
        preg_match('/program\/([0-9]+)/', $comment->thread->link, $matches);
        $programDate = $matches[1] ?? 0;

        $data = [
            'program_date'    => $programDate,
            'message'         => $comment->raw_message,
            'author_name'     => $comment->author->name,
            'author_url'      => $comment->author->url,
            'cmt_id'          => $comment->id,
            'cmt_url'         => $comment->url,
            'cmt_created_at'  => $comment->createdAt,
            'created_at'      => date('Y-m-d H:i:s')
        ];

        if (isset($signs['TOPIC'])) {
            $data['has_topic'] = self::STATUS['ENABLE'];
        }
        if (isset($signs['PARTICIPANT'])) {
            $data['has_participant'] = self::STATUS['ENABLE'];
        }

        return static::insertGetId($data);
    }

}
