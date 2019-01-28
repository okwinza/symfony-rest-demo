<?php

declare(strict_types=1);

namespace App\Entity;

use App\Http\v1\Action\User\Request\CreateUserRequest;
use App\Http\v1\Action\User\Request\UpdateUserRequest;
use Doctrine\ORM\Mapping as ORM;
use App\Model\GroupInterface;
use App\Model\UserInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="app_user")
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(name="is_active", type="boolean", options={"default" : true})
     */
    private $isActive = true;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Group", inversedBy="users")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $group;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    private function __construct(string $email,
                                 string $lastName,
                                 string $firstName,
                                 bool $isActive,
                                 ?GroupInterface $group)
    {
        $this->email = $email;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->isActive = $isActive;
        $this->group = $group;

        $this->createdAt = new \DateTime();
    }

    public static function createFromRequest(CreateUserRequest $request): UserInterface
    {
        $self = new self(
            $request->getEmail(),
            $request->getLastName(),
            $request->getFirstName(),
            $request->getActive(),
            $request->getResolvedGroup()
        );

        return $self;
    }

    public function updateFromRequest(UpdateUserRequest $request): void
    {
        $this->email = $request->getEmail();
        $this->firstName = $request->getFirstName();
        $this->lastName = $request->getLastName();
        $this->isActive = $request->getActive();
        $this->group = $request->getResolvedGroup();
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getLastName() : string
    {
        return $this->lastName;
    }

    public function getFirstName() : string
    {
        return $this->firstName;
    }

    public function isActive() : bool
    {
        return $this->isActive;
    }

    public function enable(): void
    {
        $this->isActive = true;
    }

    public function disable(): void
    {
        $this->isActive = false;
    }

    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt;
    }

    public function hasGroup(): bool
    {
        return $this->group instanceof GroupInterface;
    }

    public function getGroup() : GroupInterface
    {
        return $this->group;
    }

    public function setGroup(?GroupInterface $group): void
    {
        $this->group = $group;
    }
}