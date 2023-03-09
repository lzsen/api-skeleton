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

namespace App\Components\Http;

use App\Constants\ApiCodeConstant;
use Hyperf\HttpServer\Response as AbstractResponse;
use Psr\Http\Message\ResponseInterface;

class Response extends AbstractResponse
{
    /**
     * api接口响应.
     */
    public function success(mixed $data = null, string $message = 'success'): ResponseInterface
    {
        $response = [
            'code'    => ApiCodeConstant::SUCCESS,
            'message' => $message ?? ApiCodeConstant::getMessage(ApiCodeConstant::SUCCESS),
            'data'    => $data,
        ];

        return $this->json($response);
    }

    /**
     * api接口响应.
     */
    public function error(int $code = 0, string $message = 'error', mixed $data = null): ResponseInterface
    {
        $response = [
            'code'    => $code ?? 0,
            'message' => $message ?? 'error',
            'data'    => $data,
        ];
        return $this->json($response);
    }
}
