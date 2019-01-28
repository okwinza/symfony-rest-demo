<?php

declare(strict_types=1);

namespace App\Http\v1\Action\Group\ArgumentResolver;


use App\Http\v1\Action\Group\Request\CreateGroupRequest;
use App\Validation\ViolationsHandlerTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CreateGroupRequestResolver implements ArgumentValueResolverInterface
{
    use ViolationsHandlerTrait;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return CreateGroupRequest::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $createGroupRequest = $this->serializer->deserialize($request->getContent(),
            CreateGroupRequest::class,
            'json',
            ['allow_extra_attributes' => false]
        );

        $this->handleViolations($this->validator->validate($createGroupRequest));

        yield $createGroupRequest;
    }
}