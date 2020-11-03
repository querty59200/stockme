<?php


namespace App\Entity;

class LuggageSearch
{
    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var int|null
     */
    private $minvolume;

    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param int|null $maxPrice
     */
    public function setMaxPrice(int $maxPrice): void
    {
        $this->maxPrice = $maxPrice;
    }

    /**
     * @return int|null
     */
    public function getMinvolume(): ?int
    {
        return $this->minvolume;
    }

    /**
     * @param int|null $minvolume
     */
    public function setMinvolume(int $minvolume): void
    {
        $this->minvolume = $minvolume;
    }
}