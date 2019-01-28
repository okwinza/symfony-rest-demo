<?php

declare(strict_types=1);

namespace App\Http\v1\Action\Group\Exception;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GroupNotFoundException extends NotFoundHttpException
{

}