<?php

namespace App\Service;

use App\Entity\AnimalCategoryEntity;
use App\Entity\TestEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AnimalEntityService extends AbstractEntityService
{

    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        parent::__construct($entityManager, $slugger);
    }

    public static $entityFqn = AnimalCategoryEntity::class;
}