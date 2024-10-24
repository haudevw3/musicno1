<?php

namespace Core\Jwt;

class Base64Url
{
    /**
     * Token encoded with the given data.
     *
     * @param  string  $data
     * @return string
     */
    public static function encode(string $data)
    {
        $encode = base64_encode($data);
        $encode = strtr($encode, '+/', '-_');
        $encode = rtrim($encode, '=');

        return $encode;
    }

    /**
     * Token decoded with the given data.
     *
     * @param  string  $data
     * @return string
     */
    public static function decode(string $data)
    {
        $decode = strtr($data, '-_', '+/');
        $decode = str_pad($decode, strlen($data) % 4, '=');
        $decode = base64_decode($decode);
        
        return $decode;
    }
}