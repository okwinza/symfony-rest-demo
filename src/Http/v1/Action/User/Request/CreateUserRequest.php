<?php

declare(strict_types=1);

namespace App\Http\v1\Action\User\Request;

use Symfony\Component\Validator\Constraints as Assert;
use App\Model\GroupInterface;

class CreateUserRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(min=2, max=30)
     */
    private $firstName;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(min=2, max=30)
     */
    private $lastName;

    /**
     * @Assert\NotNull()
     * @Assert\Type("boolean")
     */
    private $active;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     */
    private $groupId;

    private $resolvedGroup;


    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getActive(): bool
    {
        return (bool) $this->active;
    }

    public function setActive($active): void
    {
        $this->active = $active;
    }

    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    public function setGroupId($groupId): void
    {
        $this->groupId = $groupId;
    }

    public function getResolvedGroup(): ?GroupInterface
    {
        return $this->resolvedGroup;
    }

    public function setResolvedGroup(GroupInterface $resolvedGroup): void
    {
        $this->resolvedGroup = $resolvedGroup;
    }
}