<?php

namespace Core\Jwt;

use Core\Constant;
use Core\Jwt\Exceptions\InvalidClaimTypeException;
use Core\Jwt\Exceptions\InvalidHeaderTypeException;
use Core\Jwt\Exceptions\UnsupportedAlgorithmException;
use Illuminate\Support\Arr;

class Encoder
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var array|string
     */
    protected $header;

    /**
     * @var array|string
     */
    protected $payload;

    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var array
     */
    protected $bindings;

    /**
     * Mapping of available algorithm keys with their types and target algorithms.
     *
     * @var array
     */
    protected static $algorithms = [
        'HS256' => ['hash_hmac', 'sha256'],
        'HS384' => ['hash_hmac', 'sha384'],
        'HS512' => ['hash_hmac', 'sha512'],
    ];

    /**
     * Mapping of available claim keys with their target data type.
     *
     * @var array
     */
    protected static $claims = [
        'nbf' => 'is_int',
        'exp' => 'is_int',
        'iat' => 'is_int',
        'iss' => 'is_string',
        'sub' => 'is_string',
        'aud' => 'is_string',
        'jti' => 'is_string',
    ];

    /**
     * Create a new encoder instance.
     *
     * @param  array   $header
     * @param  array   $payload
     * @param  string  $key
     * @return void
     */
    public function __construct(array $header, array $payload, string $key)
    {
        $this->key = $key;
        $this->header = $header;
        $this->payload = $payload;
    }

    /**
     * Create a new encoder instance.
     *
     * @param  array        $payload
     * @param  array        $header
     * @param  string|null  $key
     * @return $this
     */
    public static function make(array $payload, array $header = [], $key = null)
    {
        return new static(
            static::parseHeader($header),
            static::parsePayload($payload),
            $key ?? config('app.secret_key'),
        );
    }

    /**
     * Parse the given header exists in which header type.
     *
     * @param  array  $header
     * @return array
     * 
     * @throws \Core\Jwt\Exceptions\InvalidHeaderTypeException
     * @throws \Core\Jwt\Exceptions\UnsupportedAlgorithmException
     */
    protected static function parseHeader(array $header)
    {
        if (! isset($header['typ'])) {
            $header = array_merge($header, ['typ' => 'JWT']);
        }

        if (! isset($header['alg'])) {
            $header = array_merge($header, ['alg' => 'HS256']);
        }

        if (! isset(static::$algorithms[$alg = $header['alg']])) {
            throw new UnsupportedAlgorithmException("This [$alg] algorithm is unsupported.");
        }

        if ($header['typ'] != 'JWT') {
            throw new InvalidHeaderTypeException('Invalid header type.');
        }

        return $header;
    }

    /**
     * Parse the given data exists in which claim type.
     *
     * @param  array  $payload
     * @return array
     * 
     * @throws \Core\Jwt\Exceptions\InvalidClaimTypeException
     */
    protected static function parsePayload(array $payload)
    {
        if (! isset($payload['iat'])) {
            $payload = array_merge($payload, ['iat' => time()]);
        }

        if (! isset($payload['exp'])) {
            $payload = array_merge($payload, ['exp' => time() + Constant::DEFAULT_EXP]);
        }

        foreach ($payload as $key => $value) {
            if (! isset(static::$claims[$key])) {
                continue;
            }

            $method = static::$claims[$key];

            if (! $method($value)) {
                throw new InvalidClaimTypeException(
                    "Invalid [$key] claim. The [$value] value must be of type int|string."
                );
            }
        }

        return $payload;
    }

    /**
     * Set the attributes with the values encoded.
     * 
     * @return $this
     */
    public function hash()
    {
        $bindings = static::algorithm($this->header['alg']);

        $header = Base64Url::encode(json_encode($this->header));
        $payload = Base64Url::encode(json_encode($this->payload));
        $signature = Base64Url::encode(
            $bindings[0]($bindings[1], "$header.$payload", $this->key, true)
        );

        $this->bindings = $bindings;
        $this->header = $header;
        $this->payload = $payload;
        $this->signature = $signature;
        $this->token = "$header.$payload.$signature";

        return $this;
    }

    /**
     * Get an algorithm with the given key.
     *
     * @param  string  $key
     * @return array|null
     */
    public static function algorithm($key)
    {
        return Arr::get(static::$algorithms, $key);
    }

    /**
     * Get the claim type with the given key.
     *
     * @param  string  $key
     * @return string|null
     */
    public static function claim($key)
    {
        return Arr::get(static::$claims, $key);
    }

    /**
     * Get the secret key of the application.
     * 
     * @return string
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * Get the header encoded.
     * 
     * @return string
     */
    public function header()
    {
        return $this->header;
    }
    
    /**
     * Get the payload encoded.
     * 
     * @return string
     */
    public function payload()
    {
        return $this->payload;
    }

    /**
     * Get the signature encoded.
     * 
     * @return string
     */
    public function signature()
    {
        return $this->signature;
    }

    /**
     * Get the token encoded.
     * 
     * @return string
     */
    public function token()
    {
        return $this->token;
    }

    /**
     * Get the bindings of the algorithm.
     *
     * @return array
     */
    public function bindings()
    {
        return $this->bindings;
    }
}