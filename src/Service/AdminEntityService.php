<?php

namespace App\Service;

use App\Entity\AdminEntity;
use App\Entity\MemberEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminEntityService extends AbstractEntityService
{
    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        parent::__construct($entityManager, $slugger);
    }

    public static $entityFqn = AdminEntity::class;

    public function getEmail() : String
    {
        /** @var AdminEntity $admin */
        $admin = $this->get(2);
        /** @var MemberEntity $adminMember */
        $adminMember = $admin->getMember();
        $email = $adminMember->getEmail();
        return $email;
    }

    public function getPasswortByMemberId(
        int $memberId
    )
//    : ?string
    {
        $queryBuilder = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->innerJoin('r.member', 'm')
            ->select('r.password')
            ->andWhere('m.id = :member_id')
            ->setParameter('member_id', $memberId)
        ;

        $query = $queryBuilder->getQuery();
        $password = $query->execute();

        if($password == null){
            return $password;
        }else{
            return $password[0]['password'];
        }


//        return $password[0]['password'];
    }


    public function getPasswortByEmail(
        String $email
    ) : ?array
    {
        $queryBuilder = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->innerJoin('r.member', 'm')
            ->select('r.password')
            ->andWhere('m.email = :member_email')
            ->setParameter('member_email', $email)
        ;

        $query = $queryBuilder->getQuery();
        $password = $query->execute();
        return $password;
    }

    public function getTest()
    {
        $queryBuilder = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->innerJoin('r.member', 'm')
            ->select()
            ->andWhere('m.email = :member_email')
            ->setParameter('member_email', 'asdf')
            ;

        $query = $queryBuilder->getQuery();

        $result = $query->execute();

        return $result;
    }

}