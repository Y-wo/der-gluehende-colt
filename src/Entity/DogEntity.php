<?php

namespace App\Entity;

use App\Repository\DogEntityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DogEntityRepository::class)]
class DogEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $legs = null;

    #[ORM\Column(length: 255)]
    private ?string $noise = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    //origin: #[ORM\ManyToOne(inversedBy: 'dogEntities')]
    #[ORM\ManyToOne(targetEntity: AnimalCategoryEntity::class, inversedBy: 'DogEntity')]
    private ?AnimalCategoryEntity $AnimalCategoryEntity = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLegs(): ?int
    {
        return $this->legs;
    }

    public function setLegs(int $legs): self
    {
        $this->legs = $legs;

        return $this;
    }

    public function getNoise(): ?string
    {
        return $this->noise;
    }

    public function setNoise(string $noise): self
    {
        $this->noise = $noise;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAnimalCategoryEntity(): ?AnimalCategoryEntity
    {
        return $this->AnimalCategoryEntity;
    }

    public function setAnimalCategoryEntity(?AnimalCategoryEntity $AnimalCategoryEntity): self
    {
        $this->AnimalCategoryEntity = $AnimalCategoryEntity;

        return $this;
    }


}
