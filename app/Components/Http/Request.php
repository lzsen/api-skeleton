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

use Hyperf\HttpServer\Request as AbstractRequest;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Psr\Container\ContainerInterface;

class Request extends AbstractRequest
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    /**
     * 验证
     */
    public function validate(array $rules, array $messages = [], array $customAttributes = []): array
    {
        $data = $this->all();
        $files = $this->getUploadedFiles();
        $data = array_merge($data, $files);
        $validationFactory = $this->container->get(ValidatorFactoryInterface::class);
        foreach ($messages as &$msg) {
            if (is_numeric($msg)) {
                $msg = (string) $msg;
            }
        }
        $validate = $validationFactory->make($data, $rules, $messages, $customAttributes);
        return $validate->validate();
    }
}
