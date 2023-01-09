<?php

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
     *
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return array
     */
    public function validate(array $rules, array $messages = [], array $customAttributes = []): array
    {
        $data              = $this->all();
        $files             = $this->getUploadedFiles();
        $data              = array_merge($data, $files);
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