<?php

namespace App\Entity;

use App\Repository\LocationEntityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationEntityRepository::class)]
class LocationEntity extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    #[ORM\Column(length: 255)]
    private ?int $zip = null;

    #[ORM\Column(length: 255)]
    private ?string $locus = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getZip(): ?int
    {
        return $this->zip;
    }

    public function setZip(int $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getLocus(): ?string
    {
        return $this->locus;
    }

    public function setLocus(string $locus): self
    {
        $this->locus = $locus;

        return $this;
    }
}
