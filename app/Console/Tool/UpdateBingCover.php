<?php

namespace App\Console\Tool;

use App\Console\Command;
use Cache, Imagick;

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
     * 文件路径
     *
     * @var array
     */
    protected $paths;

    /**
     * 封图信息 缓存KEY
     *
     * @var string
     */
    const COVER_CACHE_KEY = 'app_cover_info';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->paths = $this->getFilePaths();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $image = $this->getImageInfo();
        if ( ! $image) {
            return $this->error('Get Bing-cover failed.');
        }

        $this->saveOriginalImage($image['blob']);

        $this->saveThumbnailImage($image['blob'], 1390, 782);

        $this->createImageSymlink();

        $this->cacheImageInfo($image['info']);

        $this->info('Success.');
    }

    /**
     * 缓存图片信息
     *
     * @param array $info
     * @return bool
     */
    private function cacheImageInfo($info)
    {
        $data = [
            'original'  => strstr($this->paths['original'], 'public'),
            'copyright' => $info['copyright']
        ];

        return Cache::forever(self::COVER_CACHE_KEY, $data);
    }

    /**
     * 创建软连接
     *
     * @return bool
     */
    private function createImageSymlink()
    {
        if (is_link($this->paths['thumbnail_default'])) {
            unlink($this->paths['thumbnail_default']);
        }

        return symlink(
            $this->paths['thumbnail'],
            $this->paths['thumbnail_default']
        );
    }

    /**
     * 保存缩略图
     *
     * @param blob $image
     * @param int $width
     * @param int $height
     * @return bool
     */
    private function saveThumbnailImage($image, $width, $height, $quality = 0.85)
    {
        $im = new Imagick();
        $im->readImageBlob($image);
        $im->setInterlaceScheme(imagick::INTERLACE_PLANE);
        $im->resizeImage($width, $height, Imagick::FILTER_CATROM, 1, true);
        $im->setImageCompression(Imagick::COMPRESSION_JPEG);
        $im->setImageCompressionQuality($im->getImageCompressionQuality() * $quality);
        return $im->writeImage($this->paths['thumbnail']);
    }

    /**
     * 保存原始图片
     *
     * @param blob $image
     * @return bool
     */
    private function saveOriginalImage($image)
    {
        return (bool) file_put_contents($this->paths['original'], $image);
    }

    /**
     * 获取 Bing 图片文件信息
     *
     * @return array | false
     */
    private function getImageInfo()
    {
        $result = json_decode(file_get_contents($this->api), true);

        if ( ! empty($result['images'])) {
            $info = current($result['images']);

            if ('http' !== substr($info['url'], '0', 4)) {
                $info['url'] = 'http://www.bing.com' . $info['url'];
            }

            $blob = file_get_contents($info['url']);

            if ($blob) {
                return ['blob' => $blob, 'info' => $info];
            }
        }

        return false;
    }

    /**
     * 获取文件地址列表
     *
     * @return array
     */
    private function getFilePaths()
    {
        $basePath = public_path() . '/static/img/cover';
        $imageFile = date('Y-m-d') . '.jpg';

        return [
            'original'          => $basePath . '/original/' . $imageFile,
            'thumbnail'         => $basePath . '/thumbnail/' . $imageFile,
            'thumbnail_default' => $basePath . '/thumbnail/default.jpg'
        ];
    }
}
