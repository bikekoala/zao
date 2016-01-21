<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * 更新Bing封图
 *
 * @author popfeng <popfeng@yeah.net> 2016-01-21
 */
class UpdateBingCover extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xprogram:update-bing-cover';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新 Bing 封图';

    /**
     * The bing cover story API.
     *
     * @var string
     */
    protected $api = 'http://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1';

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
        if ($image = $this->getImage()) {
            $paths = $this->getFilePaths();
            if (is_file($paths['default'])) {
                rename($paths['default'], $paths['archive']);
            }

            file_put_contents($paths['default'], $image);

            $this->info('Success.');
        } else {
            $this->error('Get Bing-cover failed.');
        }
    }

    /**
     * 获取Bing图片文件
     *
     * @return string
     */
    private function getImage()
    {
        $info = json_decode(file_get_contents($this->api), true);
        return file_get_contents($info['images'][0]['url']);
    }

    /**
     * 获取文件地址列表
     *
     * @return array
     */
    private function getFilePaths()
    {
        $basePath = public_path() . '/static/img/cover';
        $archivePath = $basePath . '/archive';

        return [
            'default' => $basePath . '/default.png',
            'archive' => sprintf(
                '%s/%s.png',
                $archivePath,
                date('Y-m-d', strtotime('-1 day'))
            )
        ];
    }
}
