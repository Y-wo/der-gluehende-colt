<?php

namespace App\Entity;

use App\Repository\MemberDepartmentEntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: MemberDepartmentEntityRepository::class)]
class MemberDepartmentEntity extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    #[ORM\ManyToOne(inversedBy: 'memberDepartmentEntities')]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    private ?MemberEntity $member = null;

    #[ORM\ManyToOne(fetch: "EAGER")]
    #[ORM\JoinColumn(nullable: false)]
    private ?DepartmentEntity $department = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMember(): ?MemberEntity
    {
        return $this->member;
    }

    public function setMember(?MemberEntity $member): self
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
