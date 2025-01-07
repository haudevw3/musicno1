<?php

namespace Core\Http\Exception;

use Exception;
use Core\Http\Response;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

abstract class AbstractResponseException extends Exception
{
    /**
     * The response status.
     * 
     * @var int
     */
    protected $status;

    /**
     * The response message.
     * 
     * @var string
     */
    protected $message;

    /**
     * Create a new "response exception" instance.
     */
    public function __construct(int $status = 500, ?string $message = null)
    {
        $this->status = $status;
        $this->message = $message ?? HttpResponse::$statusTexts[$status];

        parent::__construct($this->message, $this->status);
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return Response::create()->setData([
            'status' => $this->status,
            'message' => $this->message
        ])->json();
    }

    /**
     * Report the exception.
     */
    public function report(Request $request): void
    {
        Log::warning("status: {$this->status} message: '{$this->message}'", [
            'ip' => $request->ip()
        ]);
    }
} 