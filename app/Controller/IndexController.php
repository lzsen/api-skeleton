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

namespace App\Controller;

use App\Components\Log;
use App\Job\TestJob;
use App\Services\TestService;

class IndexController extends AbstractController
{

    public function index()
    {

        $user   = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();
        // queue_push(new TestJob(['asd']), 5);
        $this->container->get(TestService::class)->asd();
        Log::runtime()->info('完成投递');
        return [
            'method'  => $method,
            'message' => "Hello {$user}.",
        ];
    }

}
