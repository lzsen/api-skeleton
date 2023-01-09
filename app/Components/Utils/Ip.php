<?php

namespace App\Components\Utils;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\ApplicationContext;

/**
 * Ip类
 *
 * @author lzsen
 * @package App\Components\Utils
 */
class Ip
{
    public static function getClientIp()
    {
        $request      = ApplicationContext::getContainer()->get(RequestInterface::class);
        $serverParams = $request->getServerParams();
        if (isset($serverParams['http_client_ip'])) {
            return $serverParams['http_client_ip'];
        }
        if (isset($serverParams['http_x_real_ip'])) {
            return $serverParams['http_x_real_ip'];
        }
        if (isset($serverParams['http_x_forwarded_for'])) {
            // 部分CDN会获取多层代理IP，所以转成数组取第一个值
            $data = explode(',', $serverParams['http_x_forwarded_for']);
            return $data[0];
        }
        return $serverParams['remote_addr'];
    }

    /**
     * 是否为IP
     *
     * @param  string  $ip
     * @return bool
     */
    public static function isIP(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP);
    }

    /**
     * 是否为IPv4
     *
     * @param  string  $ip
     * @return bool
     */
    public static function isIPv4(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    /**
     * 是否为IPv6
     *
     * @param  string  $ip
     * @return bool
     */
    public static function isIPv6(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }

}