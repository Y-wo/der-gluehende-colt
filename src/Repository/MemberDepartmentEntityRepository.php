<?php

namespace App\Repository;

use App\Entity\MemberDepartmentEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MemberDepartmentEntity>
 *
 * @method MemberDepartmentEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemberDepartmentEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemberDepartmentEntity[]    findAll()
 * @method MemberDepartmentEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberDepartmentEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemberDepartmentEntity::class);
    }

    public function save(MemberDepartmentEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MemberDepartmentEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MemberDepartmentEntity[] Returns an array of MemberDepartmentEntity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MemberDepartmentEntity
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
