<?php

namespace App\Process;

use Hyperf\AsyncQueue\Process\ConsumerProcess;
use Hyperf\Process\Annotation\Process;

#[Process(name: 'AsyncQueueConsumer')]
class AsyncQueueConsumer extends ConsumerProcess
{

}