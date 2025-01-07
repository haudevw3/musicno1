<?php

namespace Core\Http;

use Illuminate\Support\Arr;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Routing\ResponseFactory;

class Response
{
    /**
     * The response status.
     * 
     * @var int
     */
    protected $status;

    /**
     * The response data.
     * 
     * @var array
     */
    protected $data;

    /**
     * The response instance.
     *
     * @var HttpResponse|ResponseFactory
     */
    protected $response;

    /**
     * The methods are not passthru when calling dynamically.
     *
     * @var array
     */
    protected $notPassthru = [
        'json'
    ];

    /**
     * Create a new "response" instance.
     */
    protected function __construct(array $data = [], int $status = 200, HttpResponse|ResponseFactory $response)
    {
        $this->data = $data;
        $this->status = $status;
        $this->response = $response;
    }

    /**
     * Create a new "response" instance.
     */
    public static function create(mixed $content = '', int $status = 500, array $headers = []): self
    {
        $response = app(ResponseFactory::class);

        if (func_num_args() !== 0) {
            $response = $response->make($content, $status, $headers);
        }

        return new static(['errors' => []], $status, $response);
    }

    /**
     * Create a new "JSON response" instance.
     */
    public function json(array $excepts = [], array $headers = [], int $options = 0): JsonResponse
    {
        $data = $this->data();
        $status = $this->status();

        if ($status != 500) {
            unset($data['errors']);
        }

        if (! empty($excepts)) {
            $data = Arr::except($data, $excepts);
        }

        return $this->response->json($data, $status, $headers, $options);
    }

    /**
     * Set error with the given value.
     */
    public function setError(array|string $error): self
    {
        $this->data['errors'] = Arr::wrap($error);

        return $this;
    }

    /**
     * Add an error with the given value.
     */
    public function addError(string $error): self
    {
        $this->data['errors'][] = $error;

        return $this;
    }

    /**
     * Determine if the given key exists in the data.
     */
    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Determine if the given key "errors" is empty.
     *
     * @return bool
     */
    public function isEmptyError(): bool
    {
        return empty($this->data['errors']);
    }

    /**
     * Determine if the given key "errors" is not empty.
     */
    public function isNotEmptyError(): bool
    {
        return ! $this->isEmptyError();
    }

    /**
     * Get the response status.
     */
    public function status(): int
    {
        return $this->status;
    }

    /**
     * Set status with the given value.
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the response data with the given keys if any.
     */
    public function data(array|string|null $keys = null): array
    {
        if (is_null($keys)) {
            return $this->data;
        }

        $keys = is_array($keys) ? $keys : [$keys];

        foreach ($keys as $key) {
            if ($this->has($key)) {
                $data[$key] = $this->data[$key];
            }
        }

        return $data;
    }

    /**
     * Set data with the given value.
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Handle dynamic method calls into the "HTTP response" instance.
     */
    public function __call(string $method, array $parameters): mixed
    {
        return $this->response->{$method}(...$parameters);
    }

    /**
     * Get the data value with the given key.
     */
    public function __get(string $key): mixed
    {
        return $this->data[$key];
    }

    /**
     * Set the data value with the given arguments.
     */
    public function __set(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }
}