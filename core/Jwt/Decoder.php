<?php

namespace Core\Jwt;

use Core\Jwt\Exceptions\InvalidStructureException;

class Decoder
{
    /**
     * @var array
     */
    protected $header;

    /**
     * @var array
     */
    protected $payload;

    /**
     * @var string
     */
    protected $signature;

    /**
     * Create a new decoder instance.
     *
     * @param  array   $header
     * @param  array   $payload
     * @param  string  signature
     * @return void
     */
    public function __construct(array $header, array $payload, string $signature)
    {
        $this->header = $header;
        $this->payload = $payload;
        $this->signature = $signature;
    }

    /**
     * Create a new decoder instance.
     *
     * @param  string  $token
     * @return $this
     * 
     * @throws \Core\Jwt\Exceptions\InvalidStructureException
     */
    public static function make(string $token)
    {
        $tokens = static::parseToken($token);

        list($header, $payload, $signature) = $tokens;
        
        return new self($header, $payload, $signature);
    }

    /**
     * Parse the given token structure.
     *
     * @param  string  $token
     * @return array
     * 
     * @throws \Core\Jwt\Exceptions\InvalidStructureException
     */
    protected static function parseToken(string $token)
    {
        $tokens = explode('.', $token);

        if (count($tokens) !== 3) {
            throw new InvalidStructureException('The invalid structure of the token.');
        }

        list($header, $payload, $signature) = $tokens;

        $header = json_decode(Base64Url::decode($header), true);
        $payload = json_decode(Base64Url::decode($payload), true);

        if (is_null($header)) {
            throw new InvalidStructureException('The invalid [header] structure of the token.');
        }

        if (is_null($payload)) {
            throw new InvalidStructureException('The invalid [payload] structure of the token.');
        }

        return [$header, $payload, $signature];
    }

    /**
     * Compare the token with the data encoded.
     *
     * @param  \Core\Jwt\Encoder|null  $encoder
     * @return bool
     */
    public function equals(Encoder $encoder = null)
    {
        $encoder = $encoder ?? Jwt::encode(
            $this->payload, $this->header
        )->hash();

        return hash_equals($encoder->signature(), $this->signature);
    }

    /**
     * Determine if the token time expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return (time() > $this->payload('exp')) ? true : false;
    }

    /**
     * Get the header with the given key if it has.
     * 
     * @param  string  $key
     * @return array
     */
    public function header($key = null)
    {
        return is_null($key) ? $this->header : $this->header[$key];
    }
    
    /**
     * Get the data with the given key if it has.
     * 
     * @param  string  $key
     * @return array|string
     */
    public function payload($key = null)
    {
        return is_null($key) ? $this->payload : $this->payload[$key];
    }

    /**
     * Get the signature.
     * 
     * @return string
     */
    public function signature()
    {
        return $this->signature;
    }
}