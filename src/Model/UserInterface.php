<?php

declare(strict_types=1);

namespace App\Model;


use App\Http\v1\Action\User\Request\CreateUserRequest;
use App\Http\v1\Action\User\Request\UpdateUserRequest;

interface UserInterface
{
    public function getId() : int;
    public function getFirstName(): ?string;
    public function getLastName(): ?string;
    public function getEmail(): string;
    public function isActive(): bool;
    public function enable(): void;
    public function disable(): void;
    public function hasGroup(): bool;
    public function getGroup(): GroupInterface;
    public function setGroup(?GroupInterface $group): void;
    public function getCreatedAt(): \DateTime;

    public static function createFromRequest(CreateUserRequest $request): UserInterface;
    public function updateFromRequest(UpdateUserRequest $request): void;

}