<?php

declare(strict_types=1);

namespace App\Exception;


use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class ApiException extends HttpException
{
    protected $apiProblem;

    public function __construct(ApiProblem $apiProblem,
                                \Exception $previous = null,
                                array $headers = [], $code = 0)
    {
        $this->apiProblem = $apiProblem;

        parent::__construct(
            $apiProblem->getStatusCode(),
            $apiProblem->getMessage(),
            $previous, $headers, $code
        );
    }

    public function getApiProblem() : ApiProblem
    {
        return $this->apiProblem;
    }
}