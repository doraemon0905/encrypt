<?php

namespace DiagVN\Encrypt;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Base32\Base32;

class JwtEncryptService
{
    public static function encryptKey(array $payload): string
    {
        return Base32::encode(
            JWT::encode(
                payload: $payload,
                key    : file_get_contents(config('encrypt.private_key')),
                alg    : 'HS256'
            )
        );
    }

    public static function decryptKey(string $hashToDecode): object
    {
        $key = file_get_contents(config('encrypt.private_key'));

        return JWT::decode(
            Base32::decode($hashToDecode),
            new Key($key, 'HS256')
        );
    }
}
