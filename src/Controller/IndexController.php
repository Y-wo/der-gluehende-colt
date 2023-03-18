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
    #[Route(path: '/login', name: 'login')]
    public function login(
        Request $request
    ): Response
    {
        $message = $request->query->get('message') ?? null;

        return $this->render("login.html.twig", [
            'message' => $message
        ]);
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(
    ): Response
    {
        return $this->render("logout.html.twig");
    }



    #[Route(path: '/', name: 'index')]
    public function index(
        Request $request
    ): Response
    {
//        $session = $request->getSession();
//        $session->set('test', 'hallo 123');
//        $session->clear();
//        $testSession = $session->get('test');

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
        AdminEntityService $adminEntityService,
        Request $request,
        int $id
    ): Response
    {
        $message = $request->query->get('message') ?? null;
        $isAdmin = $adminEntityService->isAdmin($id);

        /** @var MemberEntity $member */
        $member = $memberEntityService->get($id);
        $attendances = $member->getAttendanceEntities()->toArray();
        $reversedAttendances = array_reverse($attendances);
        $memberDepartments = $member->getMemberDepartmentEntities()->toArray();

        return $this->render("member.html.twig", [
            'member' => $member,
            'attendances' => $reversedAttendances,
            'member_departments' => $memberDepartments,
            'message' => $message,
            'isAdmin' => $isAdmin
        ]);
    }

    #[Route(path: '/edit-member/{id}', name: 'edit_member')]
    public function editMember(
        MemberEntityService $memberEntityService,
        LocationEntityService $locationEntityService,
        AdminEntityService $adminEntityService,
        int $id
    ): Response
    {
        /** @var MemberEntity $member */
        $member = $memberEntityService->get($id);
        $isAdmin = $adminEntityService->isAdmin($id);
        $memberDepartments = $member->getMemberDepartmentEntities()->toArray();
        $memberDepartmentIds = [];

        // create array for departmentIds where member has membership
        foreach($memberDepartments as $entry){
            $memberDepartmentIds[] = $entry->getDepartment()->getId();
        }

        return $this->render("edit_member.html.twig", [
            'member' => $member,
            'member_departments_ids' => $memberDepartmentIds,
            'isAdmin' => $isAdmin,
        ]);
    }


    #[Route(path: '/create-admin/{id}', name: 'create_admin')]
    public function createAdmin(
        MemberEntityService $memberEntityService,
        int $id
    ): Response
    {
        $member = $memberEntityService->get($id);

        return $this->render("new_admin.html.twig", [
            'member' => $member,
        ]);
    }

    #[Route(path: '/execute-creation-admin/{id}', name: 'execute_creation_admin')]
    public function executeCreationAdmin(
        AdminEntityService $adminEntityService,
        Request $request,
        int $id
    ): Response
    {
        $password = $request->request->get('password');
        $passwordConfirmation = $request->request->get('passwordConfirmation');

        if ($password == $passwordConfirmation){
            $adminEntityService->createAdmin($id, $password);

            $message = "New Admin created with ID " . $id;
            return $this->redirectToRoute('member', [
                'id' => $id,
                'message' => $message,
            ]);
        }
        $message = "Could not create new admin " . $id;
        return $this->redirectToRoute('member', [
            'id' => $id,
            'message' => $message,
        ]);
    }


    #[Route(path: '/edit-admin/{id}', name: 'edit_admin')]
    public function editAdmin(
        MemberEntityService $memberEntityService,
        int $id
    ): Response
    {
        $member = $memberEntityService->get($id);

        return $this->render("edit_admin.html.twig", [
            'member' => $member,
        ]);
    }

    #[Route(path: '/execute-editing-admin/{id}', name: 'execute_editing_admin')]
    public function executeEditingAdmin(
        AdminEntityService $adminEntityService,
        Request $request,
        int $id
    ): Response
    {
        $sentPassword = $request->request->get('password');
        $sentPasswordConfirmation = $request->request->get('passwordConfirmation');

        if ($sentPassword == $sentPasswordConfirmation){
            $adminEntityService->changePassword($id, $sentPassword );

            $message = "Password changed of member with ID" . $id;
            return $this->redirectToRoute('member', [
                'id' => $id,
                'message' => $message,
            ]);
        }
        $message = "Could not change password of member with ID " . $id;
        return $this->redirectToRoute('member', [
            'id' => $id,
            'message' => $message,
        ]);
    }

}