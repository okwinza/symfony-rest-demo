<?php

declare(strict_types=1);

namespace App\Exception;


use Symfony\Component\HttpFoundation\Response;

abstract class ApiProblem
{
    protected $statusCode;
    protected $errorCode;
    protected $message;
    protected $extraData = [];

    public function __construct($statusCode, $errorCode = null, $message = null)
    {
        $this->statusCode = (int) $statusCode;
        $this->errorCode = $errorCode;
        $this->message = $message;

        if (null === $errorCode) {
            $this->errorCode = 'about:blank';
        }

        if (null === $message) {
            $this->message = isset(Response::$statusTexts[$statusCode])
                ? Response::$statusTexts[$statusCode]
                : "Unknown error. Weird.";
        }
    }

    public function toArray() : array
    {
        return array_merge(
            $this->extraData,
            array(
                'status' => $this->statusCode,
                'error_code' => $this->errorCode,
                'message' => $this->message,
            )
        );
    }

    public function getStatusCode() : int
    {
        return $this->statusCode;
    }

    public function getMessage() : string
    {
        return $this->message;
    }

    public function getErrorCode() : string
    {
        return $this->errorCode;
    }

    protected function set($name, $value) : void
    {
        $this->extraData[$name] = $value;
    }
}