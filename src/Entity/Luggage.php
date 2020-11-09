<?php

namespace App\Entity;

use App\Repository\LuggageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LuggageRepository::class)
 */
class Luggage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("luggage")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("luggage")
     */
    private $description;


    /**
     * @ORM\Column(type="boolean")
     * @Groups("luggage")
     */
    private $available;

    /**
     * @ORM\Column(type="float")
     * @Groups("luggage")
     */
    private $price;

    /**
     * @ORM\Column(type="float")
     * @Groups("luggage")
     */
    private $height;

    /**
     * @ORM\Column(type="float")
     * @Groups("luggage")
     */
    private $length;

    /**
     * @ORM\Column(type="float")
     * @Groups("luggage")
     */
    private $width;

    /**
     * @ORM\Column(type="float")
     * @Groups("luggage")
     */
    private $weight;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="luggage")
     */
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity=Reaction::class, mappedBy="luggage", orphanRemoval=true)
     */
    private $reactions;

    /**
     * @ORM\ManyToMany(targetEntity=Option::class, mappedBy="luggages")
     */
    private $options;

    /**
     * @ORM\Column(type="float", nullable=false)
     * @Groups("luggage")
     */
    private $volume;

    public function __construct()
    {
        $this->reactions = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->options = new ArrayCollection();
        $this->volume = ($this->height * $this->length * $this->width)/1000;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(){
        return (new Slugify())->slugify($this->name);

    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
    public function getAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): self
    {
        $this->available = $available;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(float $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getLength(): ?float
    {
        return $this->length;
    }

    public function setLength(float $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function setWidth(float $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return Collection|Reaction[]
     */
    public function getReactions(): Collection
    {
        return $this->reactions;
    }

    public function addReaction(Reaction $reaction): self
    {
        if (!$this->reactions->contains($reaction)) {
            $this->reactions[] = $reaction;
            $reaction->setLuggage($this);
        }

        return $this;
    }

    public function removeReaction(Reaction $reaction): self
    {
        if ($this->reactions->removeElement($reaction)) {
            // set the owning side to null (unless already changed)
            if ($reaction->getLuggage() === $this) {
                $reaction->setLuggage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function setPhotos(Photo $photos): self
    {
        $this->photos = $photos;

        return $this;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setLuggage($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getLuggage() === $this) {
                $photo->setLuggage(null);
            }
        }

        return $this;
    }

    public function isLikedByUser(User $user) : bool
    {

        foreach ($this->getReactions() as $reaction) {
            if ($reaction->getUser()->getId() === $user->getId()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->addLuggage($this);
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        if ($this->options->removeElement($option)) {
            $option->removeLuggage($this);
        }

        return $this;
    }

    public function getVolume(): ?float
    {
        return $this->volume;
    }

    public function setVolume(?float $volume): self
    {
        $this->volume = $volume;

        return $this;
    }
}
