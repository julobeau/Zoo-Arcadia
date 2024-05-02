<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $firstname = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Race $race = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Habitat $habitat = null;

    /**
     * @var Collection<int, ImagesAnimaux>
     */
    #[ORM\OneToMany(targetEntity: ImagesAnimaux::class, mappedBy: 'animal', orphanRemoval: true)]
    private Collection $images;

    /**
     * @var Collection<int, RapportVeterinaireAnimal>
     */
    #[ORM\OneToMany(targetEntity: RapportVeterinaireAnimal::class, mappedBy: 'animal', orphanRemoval: true)]
    private Collection $rapportVeterinaireAnimals;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, FoodGiven>
     */
    #[ORM\OneToMany(targetEntity: FoodGiven::class, mappedBy: 'animal', orphanRemoval: true)]
    private Collection $foodGivens;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->rapportVeterinaireAnimals = new ArrayCollection();
        $this->foodGivens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): static
    {
        $this->race = $race;

        return $this;
    }

    public function getHabitat(): ?Habitat
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitat $habitat): static
    {
        $this->habitat = $habitat;

        return $this;
    }

    /**
     * @return Collection<int, ImagesAnimaux>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ImagesAnimaux $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setAnimal($this);
        }

        return $this;
    }

    public function removeImage(ImagesAnimaux $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAnimal() === $this) {
                $image->setAnimal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RapportVeterinaireAnimal>
     */
    public function getRapportVeterinaireAnimals(): Collection
    {
        return $this->rapportVeterinaireAnimals;
    }

    public function addRapportVeterinaireAnimal(RapportVeterinaireAnimal $rapportVeterinaireAnimal): static
    {
        if (!$this->rapportVeterinaireAnimals->contains($rapportVeterinaireAnimal)) {
            $this->rapportVeterinaireAnimals->add($rapportVeterinaireAnimal);
            $rapportVeterinaireAnimal->setAnimal($this);
        }

        return $this;
    }

    public function removeRapportVeterinaireAnimal(RapportVeterinaireAnimal $rapportVeterinaireAnimal): static
    {
        if ($this->rapportVeterinaireAnimals->removeElement($rapportVeterinaireAnimal)) {
            // set the owning side to null (unless already changed)
            if ($rapportVeterinaireAnimal->getAnimal() === $this) {
                $rapportVeterinaireAnimal->setAnimal(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, FoodGiven>
     */
    public function getFoodGivens(): Collection
    {
        return $this->foodGivens;
    }

    public function addFoodGiven(FoodGiven $foodGiven): static
    {
        if (!$this->foodGivens->contains($foodGiven)) {
            $this->foodGivens->add($foodGiven);
            $foodGiven->setAnimal($this);
        }

        return $this;
    }

    public function removeFoodGiven(FoodGiven $foodGiven): static
    {
        if ($this->foodGivens->removeElement($foodGiven)) {
            // set the owning side to null (unless already changed)
            if ($foodGiven->getAnimal() === $this) {
                $foodGiven->setAnimal(null);
            }
        }

        return $this;
    }
}
