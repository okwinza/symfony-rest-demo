<?php

declare(strict_types=1);

namespace App\Http\v1\Transformer;


use App\Model\UserInterface;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(UserInterface $user): array
    {
        $result = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'is_active' => $user->isActive(),
            'has_group' => $user->hasGroup(),
            'group_data' => null,
        ];

        if ($user->hasGroup()) {
            $result['group_data'] = [
                'id' => $user->getGroup()->getId(),
                'name' => $user->getGroup()->getName()
            ];
        }

        return $result;
    }
}