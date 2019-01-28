<?php

declare(strict_types=1);

namespace App\Http\v1\Action\User\ArgumentResolver;


use App\Http\v1\Action\User\Exception\UserNotFoundException;
use App\Model\UserInterface;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class GetUserResolver implements ArgumentValueResolverInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return UserInterface::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield $this->resolveUser($request->attributes->getInt('user_id'));
    }

    private function resolveUser($id): UserInterface
    {
        $user = $this->userRepository->findOneById($id);
        if (!$user instanceof UserInterface) {
            throw new UserNotFoundException('User not found.');
        }

        return $user;
    }

}