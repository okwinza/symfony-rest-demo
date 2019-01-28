<?php

declare(strict_types=1);

namespace App\Http\v1\Action\Group\Request;



interface UserContainerInterface
{
    public function getUsers(): array;
    public function setUsers(array $users): void;
}