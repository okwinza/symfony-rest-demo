<?php

declare(strict_types=1);

namespace App\Http\v1\Action\Group\Request;

use App\Model\GroupInterface;
use App\Model\UserInterface;

class UpdateGroupRequest extends CreateGroupRequest implements UserContainerInterface
{
    public static function loadFromExisting(GroupInterface $group): self
    {
        $userIds = $group->getUsers()->map(function (UserInterface $user) {
            return $user->getId();
        })->toArray();

        $self = new self();
        $self->setName($group->getName());
        $self->setUserIds($userIds);
        $self->setUsers($group->getUsers()->toArray());

        return $self;
    }
}