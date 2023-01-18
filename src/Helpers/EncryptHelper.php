<?php

namespace DiagVN\Encrypt\Helpers;


use DiagVN\Encrypt\AesEncryptService;
use DiagVN\Encrypt\EncryptService;
use DiagVN\Encrypt\JwtEncryptService;
use Exception;

class EncryptHelper
{
    public static function decrypt($string): object|int|string|null
    {
        $result = null;
        try {
            $result = EncryptService::decode($string);
        } catch (Exception $e) {
            report($e);
        }

        if (!$result) {
            $result = self::decryptJwt($string);
        }

        if (!$result) {
            $result = self::decryptAes($string);
        }

        return $result;
    }

    private static function decryptJwt($string): ?object
    {
        $result = null;
        try {
            $result = JwtEncryptService::decode($string);
        } catch (Exception $e) {
            report($e);
        }
        return $result;
    }

    private static function decryptAes($string): ?string
    {
        $result = null;
        try {
            $result = AesEncryptService::decode($string);
        } catch (Exception $e) {
            report($e);
        }
        return $result;
    }
}
