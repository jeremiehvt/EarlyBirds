<?php

namespace App\Domain\Models;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Repository\LevelRepository")
 */
class Level
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var int
     */
    private $points;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $img;

    /**
     * @var ArrayCollection
     */
    private $user;

    /**
     * Post constructor.
     */
    public function __construct()
    {
        $this->id   = Uuid::uuid4();
        $this->user = new ArrayCollection();
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }
    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return Level
     */
    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setLevel($this);
        }

        return $this;
    }

    /**
     * @param User $user
     *
     * @return Level
     */
    public function removeUser(User $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getLevel() === $this) {
                $user->setLevel(null);
            }
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * @param int $points
     */
    public function setPoints(int $points): void
    {
        $this->points = $points;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return null|string
     */
    public function getImg(): ?string
    {
        return $this->img;
    }

    /**
     * @param null|string $img
     */
    public function setImg(?string $img): void
    {
        $this->img = $img;
    }
}
