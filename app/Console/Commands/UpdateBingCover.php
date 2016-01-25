<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * 更新Bing封图
 *
 * @host aws
 * @author popfeng <popfeng@yeah.net> 2016-01-21
 */
class UpdateBingCover extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xtool:update-bing-cover';

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
        $image = $this->getImage();
        $paths = $this->getFilePaths();
        if ( ! is_file($paths['archive'])) {
            if ($image = $this->getImage()) {
                file_put_contents($paths['archive'], $image);
            } else {
                $this->error('Get Bing-cover failed.');
            }
        }

        is_link($paths['default']) and unlink($paths['default']);
        symlink($paths['archive'], $paths['default']);

        $this->info('Success.');
    }

    /**
     * 获取Bing图片文件
     *
     * @return string
     */
    private function getImage()
    {
        $info = json_decode(file_get_contents($this->api), true);
        $url = $info['images'][0]['url'];

        if ('http' !== substr($url, '0', 4)) {
            $url = 'http://www.bing.com' . $url;
        }

        return file_get_contents($url);
    }

    /**
     * 获取文件地址列表
     *
     * @return array
     */
    private function getFilePaths()
    {
        $basePath = public_path() . '/static/img/cover';

        return [
            'default' => $basePath . '/default.png',
            'archive' => sprintf('%s/%s.png', $basePath, date('Y-m-d'))
        ];
    }
}
