<?php

declare(strict_types=1);

namespace App\Http\v1\Action\Group;


use App\Entity\Group;
use App\Http\Fractal\FractalTrait;
use App\Http\v1\Action\Group\Request\CreateGroupRequest;
use App\Http\v1\Transformer\Transformers;
use App\Repository\GroupRepository;
use League\Fractal\Resource\Item;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateGroupAction
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

    public function __invoke(Request $request, CreateGroupRequest $createGroupRequest)
    {
        $group = Group::createFromRequest($createGroupRequest);
        $this->groupRepository->save($group);

        $resource = new Item($group, Transformers::GROUP_TRANSFORMER);
        return new JsonResponse(
            $this->fractal($request)->createData($resource)->toArray(),
            Response::HTTP_CREATED
        );
    }
}