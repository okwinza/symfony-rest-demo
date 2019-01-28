<?php

declare(strict_types=1);


namespace App\Http\v1\Action\User;


use App\Http\v1\Action\User\Request\UpdateUserRequest;
use App\Model\UserInterface;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateUserAction
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(Request $request, UpdateUserRequest $updateUserRequest, UserInterface $user)
    {
        $user->updateFromRequest($updateUserRequest);
        $this->userRepository->save($user);

        return new JsonResponse(null, 204);
    }
}