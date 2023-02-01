<?php

namespace App\Service;

use App\Entity\DepartmentEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class DepartmentEntityService extends AbstractEntityService
{
    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        parent::__construct($entityManager, $slugger);
    }

    public static $entityFqn = DepartmentEntity::class;
}