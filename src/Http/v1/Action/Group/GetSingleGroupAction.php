<?php

declare(strict_types=1);


namespace App\Http\v1\Action\Group;


use App\Http\Fractal\FractalTrait;
use App\Http\v1\Transformer\Transformers;
use App\Model\GroupInterface;
use League\Fractal\Resource\Item;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetSingleGroupAction
{
    use FractalTrait;

    public function __invoke(Request $request, GroupInterface $group)
    {
        $resource = new Item($group, Transformers::GROUP_TRANSFORMER);
        return new JsonResponse(
            $this->fractal($request)->createData($resource)->toArray()
        );
    }
}