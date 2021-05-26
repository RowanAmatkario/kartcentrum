<?php

namespace App\Entity;

use App\Repository\PizzaChefRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PizzaChefRepository::class)
 */
class PizzaChef
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
    private $soort;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prijs;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSoort(): ?string
    {
        return $this->soort;
    }

    public function setSoort(string $soort): self
    {
        $this->soort = $soort;

        return $this;
    }

    public function getPrijs(): ?string
    {
        return $this->prijs;
    }

    public function setPrijs(?string $prijs): self
    {
        $this->prijs = $prijs;

        return $this;
    }
}
