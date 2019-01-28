<?php

declare(strict_types=1);

namespace App\Http\v1\Action\User\Exception;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserNotFoundException extends NotFoundHttpException
{

}