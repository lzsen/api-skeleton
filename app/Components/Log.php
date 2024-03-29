<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Components;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Utils\ApplicationContext;
use Psr\Log\LoggerInterface;

/**
 * @method static LoggerInterface hyperf(string $group = 'default')
 * @method static LoggerInterface runtime(string $group = 'default')
 * @method static LoggerInterface business(string $group = 'default')
 * @method static LoggerInterface queue(string $group = 'default')
 * @method static LoggerInterface event(string $group = 'default')
 * @method static LoggerInterface sql(string $group = 'default')
 */
class Log
{
    /**
     * 获取日志实例
     */
    public static function __callStatic($name, $arguments): mixed
    {
        if (is_prod()) {
            $group = 'default';
            if (count($arguments) > 0) {
                $group = $arguments[0];
            }
            // 第三方实现的
            return ApplicationContext::getContainer()->get(LoggerFactory::class)->get($name, $group);
        }
        // 框架实现的
        return ApplicationContext::getContainer()->get(StdoutLoggerInterface::class);
    }
}
