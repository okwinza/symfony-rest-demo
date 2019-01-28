<?php

declare(strict_types=1);

namespace App\Http\v1\Transformer;


use App\Model\GroupInterface;
use App\Model\UserInterface;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class GroupTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'users'
    ];

    public function transform(GroupInterface $group): array
    {
        return [
            'id' => $group->getId(),
            'name' => $group->getName(),
            'user_ids' => $group->getUsers()->map(function (UserInterface $user) {
                return $user->getId();
            })->toArray()
        ];
    }

    public function includeUsers(GroupInterface $group): Collection
    {
        return $this->collection($group->getUsers(), Transformers::USER_TRANSFORMER);
    }

}