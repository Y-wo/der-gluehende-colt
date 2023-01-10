<?php

namespace App\Service;

use App\Entity\TestEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\AbstractEntity;

class TestEntityService extends AbstractEntityService
{

    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        parent::__construct($entityManager, $slugger);
    }

    public static $entityFqn = TestEntity::class;

}