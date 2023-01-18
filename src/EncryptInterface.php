<?php

namespace DiagVN\Encrypt;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Base32\Base32;

interface EncryptInterface
{
    public static function encode($i): string;

    public static function decode($code);
}
