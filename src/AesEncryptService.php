<?php

namespace DiagVN\Encrypt;

class AesEncryptService implements EncryptInterface
{
    private static $key;
    private static $iv;
    private static $method;

    public function __construct()
    {
        self::$key = config('encrypt.aes_key');
        self::$iv = config('encrypt.aes_iv');
        self::$method = config('encrypt.aes_method');
    }

    public static function decode($secret): string
    {
        $padwith = '~';
        $fixed_secret = str_replace(['-', '_'], ['+', '/'], $secret);
        $hashKey = substr(hash('sha256', self::$key), 0, 32);
        $iv_len = openssl_cipher_iv_length(self::$method);
        $iv_hash = substr(hash('sha256', self::$iv), 0, $iv_len);

        $decrypted_secret = openssl_decrypt($fixed_secret, self::$method, $hashKey, OPENSSL_ZERO_PADDING, $iv_hash);
        return preg_replace('~[.[:cntrl:][:space:]]~', '', rtrim($decrypted_secret, $padwith));
    }

    public static function encode($string): string
    {
        // hash
        $key = hash('sha256', self::$key);
        $iv = substr(hash('sha256', self::$iv), 0, 16);
        $output = openssl_encrypt($string, self::$method, $key, 0, $iv);
        return str_replace(['+', '/'], ['-', '_'], $output);
    }
}
