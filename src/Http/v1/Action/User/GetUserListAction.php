<?php

declare(strict_types=1);

namespace App\Http\v1\Action\User;


use App\Http\Fractal\FractalTrait;
use App\Http\v1\Transformer\Transformers;
use App\Repository\UserRepository;
use League\Fractal\Resource\Collection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetUserListAction
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

    public function __invoke(Request $request)
    {
        $collection = new Collection($this->userRepository->findAll(), Transformers::USER_TRANSFORMER);
        return new JsonResponse(
            $this->fractal($request)->createData($collection)->toArray()
        );
    }
}