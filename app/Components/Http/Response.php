<?php

namespace App\Components\Http;

use App\Constants\StatusCode;
use Hyperf\HttpServer\Response as AbstractResponse;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

class Response extends AbstractResponse
{

    public function __construct(protected ContainerInterface $container)
    {
    }

    /**
     * api接口响应
     *
     * @param  mixed|null  $data
     * @param  string  $message
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function success(mixed $data = null, string $message = 'success'): ResponseInterface
    {
        $response = [
            'code'    => StatusCode::SUCCESS,
            'message' => $message ?? StatusCode::getMessage(StatusCode::SUCCESS),
            'data'    => $data,
        ];

        return $this->json($response);
    }

    /**
     * api接口响应
     *
     * @param  int  $code
     * @param  string  $message
     * @param  mixed|null  $data
     * @return \Psr\Http\Message\ResponseInterface
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