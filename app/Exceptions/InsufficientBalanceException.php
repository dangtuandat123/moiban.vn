<?php

namespace App\Exceptions;

use Exception;

/**
 * Exception: Số dư ví không đủ
 */
class InsufficientBalanceException extends Exception
{
    protected $code = 422;
}
