<?php

namespace Core\Http\Exception;

use Core\Http\Exception\AbstractResponseException;

class ForbiddenResponseException extends AbstractResponseException
{
   /**
    * Create a new "forbidden response exception" instance.
    */
   public function __construct(int $status = 403, ?string $message = null)
   {
      parent::__construct($status, $message);
   }
}