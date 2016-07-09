<?PHP
/**
 * 自定义函数
 */

/**
 * 秒数转时间
 *
 * @param int $seconds
 * @return string
 */
function seconds_to_time($seconds) {
    $hours = (int) ($seconds / 3600);
    if ($hours) {
        return gmstrftime('%H:%M:%S', $seconds);
    } else {
        return gmstrftime('%M:%S', $seconds);
    }
}

/**
 * 节目时段标题
 *
 * @param string $part
 * @return string
 */
function program_part_title($part) {
    $titles = [
        'a'   => '第一时段',
        'b'   => '第二时段',
        'c'   => '第三时段',
        'all' => '完整时段'
    ];
    return isset($titles[$part]) ? $titles[$part] : '';
}

/**
 * 七牛URL
 *
 * @param string $path
 * @return string
 */
function qiniu_url($path) {
    return sprintf(
        'http://%s%s',
        Config::get('filesystems.disks.qiniu.domain'),
        $path
    );
}
