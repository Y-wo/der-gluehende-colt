<?php

namespace App\Controller;

use App\Entity\AbstractEntity;
use App\Entity\DogEntity;
use App\Entity\MemberEntity;
use App\Service\AnimalEntityService;
use App\Service\DogEntityService;
use App\Service\MemberEntityService;
use App\Service\TestEntityService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;

class IndexController extends AbstractController
{

    #[Route(path: '/', name: 'index')]
    public function index(): Response
    {
        return new Response("
            <body>
                <p>colt war - colt war? - test 123</p>
            </body>
                ");
    }

    #[Route(path: '/test', name: 'test')]
    public function test(
        SerializerInterface $serializerInterface,
        AnimalEntityService $animalEntityService
    ): Response
    {
        $testEntity = $animalEntityService->getAll();

        $testSerialized = $serializerInterface->serialize(
            $testEntity,
            "json"
        );
        return new JsonResponse($testSerialized, 200, [], true);
    }


    #[Route(path: '/dog', name: 'dog')]
    public function dog2(
        SerializerInterface $serializerInterface,
        DogEntityService $dogEntityService,
        EntityManagerInterface $entityManager
    ): Response
    {
        $allDogs = $dogEntityService->getAll();
        $testSerialized = $serializerInterface->serialize(
            $allDogs,
            "json",
            //this removes unusable variables resulting from Doctrines 'Many-To-One-Logic'
            [
                'ignored_attributes' => [
                    '__initializer__',
                    '__cloner__',
                    '__isInitialized__'
                ]
            ]
        );

        return new JsonResponse($testSerialized, 200, [], true);
    }

    #[Route(path: '/member', name: 'member')]
    public function member(
        SerializerInterface $serializerInterface,
        MemberEntityService $memberEntityService,
        EntityManagerInterface $entityManager
    ): Response
    {
        $members = $memberEntityService->getAll();
        $membersSerialized = $serializerInterface->serialize(
            $members,
            "json",
            //this removes unusable variables resulting from Doctrines 'Many-To-One-Logic'
//            [
//                'ignored_attributes' => [
//                    '__initializer__',
//                    '__cloner__',
//                    '__isInitialized__'
//                ]
//            ]
        );

        return new JsonResponse($membersSerialized, 200, [], true);
    }


}