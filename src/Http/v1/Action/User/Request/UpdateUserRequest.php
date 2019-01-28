<?php

declare(strict_types=1);

namespace App\Http\v1\Action\User\Request;


use App\Model\UserInterface;

class UpdateUserRequest extends CreateUserRequest
{
    public static function loadFromExisting(UserInterface $user): self
    {
        $self = new self();
        $self->setEmail($user->getEmail());
        $self->setFirstName($user->getFirstName());
        $self->setLastName($user->getLastName());
        $self->setActive($user->isActive());
        $self->setGroupId($user->getGroup()->getId());
        $self->setResolvedGroup($user->getGroup());

        return $self;
    }
}