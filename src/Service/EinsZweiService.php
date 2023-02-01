<?php

namespace App\Service;

use App\Entity\EinsZwei;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class EinsZweiService extends AbstractEntityService
{
    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        parent::__construct($entityManager, $slugger);
    }

    public static $entityFqn = EinsZwei::class;

    public function getByCompositeKey($memberEntityId, $locationEntityId)
    {
        return $this->entityManager->getRepository(static::$entityFqn)->findOneBy(
            [
                'member_entity_id' => $memberEntityId,
                'location_entity_id' => $locationEntityId
                ]);
    }
}