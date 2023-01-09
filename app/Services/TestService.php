<?php

namespace App\Services;

use App\Components\Log;
use Hyperf\AsyncQueue\Annotation\AsyncQueueMessage;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Guzzle\ClientFactory;

class TestService
{
    #[Inject]
    protected ClientFactory $clientFactory;

    #[AsyncQueueMessage]
    public function asd(): void
    {
        Log::runtime()->info('开始执行' . date('Y-m-d H:i:s'));
        try {
            $data = $this->clientFactory->create()->get('https://www.google.com',
                ['timeout' => 3])->getBody()->getContents();
            Log::runtime()->info($data);
        } catch (\Throwable $e) {
            Log::runtime()->error($e->getMessage());
        }
        Log::runtime()->info('异步执行:' . date('Y-m-d H:i:s'));
    }

}