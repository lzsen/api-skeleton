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

namespace App\Process;

use App\Components\Log;
use Hyperf\AsyncQueue\Process\ConsumerProcess;
use Hyperf\Process\Annotation\Process;
use Hyperf\Redis\Exception\InvalidRedisProxyException;
use Hyperf\Redis\RedisFactory;

#[Process(name: 'AsyncQueueConsumer')]
class AsyncQueueConsumer extends ConsumerProcess
{
    public function handle(): void
    {
        try {
            $redis = $this->container->get(RedisFactory::class)->get($this->config['redis']['pool'] ?? 'default');
            $redis->ping();
            parent::handle(); // $this->driver->consume();
        } catch (InvalidRedisProxyException $e) {
            Log::queue()->error(sprintf('[AsyncQueueConsumer]:%s', 'redis 配置不正确'));
        } catch (\Throwable $e) {
            Log::queue()->error(sprintf('[AsyncQueueConsumer]:%s', $e->getMessage()));
        }

    }

}
