<?php

namespace App\Entity;

use App\Repository\MemberEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: MemberEntityRepository::class)]
class MemberEntity extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $street = null;

    #[ORM\Column(length: 255)]
    private ?string $houseNumber = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column]
    private ?bool $deleted = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private LocationEntity $location ;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: MemberDepartmentEntity::class)]
    private Collection $memberDepartmentEntities;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: AttendanceEntity::class)]
    #[Ignore]
    private collection $attendance;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthday = null;

    public function __construct()
    {
        $this->memberDepartmentEntities = new ArrayCollection();
        $this->attendance = new ArrayCollection();
        $this->location = new LocationEntity();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    public function setHouseNumber(string $houseNumber): self
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getLocation(): ?LocationEntity
    {
        return $this->location;
    }

    public function setLocation(?LocationEntity $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection<int, MemberDepartmentEntity>
     */
    public function getMemberDepartmentEntities(): Collection
    {
        return $this->memberDepartmentEntities;
    }

    public function addMemberDepartmentEntity(MemberDepartmentEntity $memberDepartmentEntity): self
    {
        if (!$this->memberDepartmentEntities->contains($memberDepartmentEntity)) {
            $this->memberDepartmentEntities->add($memberDepartmentEntity);
            $memberDepartmentEntity->setMember($this);
        }

        return $this;
    }

    public function removeMemberDepartmentEntity(MemberDepartmentEntity $memberDepartmentEntity): self
    {
        if ($this->memberDepartmentEntities->removeElement($memberDepartmentEntity)) {
            // set the owning side to null (unless already changed)
            if ($memberDepartmentEntity->getMember() === $this) {
                $memberDepartmentEntity->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AttendanceEntity>
     */
    public function getAttendanceEntities(): Collection
    {
        return $this->attendance;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }


}
