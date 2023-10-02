<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class MasterNotFoundHttpException extends HttpException
{
    public function __construct(string $message = 'Record not found.', \Throwable $previous = null, int $code = 0, array $headers = []) {
        parent::__construct(404, $message, $previous, $headers, $code);
    }
}