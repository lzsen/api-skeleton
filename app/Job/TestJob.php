<?php

declare(strict_types=1);

namespace App\Job;

use App\Components\Log;
use Hyperf\AsyncQueue\Job;

class TestJob extends Job
{
    public function __construct(public array $params)
    {
    }

    public function handle()
    {
        Log::queue()->info('队列执行');
    }
}
