<?php

namespace App\Controller;

use App\Service\AdminEntityService;
use App\Service\AttendanceEntityService;
use App\Service\AuthenticationService;
use App\Service\DepartmentEntityService;
use App\Service\JwtService;
use App\Service\LocationEntityService;
use App\Service\MemberDepartmentEntityService;
use App\Service\MemberEntityService;
use App\Service\ResponseService;
use App\Service\SerializerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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



    #[Route(path: '/login', name: 'login')]
    public function login(
        AuthenticationService $authenticationService,
        AdminEntityService $adminEntityService,
        Request $request
    ): Response
    {
        // übergebe die Daten an authenticationChecker
        // überprüfe, ob Admin mit ID ! existiert und ob das Passwort übereinstimmt

//        $memberId = $request->request->get('memberId');
//        $password = $request->request->get('password');
//
//        $isLoginCorrect = $authenticationService
//            ->checkLoginData(
//                $memberId,
//                $password
//            );
//
//        return new Response($password);






        $response = $adminEntityService->getPasswortByMemberId(5);



        return new Response($response );
    }


    #[Route(path: '/test', name: 'test')]
    public function test(
        JwtService $jwtService
    ): Response
    {

        $jwt = $jwtService->createJwt();

        return new Response($jwt);
    }


    #[Route(path: '/attendance', name: 'attendance')]
    public function attendance(): Response
    {
        return $this->render("attendance.html.twig");
    }


    #[Route(path: '/birthday', name: 'birthday')]
    public function birthday(): Response
    {
        return $this->render("birthday.html.twig");
    }




}