<?php

namespace App\Service;

use App\Entity\AbstractEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

abstract class AbstractEntityService
{

    protected $entityManager;
    protected $slugger;

    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $this->entityManager = $entityManager;
        $this->slugger = $slugger;
    }

    public static $entityFqn;

    public function get(int $id)
//    : ?AbstractEntity
    {
        return $this
            ->entityManager
            ->getRepository(static::$entityFqn)
            ->find($id);
    }

    public function getAll()
//    : ?Array
    {
        return $this
            ->entityManager
            ->getRepository(static::$entityFqn)
            ->findAll();
    }

}