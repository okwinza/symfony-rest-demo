<?php

declare(strict_types=1);


namespace App\Http\v1\Action\Group;


use App\Http\Fractal\FractalTrait;
use App\Http\v1\Transformer\Transformers;
use App\Repository\GroupRepository;
use League\Fractal\Resource\Collection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetGroupListAction
{
    use FractalTrait;

    /**
     * @var GroupRepository
     */
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function __invoke(Request $request)
    {
        $collection = new Collection($this->groupRepository->findAll(), Transformers::GROUP_TRANSFORMER);
        return new JsonResponse(
            $this->fractal($request)->createData($collection)->toArray()
        );
    }
}