<?php

declare(strict_types=1);

namespace App\Http\v1\Action\User\ArgumentResolver;


use App\Http\v1\Action\Group\Exception\GroupNotFoundException;
use App\Http\v1\Action\User\Exception\UserNotFoundException;
use App\Http\v1\Action\User\Request\UpdateUserRequest;
use App\Model\GroupInterface;
use App\Model\UserInterface;
use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use App\Validation\ViolationsHandlerTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateUserRequestResolver implements ArgumentValueResolverInterface
{
    use ViolationsHandlerTrait;

    /**
     * @var UserRepository
     */
    private $userRepository;

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

    public function __construct(UserRepository $userRepository,
                                GroupRepository $groupRepository,
                                SerializerInterface $serializer,
                                ValidatorInterface $validator)
    {
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return UpdateUserRequest::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $updateUserRequest = UpdateUserRequest::loadFromExisting(
            $this->resolveUser($request->attributes->getInt('user_id'))
        );

        /**
         * @var UpdateUserRequest $updateUserRequest
         */
        $updateUserRequest = $this->serializer->deserialize($request->getContent(),
            UpdateUserRequest::class,
            'json',
            ['object_to_populate' => $updateUserRequest, 'allow_extra_attributes' => false]
        );

        $this->handleViolations($this->validator->validate($updateUserRequest));
        $updateUserRequest->setResolvedGroup($this->resolveGroup($updateUserRequest->getGroupId()));

        yield $updateUserRequest;
    }

    private function resolveUser($id): UserInterface
    {
        $user = $this->userRepository->findOneById($id);
        if (!$user instanceof UserInterface) {
            throw new UserNotFoundException('User not found.');
        }

        return $user;
    }

    private function resolveGroup($id)
    {
        $group = $this->groupRepository->findOneById($id);
        if (!$group instanceof GroupInterface) {
            throw new GroupNotFoundException('Group does not exist.');
        }

        return $group;
    }

}