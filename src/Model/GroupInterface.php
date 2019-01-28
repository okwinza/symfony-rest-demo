<?php

declare(strict_types=1);

namespace App\Model;


use App\Http\v1\Action\Group\Request\CreateGroupRequest;
use App\Http\v1\Action\Group\Request\UpdateGroupRequest;
use Doctrine\Common\Collections\Collection;

interface GroupInterface
{
    public function getId(): int;
    public function getName(): string;
    public function hasUsers(): bool;
    public function getUsers(): Collection;
    public function addUser(UserInterface $user): void;
    public function removeUser(UserInterface $user): void;

    public static function createFromRequest(CreateGroupRequest $request): GroupInterface;
    public function updateFromRequest(UpdateGroupRequest $request): void;
}