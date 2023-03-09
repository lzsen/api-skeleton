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
return [
    'jwt'     => [
        // 加密类型 HS256,HS384,HS512
        'alg'    => 'HS256',
        // 该JWT的签发者
        'iss'    => 'iss',
        // 过期时间
        'exp'    => 30 * 86400,
        // 密钥 使用HMAC生成信息摘要时所使用的密钥
        'secret' => env('JWT_SECRET', ''),
    ],
    // 加密
    'encrypt' => [
        'db'        => [
            'aes' => [
                'enable' => env('ENCRYPT_DB_AES_ENABLE', false),
                'key'    => env('ENCRYPT_DB_AES_KEY', ''),
                'iv'     => env('ENCRYPT_DB_AES_IV', ''),
            ],
            'rc4' => [
                'enable' => env('ENCRYPT_DB_RC4_ENABLE', false),
                'key'    => env('ENCRYPT_DB_RC4_ENABLE', ''),
            ],
        ],
        'api'       => [
            'aes' => [
                'enable' => env('ENCRYPT_API_AES_ENABLE', false),
                'key'    => env('ENCRYPT_API_AES_KEY', ''),
                'iv'     => env('ENCRYPT_API_AES_IV', ''),
            ],
            'rc4' => [
                'enable' => env('ENCRYPT_API_RC4_ENABLE', false),
                'key'    => env('ENCRYPT_API_RC4_ENABLE', ''),
            ],
        ],
        'websocket' => [
            'aes' => [
                'enable' => env('ENCRYPT_WEBSOCKET_AES_ENABLE', false),
                'key'    => env('ENCRYPT_WEBSOCKET_AES_KEY', ''),
                'iv'     => env('ENCRYPT_WEBSOCKET_AES_IV', ''),
            ],
            'rc4' => [
                'enable' => env('ENCRYPT_WEBSOCKET_RC4_ENABLE', false),
                'key'    => env('ENCRYPT_WEBSOCKET_RC4_ENABLE', ''),
            ],

        ],
    ],
];
