<?php

namespace App\Entity;

use App\Repository\HabitatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HabitatRepository::class)]
class Habitat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $resume = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    /**
     * @var Collection<int, Animal>
     */
    #[ORM\OneToMany(targetEntity: Animal::class, mappedBy: 'habitat')]
    private Collection $animals;

    /**
     * @var Collection<int, ImagesHabitat>
     */
    #[ORM\OneToMany(targetEntity: ImagesHabitat::class, mappedBy: 'habitat', orphanRemoval: true)]
    private Collection $habitat;

    /**
     * @var Collection<int, RapportVeterinaireHabitat>
     */
    #[ORM\OneToMany(targetEntity: RapportVeterinaireHabitat::class, mappedBy: 'relation', orphanRemoval: true)]
    private Collection $report;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
        $this->habitat = new ArrayCollection();
        $this->report = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): static
    {
        $this->resume = $resume;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): static
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setHabitat($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getHabitat() === $this) {
                $animal->setHabitat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ImagesHabitat>
     */
    public function getHabitat(): Collection
    {
        return $this->habitat;
    }

    public function addHabitat(ImagesHabitat $habitat): static
    {
        if (!$this->habitat->contains($habitat)) {
            $this->habitat->add($habitat);
            $habitat->setHabitat($this);
        }

        return $this;
    }

    public function removeHabitat(ImagesHabitat $habitat): static
    {
        if ($this->habitat->removeElement($habitat)) {
            // set the owning side to null (unless already changed)
            if ($habitat->getHabitat() === $this) {
                $habitat->setHabitat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RapportVeterinaireHabitat>
     */
    public function getReport(): Collection
    {
        return $this->report;
    }

    public function addReport(RapportVeterinaireHabitat $report): static
    {
        if (!$this->report->contains($report)) {
            $this->report->add($report);
            $report->setRelation($this);
        }

        return $this;
    }

    public function removeReport(RapportVeterinaireHabitat $report): static
    {
        if ($this->report->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getRelation() === $this) {
                $report->setRelation(null);
            }
        }

        return $this;
    }
}
