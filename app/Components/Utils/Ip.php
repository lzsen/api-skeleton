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
 * Ip类.
 */
class Ip
{
    public static function getClientIp()
    {
        $request = ApplicationContext::getContainer()->get(RequestInterface::class);
        $headerParams = $request->getHeaders();
        if (isset($headerParams['http_client_ip'])) {
            return $headerParams['http_client_ip'][0];
        }
        if (isset($headerParams['x-real-ip'])) {
            return $headerParams['x-real-ip'][0];
        }
        if (isset($headerParams['x-forwarded-for'])) {
            // 部分CDN会获取多层代理IP，所以转成数组取第一个值
            $data = explode(',', $headerParams['x-forwarded-for'][0]);
            return $data[0];
        }
        if (isset($headerParams['http_x_forwarded_for'])) {
            // 部分CDN会获取多层代理IP，所以转成数组取第一个值
            $data = explode(',', $headerParams['http_x_forwarded_for'][0]);
            return $data[0];
        }
        $serverParams = $request->getServerParams();
        return $serverParams['remote_addr'] ?? '';
    }

    /**
     * 是否为IP.
     */
    public static function isIP(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP);
    }

    /**
     * 是否为IPv4.
     */
    public static function isIPv4(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    /**
     * 是否为IPv6.
     */
    public static function isIPv6(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }
}
