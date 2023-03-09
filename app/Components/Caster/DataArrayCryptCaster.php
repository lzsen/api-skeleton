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
 * 数组数据加密.
 */
class DataArrayCryptCaster implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        $value = app_aes_decrypt($value, 'db');
        return json_decode($value, true);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return app_aes_encrypt($value, 'db');
    }
}
