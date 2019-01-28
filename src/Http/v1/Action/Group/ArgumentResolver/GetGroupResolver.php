<?php

declare(strict_types=1);

namespace App\Http\v1\Action\Group\ArgumentResolver;


use App\Http\v1\Action\Group\Exception\GroupNotFoundException;
use App\Model\GroupInterface;
use App\Repository\GroupRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class GetGroupResolver implements ArgumentValueResolverInterface
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return GroupInterface::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $group = $this->groupRepository->findOneById($request->attributes->getInt('group_id'));
        if (!$group instanceof GroupInterface) {
            throw new GroupNotFoundException('Requested group not found :(');
        }

        yield $group;
    }

}