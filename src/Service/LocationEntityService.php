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


    public function getLocationsByZip(int $zip){
        $queryBuilder = $this
            ->getRepository()
            ->createQueryBuilder('r');

        $query = $queryBuilder
            ->where('r.zip = :zip')
            ->setParameter('zip', $zip)
            ->getQuery();

        return $query->execute();
    }

    public function getLocation(int $id){
        $queryBuilder = $this
            ->getRepository()
            ->createQueryBuilder('r');

        $query = $queryBuilder
            ->where('r.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $query->execute();
    }


}