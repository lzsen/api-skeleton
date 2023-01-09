<?php

declare(strict_types=1);

namespace App\Listener;

use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Validation\Event\ValidatorFactoryResolved;

/**
 * 自定义验证规则.
 */
#[Listener]
class ValidatorFactoryResolvedListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            ValidatorFactoryResolved::class,
        ];
    }

    /**
     *
     * @param  ValidatorFactoryResolved  $event
     */
    public function process(object $event): void
    {
        $validatorFactory = $event->validatorFactory;

        // hash格式验证
        $validatorFactory->extend('hash', function ($attribute, $value, $parameters, $validator) {
            switch ($parameters[0]) {
                case '16':
                case '32':
                case '40':
                case '64':
                    $match = '/^[a-fA-F\d]{' . $parameters[0] . '}$/';
                    break;
                default:
                    return false;
            }
            return (bool) preg_match($match, $value);
        });
    }
}
