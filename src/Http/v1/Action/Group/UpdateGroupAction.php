<?php

declare(strict_types=1);

namespace App\Http\v1\Action\Group;


use App\Http\v1\Action\Group\Request\UpdateGroupRequest;
use App\Model\GroupInterface;
use App\Repository\GroupRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateGroupAction
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function __invoke(Request $request, UpdateGroupRequest $updateGroupRequest, GroupInterface $group)
    {
        $group->updateFromRequest($updateGroupRequest);
        $this->groupRepository->save($group);

        return new JsonResponse(null, 204);
    }
}