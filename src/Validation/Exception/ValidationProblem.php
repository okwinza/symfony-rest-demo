<?php

declare(strict_types=1);

namespace App\Validation\Exception;


use App\Exception\ApiProblem;

class ValidationProblem extends ApiProblem
{
    public function __construct()
    {
        parent::__construct(400, 'ValidationProblem', 'Validation error');
    }

    public function setErrors(array $errors) : void
    {
        $this->extraData['errors'] = $errors;
    }

    public function getErrors() : array
    {
        return !empty($this->extraData['errors']) ? $this->extraData['errors'] : [];
    }
}