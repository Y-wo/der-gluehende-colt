<?php

namespace App\Entity;

use App\Repository\MemberDepartmentEntityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberDepartmentEntityRepository::class)]
class MemberDepartmentEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $memberId = null;

    #[ORM\Column]
    private ?int $departmentId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMemberId(): ?int
    {
        return $this->memberId;
    }

    public function setMemberId(int $memberId): self
    {
        $this->memberId = $memberId;

        return $this;
    }

    public function getDepartmentId(): ?int
    {
        return $this->departmentId;
    }

    public function setDepartmentId(int $departmentId): self
    {
        $this->departmentId = $departmentId;

        return $this;
    }

}
