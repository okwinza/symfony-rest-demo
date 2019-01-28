<?php

declare(strict_types=1);

namespace App\Http\v1\Action\User\ArgumentResolver;


use App\Http\v1\Action\Group\Exception\GroupNotFoundException;
use App\Http\v1\Action\User\Request\CreateUserRequest;
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

class CreateUserRequestResolver implements ArgumentValueResolverInterface
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
        return CreateUserRequest::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        /**
         * @var CreateUserRequest $createUserRequest
         */
        $createUserRequest = $this->serializer->deserialize($request->getContent(),
            CreateUserRequest::class,
            'json',
            ['allow_extra_attributes' => false]
        );

        $this->handleViolations($this->validator->validate($createUserRequest));

        $createUserRequest->setResolvedGroup($this->resolveGroup($createUserRequest->getGroupId()));

        yield $createUserRequest;
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