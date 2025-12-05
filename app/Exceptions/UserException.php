<?php

namespace App\Exceptions;

use Exception;;

class UserException extends Exception
{
    protected $userMessage;

    public function __construct($userMessage, $message = "", $code = 0)
    {
        parent::__construct($message);
        $this->code = $code;
        $this->userMessage = $userMessage;
    }

    public function getUserMessage() {
        return $this->userMessage;
    }
}
?>
