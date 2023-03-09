<?php

namespace App\Components;

class Jwt
{
    // 加密类型
    protected array $algConf = [
        'HS256' => 'sha256',
        'HS384' => 'sha384',
        'HS512' => 'sha512',
    ];

    // 加密类型
    protected string $alg;

    // 该JWT的签发者
    protected string $iss;

    // 密钥
    protected string $secret;

    // 过期时间
    protected int $exp = 2592000;

    public function __construct()
    {
        $this->exp    = config('app.jwt.exp', 86400 * 30);
        $this->secret = config('app.jwt.secret', '');
        $this->iss    = config('app.jwt.iss', 'iss');
        $this->alg    = config('app.jwt.alg', 'HS256');
    }

    /**
     * 生成JWT token.
     *
     * @param  array  $data
     * @return string
     */
    public function createToken(array $data): string
    {
        $payload         = $this->createPayload($data);
        $header          = [
            'alg' => $this->alg, // 生成签名的算法
            'typ' => 'JWT',
        ];
        $base64Header    = $this->base64UrlEncode(json_encode($header, JSON_UNESCAPED_UNICODE));
        $base64Payload   = $this->base64UrlEncode(json_encode($payload, JSON_UNESCAPED_UNICODE));
        $base64Signature = $this->signature(
            $base64Header . '.' . $base64Payload,
            $this->secret,
            $header['alg']
        );
        return $base64Header . '.' . $base64Payload . '.' . $base64Signature;
    }

    /**
     * 验证token是否有效,默认验证exp,nbf,iat时间.
     *
     * @param  string  $Token
     * @return mixed
     */
    public function verifyToken(string $Token): mixed
    {
        $tokens = explode('.', $Token);
        if (count($tokens) != 3) {
            return false;
        }
        [$base64Header, $base64payload, $sign] = $tokens;
        // 获取jwt算法
        $header = json_decode($this->base64UrlDecode($base64Header), true);
        if (empty($header['alg'])) {
            $header['alg'] = $this->alg;
        }
        // 签名验证
        if ($this->signature($base64Header . '.' . $base64payload, $this->secret, $header['alg']) !== $sign) {
            return false;
        }
        // 获得内容
        $payload = json_decode($this->base64UrlDecode($base64payload), true);

        // 签发时间大于当前服务器时间验证失败
        if (isset($payload['iat']) && $payload['iat'] > time()) {
            return false;
        }

        // 过期时间小宇当前服务器时间验证失败
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return false;
        }

        // 该nbf时间之前不接收处理该Token
        if (isset($payload['nbf']) && $payload['nbf'] > time()) {
            return false;
        }

        return $payload;
    }

    /**
     * base64UrlEncode   https://jwt.io/  中base64UrlEncode编码实现.
     *
     * @param  string  $input
     * @return string
     */
    private function base64UrlEncode(string $input): string
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    /**
     * base64UrlEncode  https://jwt.io/  中base64UrlEncode解码实现.
     *
     * @param  string  $input
     * @return bool|string
     */
    private function base64UrlDecode(string $input): bool|string
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $addLen = 4 - $remainder;
            $input  .= str_repeat('=', $addLen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }

    /**
     * HMACSHA256签名   https://jwt.io/  中HMACSHA256签名实现.
     *
     * @param  string  $input  为base64UrlEncode(header).".".base64UrlEncode(payload)
     * @param  string  $alg  算法方式
     */
    private function signature(string $input, string $key, string $alg = 'HS256'): string
    {
        return $this->base64UrlEncode(hash_hmac($this->algConf[$alg], $input, $key, true));
    }

    /**
     * 创建载荷.
     *
     * @param  array  $data
     * @return array
     */
    private function createPayload(array $data): array
    {
        $time  = time();
        $jti   = md5(uniqid('JWT') . sprintf('%.8f', microtime(true)));
        $exp   = $time + $this->exp;
        $token = [
            'iss' => $this->iss, // 该JWT的签发者
            'iat' => $time,  // 签发时间
            'exp' => $exp, // 过期时间
            'nbf' => $time, // 该时间之前不接收处理该Token
            'jti' => $jti, // 该Token唯一标识
        ];
        return array_merge($data, $token);
    }
}