<?php

namespace DiagVN\Encrypt;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Base32\Base32;

class EncryptService implements EncryptInterface
{
    /** @var string */
    private static $keychars = 'CZPXD5H2FIWB81KE76JY93V4ORLAMT0QSUNG'; // Dictionary of allowed unique symbols, shuffle it for yourself or remove unwanted chars (don't forget to call testParameters after changing)

    /** @var int */
    private static $divider = 19; // Tune divider for yourself (don't forget to call testParameters after changing)

    /** @var int */
    private static $biasDivider = 14; // Tune bias divider for yourself (don't forget to call testParameters after changing)

    /** @var int */
    private static $noise = 53; // Any positive number

    /**
     * @param integer $i
     * @return string
     */
    public static function encode($i): string
    {
        if ($i < 0) {
            throw new Exception('Expected positive integer');
        }

        $keychars = static::$keychars;
        $i = $i + static::$noise; // add noise to a number
        $bias = $i % static::$biasDivider;

        $res = '';

        while ($i > 0) {
            $div = $i % static::$divider;
            $i = intdiv($i, static::$divider);
            $res .= $keychars[$div + $bias];
        }

        // Current version of an algorithm is one of these chars (if in the future you will need to identify a version)
        // Remember this chars on migrating to a new algorithm/parameters
        $res .= str_shuffle('LPTKEZG')[0];
        $res .= $keychars[$bias]; // Encoded bias

        return $res;
    }

    /**
     * @param [type] $code
     * @return int
     */
    public static function decode($code): int
    {
        $keychars = static::$keychars;
        $biasC = substr($code, -1);
        $bias = strpos($keychars, $biasC);
        $code = substr($code, 0, -2);
        $code = str_split(strrev($code));

        $val = 0;

        foreach ($code as $c) {
            $val *= static::$divider;
            $val += strpos($keychars, $c) - $bias;
        }

        return $val - static::$noise;
    }
}
