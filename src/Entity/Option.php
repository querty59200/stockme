<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 * @ORM\Table(name="`option`")
 */
class Option
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Luggage::class, inversedBy="options")
     */
    private $luggages;

    public function __construct()
    {
        $this->luggages = new ArrayCollection();
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
     * @return Collection|Luggage[]
     */
    public function getLuggages(): Collection
    {
        return $this->luggages;
    }

    public function addLuggage(Luggage $luggage): self
    {
        if (!$this->luggages->contains($luggage)) {
            $this->luggages[] = $luggage;
        }

        return $this;
    }

    public function removeLuggage(Luggage $luggage): self
    {
        $this->luggages->removeElement($luggage);

        return $this;
    }
}
