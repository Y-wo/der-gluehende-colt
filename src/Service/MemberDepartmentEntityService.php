<?php

namespace App\Service;

use App\Entity\MemberDepartmentEntity;
use App\Entity\MemberEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class MemberDepartmentEntityService extends AbstractEntityService
{
    protected $departmentEntityService;

    public function __construct(
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        DepartmentEntityService $departmentEntityService
    )
    {
        parent::__construct($entityManager, $slugger);
        $this->departmentEntityService = $departmentEntityService;
    }

    public static $entityFqn = MemberDepartmentEntity::class;

    public function getMemberDepartmentEntity($memberId, $departmentId)
    {
        return $this->entityManager->getRepository(static::$entityFqn)->findOneBy(
            [
                'memberId' => $memberId,
                'departmentId' => $departmentId
            ]
        );
    }

    public function getDepartmentsOfMember(
        int $memberId
    ){

        $queryBuilder = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->innerJoin('r.member', 'm')
            ->innerJoin('r.department', 'd')
            ->select('d.name')
            ->where('m.id = :member_id')
            ->setParameter('member_id', $memberId)#
        ;

        $query = $queryBuilder->getQuery();
        $departmentsOfMember = $query->execute();

        return $departmentsOfMember;
    }

    public function createNewMembership(MemberEntity $member, int $departmentId){
        $department = $this->departmentEntityService->get($departmentId);
        $newMemberDepartment = new MemberDepartmentEntity();
        $newMemberDepartment
            ->setMember($member)
            ->setDepartment($department);

        $this->store($newMemberDepartment);
    }
}