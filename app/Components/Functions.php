<?php

declare(strict_types=1);

use Hyperf\Server\ServerFactory;
use Hyperf\Utils\ApplicationContext;

if (!function_exists('di')) {
    /**
     * 获取容器
     *
     * @param  string|null  $id
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
     * 检测环境是否为生产环境
     *
     * @return bool
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
    function server(): \Swoole\Server|\Swoole\Coroutine\Server
    {
        return di()->get(ServerFactory::class)->getServer()->getServer();
    }
}

if (!function_exists('event_dispatch')) {
    /**
     * 触发事件.
     *
     * @param  \App\Contract\EventInterface  $event
     * @return object|null
     */
    function event_dispatch(\App\Contract\EventInterface $event): ?object
    {
        $eventDispatcher = di()->get(\Psr\EventDispatcher\EventDispatcherInterface::class);
        $eventDispatcher->dispatch($event);
        return $eventDispatcher;
    }
}

if (!function_exists('queue_push')) {
    /**
     * 任务投递
     *
     * @param  \Hyperf\AsyncQueue\JobInterface  $job
     * @param  int  $delay
     * @param  string  $key
     * @return bool
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

