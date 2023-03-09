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

namespace App\Components\Utils;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\ApplicationContext;

/**
 * header.
 */
class Header
{
    /**
     * 获取UserAgent.
     */
    public static function getUserAgent()
    {
        $request = ApplicationContext::getContainer()->get(RequestInterface::class);
        return $request->getHeader('user-agent')[0] ?? '';
    }
}
