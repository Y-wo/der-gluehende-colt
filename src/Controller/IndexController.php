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
        return $this->render("index.html.twig");
    }

    #[Route(path: '/attendance', name: 'attendance')]
    public function attendance(): Response
    {
        return $this->render("attendance.html.twig");
    }

    #[Route(path: '/login', name: 'login')]
    public function login(): Response
    {
        return $this->render("");
    }

    #[Route(path: '/signin', name: 'signin')]
    public function signin(): Response
    {
        return $this->render("");
    }

    #[Route(path: '/birthday', name: 'birthday')]
    public function birthday(): Response
    {
        return $this->render("birthday.html.twig");
    }




}