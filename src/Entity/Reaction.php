<?php

namespace App\Entity;

use App\Repository\ReactionRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass=ReactionRepository::class)
 */
class Reaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Luggage::class, inversedBy="reactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $luggage;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLuggage(): Luggage
    {
        return $this->luggage;
    }

    public function setLuggage(Luggage $luggage): self
    {
        $this->luggage = $luggage;

        return $this;
    }

    /**
     * @return \App\Entity\User
     */
    public function getUser(): \App\Entity\User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
