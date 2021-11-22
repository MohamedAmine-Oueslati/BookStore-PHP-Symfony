<?php

namespace App\Entity;

class Search
{
    /**
     * @var int|null
     */
    private $minPrice;

    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var string|null
     */
    private $title;


    /**
     * @return int|null
     */
    public function getMinPrice(): ?int
    {
        return $this->minPrice;
    }

    /**
     * @param int|null $minPrice
     * @return Search
     */
    public function setMinPrice(int $minPrice): Search
    {
        $this->minPrice = $minPrice;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param int|null $minPrice
     * @return Search
     */
    public function setMaxPrice(int $maxPrice): Search
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return Search
     */
    public function setTitle(string $title): Search
    {
        $this->title = $title;
        return $this;
    }
}
