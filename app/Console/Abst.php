<?php

namespace App\Console;

use Log;
use Illuminate\Console\Command;

/**
 * 命令抽象类
 *
 * @author popfeng <popfeng@yeah.net> 2016-01-26
 */
abstract class Abst extends Command
{
    /**
     * 输出错误信息，并记录日志
     *
     * @param string $message
     * @param bool $isExit
     * @return void
     */
    public function error($message, $isExit = true)
    {
        parent::error($message);
        Log::error($message, [__CLASS__]);

        if ($isExit) {
            exit;
        }
    }

    /**
     * 输出信息，并记录日志
     *
     * @param string $message
     * @param mixed $verbosity
     * @return void
     */
    public function info($message, $verbosity = NULL)
    {
        parent::info($message, $verbosity);
        Log::info($message, [__CLASS__]);
    }
}
