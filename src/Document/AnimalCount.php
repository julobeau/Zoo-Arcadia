<?php
// src/Document/Product.php
namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document]
class AnimalCount
{
    #[MongoDB\Id]
    protected string $id;

    #[MongoDB\Field(type: 'int')]
    protected int $animalId;

    #[MongoDB\Field(type: 'int')]
    protected int $clickCount;

    /**
     * Get the value of id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param string $id
     *
     * @return self
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of animalId
     *
     * @return int
     */
    public function getAnimalId(): int
    {
        return $this->animalId;
    }

    /**
     * Set the value of animalId
     *
     * @param int $animalId
     *
     * @return self
     */
    public function setAnimalId(int $animalId): self
    {
        $this->animalId = $animalId;

        return $this;
    }

    /**
     * Get the value of clickCount
     *
     * @return int
     */
    public function getClickCount(): int
    {
        return $this->clickCount;
    }

    /**
     * Set the value of clickCount
     *
     * @param int $clickCount
     *
     * @return self
     */
    public function setClickCount(int $clickCount): self
    {
        $this->clickCount = $clickCount;

        return $this;
    }
}