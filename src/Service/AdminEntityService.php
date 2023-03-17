<?php

namespace App\Service;

use App\Entity\AbstractEntity;
use App\Entity\AdminEntity;
use App\Entity\MemberEntity;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Response;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminEntityService extends AbstractEntityService
{
    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger, MemberEntityService $memberEntityService)
    {
        parent::__construct($entityManager, $slugger);
        $this->memberEntityService = $memberEntityService;
    }

    public static $entityFqn = AdminEntity::class;
    public $memberEntityService;

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


    public function isAdmin(int $memberId){
        $queryBuilder = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->andWhere('r.member = :memberId')
            ->setParameter('memberId', $memberId)
        ;

        $query = $queryBuilder->getQuery();
        $result = $query->execute();
        return count($result) > 0;
    }

    public function createAdmin(int $memberId, string $password):self
    {
        $member = $this->memberEntityService->get($memberId);
        $newAdmin = new AdminEntity();

        // hash password
        $hashedPassword = hash('md5', $password);

        $newAdmin
            ->setMember($member)
            ->setPassword($hashedPassword);
        $this->entityManager->persist($newAdmin);

        $this->entityManager->flush();

        return $this;
    }

    public function changePassword(int $memberId, string $password):self
    {
        /** @var AdminEntity $admin */
        $admin = $this->getAdminByMemberId($memberId);
        $hashedPassword = hash('md5', $password);

        $admin->setPassword($hashedPassword);
        $this->entityManager->persist($admin);
        $this->entityManager->flush();

        return $this;
    }

    public function getAdminByMemberId(int $memberId) : ?AbstractEntity{
        $queryBuilder = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->where('r.member = :member_id')
            ->setParameter('member_id', $memberId)
            ;

        $query = $queryBuilder->getQuery();
        $result = $query->execute();

        if(count($result) > 0){
            return $result[0];
        }else{
            return null;
        }

    }


    public function removeAdmin(int $memberId){
        $queryBuilder = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->delete()
            ->where('r.member = :memberId')
            ->setParameter('memberId', $memberId)
        ;

        $query = $queryBuilder->getQuery();
        $result = $query->execute();

        return $result;
    }

    public function hashPassword(){

    }

}