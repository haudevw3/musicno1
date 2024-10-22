<?php

namespace Core\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

abstract class ResponseException extends Exception
{
    /**
     * @var int
     */
    protected $code;

    /**
     * @var string
     */
    protected $message;

    /**
     * Create a new response exception instance.
     *
     * @param  string|null  $message
     * @param  int|null     $code
     * @return void
     */
    public function __construct($message = null, $code = null)
    {
        $this->code = $code ?? Response::HTTP_INTERNAL_SERVER_ERROR;
        $this->message = $message ?? ResponseMessage::HTTP_INTERNAL_SERVER_ERROR;

        parent::__construct($this->message, $this->code);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render(Request $request)
    {
        $data = [
            'code' => $this->code,
            'message' => Arr::wrap($this->message),
        ];

        return response()->json($data, $this->code);
    }

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        Log::emergency($this->message);
    }
} 