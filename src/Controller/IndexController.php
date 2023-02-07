<?php

namespace App\Controller;

use App\Service\AttendanceEntityService;
use App\Service\DepartmentEntityService;
use App\Service\LocationEntityService;
use App\Service\MemberDepartmentEntityService;
use App\Service\MemberEntityService;
use App\Service\ResponseService;
use App\Service\SerializerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class IndexController extends AbstractController
{

    #[Route(path: '/', name: 'index')]
    public function index(): Response
    {
        return new Response("
            <body>
                <p>Yo hallo metalleudee (:</p>
            </body>
                ");
    }
}