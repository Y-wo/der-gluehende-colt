<?php

namespace App\Service;

use App\Entity\AttendanceEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AttendanceEntityService extends AbstractEntityService
{

    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        parent::__construct($entityManager, $slugger);
    }

    public static $entityFqn = AttendanceEntity::class;
}