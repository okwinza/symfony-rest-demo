<?php

declare(strict_types=1);

namespace App\Validation;

use App\Validation\Exception\ValidationException;
use App\Validation\Exception\ValidationProblem;
use Symfony\Component\Validator\ConstraintViolationListInterface;

trait ViolationsHandlerTrait
{
    private function handleViolations(ConstraintViolationListInterface $errors) : void
    {
        if ($errors->count() > 0) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[] = ['propertyPath' => $error->getPropertyPath(), 'message' => $error->getMessage()];
            }
            $problem = new ValidationProblem();
            $problem->setErrors($messages);

            throw new ValidationException($problem);
        }
    }
}