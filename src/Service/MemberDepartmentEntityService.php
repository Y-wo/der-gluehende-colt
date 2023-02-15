<?php

namespace App\Service;

use App\Entity\MemberDepartmentEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class MemberDepartmentEntityService extends AbstractEntityService
{
    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        parent::__construct($entityManager, $slugger);
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
}