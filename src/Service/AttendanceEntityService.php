<?php

namespace App\Service;

use App\Entity\AbstractEntity;
use App\Entity\AttendanceEntity;
use App\Entity\MemberEntity;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AttendanceEntityService extends AbstractEntityService
{

    private $memberEntityService;
    private $departmentEntityService;

    public function __construct(
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        MemberEntityService $memberEntityService,
        DepartmentEntityService $departmentEntityService
    )
    {
        parent::__construct($entityManager, $slugger);
        $this->memberEntityService = $memberEntityService;
        $this->departmentEntityService = $departmentEntityService;
    }

    public static $entityFqn = AttendanceEntity::class;


    public function createNew(int $memberId, int $departmentId) : ?AttendanceEntity
    {



        $member = $this->memberEntityService->get($memberId) ?? null;
        $department = $this->departmentEntityService->get($departmentId) ?? null;


        if(!$member || !$department) return null;

        $newAttendance = new AttendanceEntity();
        $now = new \DateTime();

        $newAttendance
            ->setDate($now)
            ->setMember($member)
            ->setDepartment($department);


        return $newAttendance;
    }

    public function storeAttendance(AbstractEntity $entity) : AbstractEntityService
    {
        return parent::store($entity);
    }


}