<?php

namespace App\Service;

use App\Entity\LocationEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class LocationEntityService extends AbstractEntityService
{

    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        parent::__construct($entityManager, $slugger);
    }

    public static $entityFqn = LocationEntity::class;
}