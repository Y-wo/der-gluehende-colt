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
}