<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch{

    public function __construct()
    {
        $this->options = new ArrayCollection();
    }

    /**
     * @Assert\Range(
     *     min=20,
     *     max=400
     * )
     * @var int|null
     */
    private $minSurface;

    /**
     * @Assert\Range(
     *     min=50000,
     *     max=1000000
     * )
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var ArrayCollection
     */
    private $options;
    /**
     * @return int|null
     */
    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    /**
     * @param int|null $minSurface
     * @return PropertySearch
     */
    public function setMinSurface(?int $minSurface): PropertySearch
    {
        $this->minSurface = $minSurface;
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
     * @param int|null $maxPrice
     * @return PropertySearch
     */
    public function setMaxPrice(?int $maxPrice): PropertySearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getOptions(): ArrayCollection
    {
        return $this->options;
    }

    /**
     * @param ArrayCollection $options
     * @return PropertySearch
     */
    public function setOptions(ArrayCollection $options): PropertySearch
    {
        $this->options = $options;
        return $this;
    }



   }