<?php

namespace helpers\Exception;

use Exception;
use response\BaseResponse;
use Throwable;

class BaseException extends Exception {

    protected $error_code;
    protected $code;
    protected $error_message;

    public function __construct(
        $error_message,
        $error_code,
        $code = 400,
        Throwable $previous = null
    ) {
        parent::__construct($error_message, $code, $previous);
        $this->error_code = $error_code;
        $this->error_message = $error_message;
        $this->code = $code;
    }

    public function getErrorCode() {
        return $this->error_code;
    }

    public function send() {
        $response = new BaseResponse();

        $response->withError(true, $this->error_code, $this->code);
        $response->withMessage($this->error_message);
        return $response->send();
    }
}