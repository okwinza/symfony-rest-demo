<?php

declare(strict_types=1);

namespace App\Http\v1\Action\User;


use App\Http\Fractal\FractalTrait;
use App\Http\v1\Transformer\Transformers;
use App\Model\UserInterface;
use League\Fractal\Resource\Item;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetSingleUserAction
{
    use FractalTrait;

    public function __invoke(Request $request, UserInterface $user)
    {
        $resource = new Item($user, Transformers::USER_TRANSFORMER);
        return new JsonResponse(
            $this->fractal($request)->createData($resource)->toArray(),
            Response::HTTP_OK
        );
    }
}