<?php

declare(strict_types=1);

namespace App\Http\v1\Action\Group\Request;

use Symfony\Component\Validator\Constraints as Assert;

class CreateGroupRequest implements UserContainerInterface
{
    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $name;

    /**
     * @Assert\Type("array")
     */
    private $userIds = [];

    /**
     * Resolved User Objects array
     * @Assert\Type("array")
     */
    private $users = [];


    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getUserIds(): array
    {
        return $this->userIds;
    }

    public function setUserIds($userIds): void
    {
        $this->userIds = $userIds;
    }

    public function getUsers(): array
    {
        return $this->users;
    }

    public function setUsers(array $users): void
    {
        $this->users = $users;
    }
}