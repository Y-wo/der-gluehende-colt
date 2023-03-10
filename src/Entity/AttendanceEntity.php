<?php

namespace App\Entity;

use App\Repository\AttendanceEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: AttendanceEntityRepository::class)]
class AttendanceEntity extends AbstractEntity
{

//    Wert vorher hier: private ?int $id = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;


    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    private ?MemberEntity $member = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?DepartmentEntity $department = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getMember(): ?MemberEntity
    {
        return $this->member;
    }

    public function setMember(?AbstractEntity $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function getDepartment(): ?DepartmentEntity
    {
        return $this->department;
    }

    public function setDepartment(?AbstractEntity $department): self
    {
        $this->department = $department;

        return $this;
    }
}
