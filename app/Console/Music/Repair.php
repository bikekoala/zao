<?php

namespace App\Console\Music;

use App\Console\Command;
use Artisan, DB;

/**
 * 修复音乐脚本
 * 临时脚本
 *
 * @author popfeng <popfeng@yeah.net> 2016-07-04
 */
class Repair extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xmusic:repair {outer_width} {inner_width}';

    /**
     * The console command description.
     * 匹配模式示例: 1:1 = aba, 1:2 = abba
     *
     * @var string
     */
    protected $description = '修复音乐命令（外部宽度 内部宽度）';

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
        $outerWidth = max(1, (int) $this->argument('outer_width'));
        $innerWidth = max(1, (int) $this->argument('inner_width'));

        $table = 'tmp_musics';
        $space = [];
        $spaceLength = $outerWidth * 2 + $innerWidth;
        $dataKey = 'title';
        $counter = 0;

        DB::table($table)
            ->select('id', 'path', 'program_date', 'audio_part', 'audio_start_sec', 'title')
            ->chunk(10000, function($data) use(
                &$space,
                $spaceLength,
                $outerWidth, 
                $innerWidth,
                $dataKey,
                &$counter
        ){
            for ($i = 0, $l = count($data); $i < $l; $i++) {
                // 向寄存器内存入第一条数据
                if (0 === $i) {
                    self::register($space, (array) $data[$i], $spaceLength);
                }
                // 向寄存器内存入下一条数据
                if (isset($data[$i + 1])) {
                    self::register($space, (array) $data[$i + 1], $spaceLength);
                }

                // 检查寄存器是否存满
                if (empty($space[$spaceLength - 1])) {
                    continue;
                }

                // 检查寄存器中间数据是否相同
                $middleSpace = array_slice($space, $outerWidth, $innerWidth);
                if ( ! self::compareSpaceItem($middleSpace, $dataKey, false)) {
                    continue;
                }

                // 检查寄存器左右两侧数据是否相同
                $leftSpace = array_slice($space, 0, $outerWidth);
                $rightSpace = array_slice($space, $outerWidth + $innerWidth, $outerWidth);
                $bilateralSpace = array_merge($leftSpace, $rightSpace);
                if ( ! self::compareSpaceItem($bilateralSpace, $dataKey)) {
                    continue;
                }

                // 抽样检查寄存器两侧与中间数据是否相同
                if ($leftSpace[0][$dataKey] === $middleSpace[0][$dataKey]) {
                    continue;
                }

                // 将寄存器中间数据修复到与两侧一致
                foreach ($space as $item) {
                    echo implode("\t", $item), PHP_EOL;
                }
                foreach ($middleSpace as $item) {
                    Artisan::call('xmusic:copy', [
                        'from_id' => $leftSpace[0]['id'],
                        'to_id'   => $item['id']
                    ]);
                }

                echo ++$counter, PHP_EOL, PHP_EOL;
            }
        });

        $this->info('done.');
    }

    /**
     * 固定长度寄存器
     *
     * @param array $space
     * @param mixed $value
     * @param int $length
     * @return void
     */
    private static function register(&$space, $value, $length)
    {
        $space[] = $value;

        if (isset($space[$length])) {
            array_shift($space);
        }
        $space = array_values($space);
    }

    /**
     * 比较二维数组内的数据的值是否相同
     *
     * @param array $space
     * @param mixed $itemField
     * @param bool $isStrict
     * @return bool
     */
    private static function compareSpaceItem(
        &$space,
        &$itemField,
        $isStrict = true
    ) {
        $result = array_flip(array_column($space, $itemField));
        if (1 === count($result)) {
            if ($isStrict) {
                return ! isset($result['']);
            } else return true;
        } else return false;
    }
}
