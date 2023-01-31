<?php

namespace App\Controller;

use App\Entity\AbstractEntity;
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
                <p>colt war - colt war?</p>
            </body>
                ");
    }

    #[Route(path: '/test', name: 'test')]
    public function test(
        SerializerInterface $serializerInterface,
        TestEntityService $testEntityService
    ): Response
    {


        $testEntity = $testEntityService->getAll();

        $testSerialized = $serializerInterface->serialize(
            $testEntity,
            "json"
        );
        return new JsonResponse($testSerialized, 200, [], true);
    }

}