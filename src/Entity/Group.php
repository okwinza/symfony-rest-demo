<?php

declare(strict_types=1);

namespace App\Entity;

use App\Http\v1\Action\Group\Request\CreateGroupRequest;
use App\Http\v1\Action\Group\Request\UpdateGroupRequest;
use Doctrine\ORM\Mapping as ORM;
use App\Model\GroupInterface;
use App\Model\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity()
 * @ORM\Table(name="app_group")
 */
class Group implements GroupInterface
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", cascade={"persist"}, orphanRemoval=false, mappedBy="group")
     *
     * @var ArrayCollection
     */
    private $users;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->users = new ArrayCollection();
    }

    public static function createFromRequest(CreateGroupRequest $request): GroupInterface
    {
        $self = new self($request->getName());
        return $self;
    }

    public function updateFromRequest(UpdateGroupRequest $request): void
    {
        $this->name = $request->getName();

        $this->users->clear();
        foreach ($request->getUsers() as $newUsers) {
            $this->addUser($newUsers);
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function hasUsers(): bool
    {
        return !$this->users->isEmpty();
    }

    public function getUsers(): Collection
    {
        return clone $this->users;
    }

    public function addUser(UserInterface $user): void
    {
        if ($this->users->contains($user)) {
            return;
        }

        $user->setGroup($this);
        $this->users->add($user);
    }

    public function removeUser(UserInterface $user): void
    {
        if (!$this->users->contains($user)) {
            return;
        }

        $user->setGroup(null);
        $this->users->removeElement($user);
    }
}