<?php

namespace App\Helpers;

class ApiError
{
    private $code;
    private $endpoint;
    private $message;

    public function __construct($code, $message, $endpoint) 
    {
        $this->code = $code;
        $this->endpoint = $endpoint;
        $this->message = $message;
    }

    public function getCode(): string 
    {
        return (string) $this->code;
    }

    public function getEndpoint(): string 
    {
        return (string) $this->endpoint;
    }

    public function getMessage(): string 
    {
        return (string) $this->message;
    }
}