<?php

namespace Core\Jwt;

class Jwt
{
    /**
     * Create a new encoder instance.
     *
     * @param  array        $payload
     * @param  array        $header
     * @param  string|null  $key
     * @return \Core\Jwt\Encoder
     */
    public static function encode(array $payload, array $header = [], $key = null)
    {
        return Encoder::make($payload, $header, $key);
    }

    /**
     * Create a new decoder instance.
     *
     * @param  string  $token
     * @return \Core\Jwt\Decoder
     */
    public static function decode(string $token)
    {
        return Decoder::make($token);
    }
}