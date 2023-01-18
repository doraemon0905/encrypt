<?php

namespace DiagVN\Encrypt;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Base32\Base32;

class JwtEncryptService implements EncryptInterface
{
    public static function encode($payload): string
    {
        return Base32::encode(
            JWT::encode(
                payload: $payload,
                key    : file_get_contents(config('encrypt.private_key')),
                alg    : 'HS256'
            )
        );
    }

    public static function decode($hashToDecode): object
    {
        $key = file_get_contents(config('encrypt.private_key'));

        return JWT::decode(
            Base32::decode($hashToDecode),
            new Key($key, 'HS256')
        );
    }
}
