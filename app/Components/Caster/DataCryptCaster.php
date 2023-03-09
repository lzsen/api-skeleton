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

namespace App\Components\Caster;

use Hyperf\Contract\CastsAttributes;

/**
 * 字符串、数字 数据加密.
 */
class DataCryptCaster implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return app_aes_decrypt($value, 'db') ?? $value;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return app_aes_encrypt($value, 'db');
    }
}
