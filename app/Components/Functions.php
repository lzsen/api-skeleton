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

use Hyperf\Server\ServerFactory;
use Hyperf\Utils\ApplicationContext;

if (!function_exists('di')) {
    /**
     * 获取容器.
     *
     * @return mixed|\Psr\Container\ContainerInterface
     */
    function di(?string $id = null): mixed
    {
        $container = ApplicationContext::getContainer();
        if (!is_null($id)) {
            return $container->get($id);
        }
        return $container;
    }
}

if (!function_exists('is_prod')) {
    /**
     * 检测环境是否为生产环境.
     */
    function is_prod(): bool
    {
        return config('app_env') == 'prod';
    }
}

if (!function_exists('server')) {
    /**
     * 获取Server.
     *
     * @return \Swoole\Coroutine\Server|\Swoole\Server
     */
    function server(): Swoole\Server|Swoole\Coroutine\Server
    {
        return di()->get(ServerFactory::class)->getServer()->getServer();
    }
}

if (!function_exists('event_dispatch')) {
    /**
     * 触发事件.
     *
     * @param  \App\Contract\EventInterface  $event
     */
    function event_dispatch(App\Contract\EventInterface $event): ?object
    {
        $eventDispatcher = di()->get(\Psr\EventDispatcher\EventDispatcherInterface::class);
        $eventDispatcher->dispatch($event);
        return $eventDispatcher;
    }
}

if (!function_exists('queue_push')) {
    /**
     * 任务投递.
     *
     * @param  \Hyperf\AsyncQueue\JobInterface  $job
     */
    function queue_push(Hyperf\AsyncQueue\JobInterface $job, int $delay = 0, string $key = 'default'): bool
    {
        $driver = di()->get(\Hyperf\AsyncQueue\Driver\DriverFactory::class)->get($key);
        return $driver->push($job, $delay);
    }
}

if (!function_exists('is_json')) {
    /**
     * 判断是否为json格式字符串.
     *
     * @param  string  $data  Json 字符串
     * @param  bool  $assoc  是否返回关联数组。默认返回对组
     * @return array|bool|object 成功返回转换后的对象或数组，失败返回 false
     */
    function is_json(string $data = '', bool $assoc = true): array|bool|object
    {
        if (PHP_VERSION > 5.3) {
            json_decode($data);
            return json_last_error() == JSON_ERROR_NONE;
        }
        $data = json_decode($data, $assoc);
        if (($data && is_object($data)) || (is_array($data) && !empty($data))) {
            return $data;
        }
        return false;
    }
}

if (!function_exists('is_utf8')) {
    /**
     * 判断是否为utf8字符串.
     */
    function is_utf8(string $string): bool
    {
        $len = strlen($string);
        for ($i = 0; $i < $len; ++$i) {
            $c = ord($string[$i]);
            if ($c > 128) {
                if ($c > 247) {
                    return false;
                }
                if ($c > 239) {
                    $bytes = 4;
                } elseif ($c > 223) {
                    $bytes = 3;
                } elseif ($c > 191) {
                    $bytes = 2;
                } else {
                    return false;
                }
                if (($i + $bytes) > $len) {
                    return false;
                }
                while ($bytes > 1) {
                    ++$i;
                    $b = ord($string[$i]);
                    if ($b < 128 || $b > 191) {
                        return false;
                    }
                    --$bytes;
                }
            }
        }
        return true;
    }
}

if (!function_exists('app_aes_encrypt')) {
    /**
     * aes 加密
     *
     * @param  string  $string
     * @param  string  $type
     * @return string|null
     */
    function app_aes_encrypt(string $string, string $type = 'api'): string|null
    {
        $configPrefix = 'app.encrypt.' . $type . '.aes';
        if (!config($configPrefix . '.enable', false)) {
            return $string;
        }
        $key = config($configPrefix . '.key');
        $iv  = config($configPrefix . '.iv');
        return \App\Components\Utils\Crypt::aes_encrypt(string: $string, iv: $iv, key: $key);
    }
}
if (!function_exists('app_aes_decrypt')) {
    /**
     * aes 解密
     *
     * @param  string  $string
     * @param  string  $type
     * @return string|null
     */
    function app_aes_decrypt(string $string, string $type = 'api'): string|null
    {
        $configPrefix = 'app.encrypt.' . $type . '.aes';
        if (!config($configPrefix . '.enable', false)) {
            return $string;
        }
        $key = config($configPrefix . '.key');
        $iv  = config($configPrefix . '.iv');
        return \App\Components\Utils\Crypt::aes_decrypt(string: $string, iv: $iv, key: $key);
    }
}

if (!function_exists('app_rc4_encrypt')) {
    /**
     * rc4 加密
     *
     * @param  string  $string
     * @param  string  $type
     * @return string|null
     */
    function app_rc4_encrypt(string $string, string $type = 'api'): string|null
    {
        $configPrefix = 'app.encrypt.' . $type . '.rc4';
        if (!config($configPrefix . '.enable', false)) {
            return $string;
        }
        $key = config($configPrefix . '.key');
        return \App\Components\Utils\Crypt::rc4_encode(string: $string, key: $key);
    }
}
if (!function_exists('app_rc4_decrypt')) {
    /**
     * rc4 解密
     *
     * @param  string  $string
     * @param  string  $type
     * @return string|null
     */
    function app_rc4_decrypt(string $string, string $type = 'api'): string|null
    {
        $configPrefix = 'app.encrypt.' . $type . '.rc4';
        if (!config($configPrefix . '.enable', false)) {
            return $string;
        }
        $key = config($configPrefix . '.key');
        return \App\Components\Utils\Crypt::rc4_decode(string: $string, key: $key);
    }
}
