<?php

namespace App\Components\Utils;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\ApplicationContext;

/**
 * header
 *
 * @author lzsen
 * @package App\Components\Utils
 */
class Header
{

    /**
     * 获取UserAgent
     *
     * @return static
     */
    public static function getUserAgent(): static
    {
        $request = ApplicationContext::getContainer()->get(RequestInterface::class);
        return $request->getHeaders('user-agent')[0] ?? '';
    }


}