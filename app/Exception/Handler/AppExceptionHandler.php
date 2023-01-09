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

namespace App\Exception\Handler;

use App\Components\Log;
use App\Constants\StatusCode;
use App\Exception\BusinessException;
use Hyperf\Context\Context;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Exception\HttpException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{

    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        // HTTP 错误
        if ($throwable instanceof HttpException) {
            $this->stopPropagation();
            // 记录日志
            $this->addLogger($throwable);
            return $this->responseApiMessage($throwable->getStatusCode(), $throwable->getMessage());
        }
        // 业务错误
        if ($throwable instanceof BusinessException) {
            $this->stopPropagation();
            return $this->responseApiMessage($throwable->getCode(), $throwable->getMessage());
        }

        // 验证器
        if ($throwable instanceof ValidationException) {
            $this->stopPropagation();
            $errors = $throwable->validator->errors()->first();
            if (is_numeric($errors)) {
                $errors = (int) $errors;
                return $this->responseApiMessage($errors, StatusCode::getMessage($errors));
            }
            return $this->responseApiMessage(40100, $errors);
        }

        // 记录日志
        $this->addLogger($throwable, false);
        // 其它错误
        return $this->responseApiMessage(StatusCode::ERR_SERVER);
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }

    /**
     * 响应输出
     *
     * @param  int  $code
     * @param  string|null  $message
     * @param  mixed|null  $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function responseApiMessage(int $code = 0, string $message = null, mixed $data = null): ResponseInterface
    {
        if (is_null($message)) {
            $message = StatusCode::getMessage($code);
        }
        $responseData = [
            'code'    => $code ?? 0,
            'message' => $message ?? 'error',
            'data'    => $data,
        ];
        $responseData = Json::encode($responseData);
        /** @var ResponseInterface $response */
        $response = Context::get(ResponseInterface::class);
        return $response->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withAddedHeader('Server', 'gws')
            ->withBody(new SwooleStream($responseData));
    }

    /**
     * 记录日志.
     */
    protected function addLogger(Throwable $throwable, bool $isTrace = false)
    {
        Log::runtime()->error(sprintf(
            '[code:%s] %s in %s[line:%s]',
            $throwable->getCode(),
            $throwable->getMessage(),
            $throwable->getFile(),
            $throwable->getLine()
        ));
        if ($isTrace) {
            Log::runtime()->error($throwable->getTraceAsString());
        }
    }
}
