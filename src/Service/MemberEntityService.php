<?php

namespace App\Service;

use App\Entity\AttendanceEntity;
use App\Entity\MemberEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class MemberEntityService extends AbstractEntityService
{
    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        parent::__construct($entityManager, $slugger);
    }

    public static $entityFqn = MemberEntity::class;


    public function getAllMembersWithExtensiveData(
    ) :array
    {
        $queryBuilder = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->select('r')
        ;

        $query = $queryBuilder->getQuery();
        $memberWithExtensiveData = $query->execute();
        return $memberWithExtensiveData;
    }

    public function getMemberWithExtensiveData(
        int $memberId
    ) : array
    {
        $queryBuilder = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->andWhere('r.id = :member_id')
            ->setParameter('member_id', $memberId)
            ->select('r')
        ;

        $query = $queryBuilder->getQuery();
        $memberWithExtensiveData = $query->execute();
        return $memberWithExtensiveData;
    }

}