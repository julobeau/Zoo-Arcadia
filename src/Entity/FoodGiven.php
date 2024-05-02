<?php

namespace App\Entity;

use App\Repository\FoodGivenRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FoodGivenRepository::class)]
class FoodGiven
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $food = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $foodQuantity = null;

    #[ORM\ManyToOne(inversedBy: 'foodGivens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\ManyToOne(inversedBy: 'foodGivens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $soigneur = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFood(): ?string
    {
        return $this->food;
    }

    public function setFood(string $food): static
    {
        $this->food = $food;

        return $this;
    }

    public function getFoodQuantity(): ?string
    {
        return $this->foodQuantity;
    }

    public function setFoodQuantity(string $foodQuantity): static
    {
        $this->foodQuantity = $foodQuantity;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function getSoigneur(): ?User
    {
        return $this->soigneur;
    }

    public function setSoigneur(?User $soigneur): static
    {
        $this->soigneur = $soigneur;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }
}
