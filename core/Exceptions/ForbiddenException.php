<?php

namespace Core\Exceptions;

use Illuminate\Http\Response;

class ForbiddenException extends ResponseException
{
   /**
    * Create a new forbidden exception instance.
    *
    * @param  string  $message
    * @param  int     $code
    * @return void
    */
   public function __construct($message = ResponseMessage::HTTP_FORBIDDEN, $code = Response::HTTP_FORBIDDEN)
   {
      parent::__construct($message, $code);
   }
}