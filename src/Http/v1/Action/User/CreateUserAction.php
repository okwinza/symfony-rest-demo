<?php

declare(strict_types=1);


namespace App\Http\v1\Action\User;


use App\Entity\User;
use App\Http\Fractal\FractalTrait;
use App\Http\v1\Action\User\Request\CreateUserRequest;
use App\Http\v1\Transformer\Transformers;
use App\Repository\UserRepository;
use League\Fractal\Resource\Item;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateUserAction
{
    use FractalTrait;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(Request $request, CreateUserRequest $createUserRequest)
    {
        $user = User::createFromRequest($createUserRequest);

        $this->userRepository->save($user);

        $resource = new Item($user, Transformers::USER_TRANSFORMER);
        return new JsonResponse(
            $this->fractal($request)->createData($resource)->toArray(),
            Response::HTTP_CREATED
        );
    }
}