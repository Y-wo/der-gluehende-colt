<?php

namespace App\Controller;

use App\Entity\MemberEntity;
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

    #[Route(path: '/members', name: 'members')]
    public function members(
        Request $request
    ): Response
    {
        $message = $request->query->get('message') ?? null;

        return $this->render("members.html.twig", [
            'message' => $message
        ]);
    }

    #[Route(path: '/new-member', name: 'new_member')]
    public function newMember(
    ): Response
    {

        return $this->render("new_member.html.twig");
    }

    #[Route(path: '/member/{id}', name: 'member')]
    public function member(
        MemberEntityService $memberEntityService,
        LocationEntityService $locationEntityService,
        Request $request,
        int $id
    ): Response
    {
        $message = $request->query->get('message') ?? null;

        /** @var MemberEntity $member */
        $member = $memberEntityService->get($id);
        $attendances = $member->getAttendanceEntities()->toArray();
        $reversedAttendances = array_reverse($attendances);
        $memberDepartments = $member->getMemberDepartmentEntities()->toArray();

        return $this->render("member.html.twig", [
            'member' => $member,
            'attendances' => $reversedAttendances,
            'member_departments' => $memberDepartments,
            'message' => $message
        ]);
    }

    #[Route(path: '/edit-member/{id}', name: 'edit_member')]
    public function editMember(
        MemberEntityService $memberEntityService,
        LocationEntityService $locationEntityService,
        int $id
    ): Response
    {
        /** @var MemberEntity $member */
        $member = $memberEntityService->get($id);
        $memberDepartments = $member->getMemberDepartmentEntities()->toArray();
        $memberDepartmentIds = [];

        // create array for departmentIds where member has membership
        foreach($memberDepartments as $entry){
            $memberDepartmentIds[] = $entry->getDepartment()->getId();
        }

        return $this->render("edit_member.html.twig", [
            'member' => $member,
            'member_departments_ids' => $memberDepartmentIds
        ]);
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



    #[Route(path: '/birthday', name: 'birthday')]
    public function birthday(): Response
    {
        return $this->render("birthday.html.twig");
    }




}