<?php

use helpers\Constants\ErrorConstant;
use helpers\Exception\BaseException;

function handleError($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        return false;
    }
    
    $err_code = ErrorConstant::ERROR_CODE_UNKNOWN;
    $code = 400;
    $err_msg = $errstr;

    throw new BaseException($err_msg, $err_code, $code);
}

set_error_handler('handleError');