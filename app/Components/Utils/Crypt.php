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

use Exception;
use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\RC4;

class Crypt
{
    /**
     *  cr4 加密.
     *
     * @return null|string
     */
    public static function rc4_encode(?string $string, string $key): ?string
    {
        if (is_null($string)) {
            return null;
        }
        try {
            $cr4 = new RC4();
            $cr4->setKey($key);
            $result = $cr4->encrypt($string);
            $result = base64_encode($result);
        } catch (Exception) {
            $result = null;
        } finally {
            return $result;
        }
    }

    /**
     * cr4 解密.
     *
     * @return null|string
     */
    public static function rc4_decode(?string $string, string $key): ?string
    {
        if (is_null($string)) {
            return null;
        }
        try {
            $cr4 = new RC4();
            $cr4->setKey($key);
            $result = base64_decode($string);
            $result = $cr4->decrypt($result);
        } catch (Exception) {
            $result = null;
        } finally {
            return $result;
        }
    }

    /**
     * aes 加密.
     *
     * @return null|string
     */
    public static function aes_encrypt(?string $string, string $iv, string $key, string $type = 'cbc'): ?string
    {
        if (is_null($string)) {
            return null;
        }
        try {
            $aes = new AES($type);
            $aes->setIV($iv);
            $aes->setKey($key);
            $result = $aes->encrypt($string);
            $result = base64_encode($result);
        } catch (Exception) {
            $result = null;
        } finally {
            return $result;
        }
    }

    /**
     * aes 解密.
     *
     * @return null|string
     */
    public static function aes_decrypt(?string $string, string $iv, string $key, string $type = 'cbc'): ?string
    {
        if (is_null($string)) {
            return null;
        }
        try {
            $aes = new AES($type);
            $aes->setIV($iv);
            $aes->setKey($key);
            $result = base64_decode($string);
            $result = $aes->decrypt($result);
        } catch (Exception) {
            $result = null;
        } finally {
            return $result;
        }
    }
}
