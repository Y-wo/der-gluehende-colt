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

    public function getMembersDepartmentAttendancesToday(int $memberId, int $departmentId) : bool|array
    {
        $member = $this->memberEntityService->get($memberId) ?? null;
        $department = $this->departmentEntityService->get($departmentId) ?? null;

        if(!$member || !$department) return false;

        $todayMidnight = new \DateTime('today');
        $queryBuilder = $this
            ->getRepository()
            ->createQueryBuilder('r');

        $query = $queryBuilder
            ->where('r.date > :todayMidnight')
            ->andWhere('r.member = :member')
            ->andWhere('r.department = :department')
            ->setParameter('todayMidnight', $todayMidnight)
            ->setParameter('member', $member)
            ->setParameter('department', $department)
            ->getQuery();

        return $query->execute();

    }

    public function isMemberInDepartmentInAttendanceToday(array $attendances): bool
    {
//        $result = $this->getMembersDepartmentAttendancesToday($memberId, $departmentId);

        return count($attendances) > 0;
    }

    public function storeAttendance(AbstractEntity $entity) : AbstractEntityService
    {
        return parent::store($entity);
    }

    public function removeAttendance(AbstractEntity $entity) : AbstractEntityService
    {
        return parent::remove($entity);
    }


}