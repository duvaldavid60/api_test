<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserGroupRepository")
 * @ExclusionPolicy("all")
 */
class UserGroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Expose
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="userGroups")
     */
    protected $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if ($this->users->contains($user)) {
            throw new \Exception("Group already contains this user", 400);
        }

        $this->users[] = $user;
        return $this;
    }

    public function removeUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            throw new \Exception("Group dosen't contains this user", 400);
        }
        $this->users->removeElement($user);

        return $this;
    }
}
