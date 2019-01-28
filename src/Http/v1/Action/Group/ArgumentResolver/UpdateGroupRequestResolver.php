<?php

declare(strict_types=1);

namespace App\Http\v1\Action\Group\ArgumentResolver;


use App\Http\v1\Action\Group\Exception\GroupNotFoundException;
use App\Http\v1\Action\Group\Request\UpdateGroupRequest;
use App\Model\GroupInterface;
use App\Repository\GroupRepository;
use App\Validation\ViolationsHandlerTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UpdateGroupRequestResolver implements ArgumentValueResolverInterface
{
    use ViolationsHandlerTrait;

    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(GroupRepository $groupRepository,
                                SerializerInterface $serializer,
                                ValidatorInterface $validator)
    {
        $this->groupRepository = $groupRepository;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return UpdateGroupRequest::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $updateGroupRequest = UpdateGroupRequest::loadFromExisting(
            $this->resolveGroup($request->attributes->getInt('group_id'))
        );

        $updateGroupRequest = $this->serializer->deserialize($request->getContent(),
            UpdateGroupRequest::class,
            'json',
            ['object_to_populate' => $updateGroupRequest, 'allow_extra_attributes' => false]
        );

        $this->handleViolations($this->validator->validate($updateGroupRequest));

        yield $updateGroupRequest;
    }

    private function resolveGroup($id): GroupInterface
    {
        $group = $this->groupRepository->findOneById($id);
        if (!$group instanceof GroupInterface) {
            throw new GroupNotFoundException('Requested group not found :(');
        }

        return $group;
    }

}