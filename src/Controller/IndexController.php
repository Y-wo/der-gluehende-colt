<?php

namespace App\Controller;

use App\Entity\LocationEntity;
use App\Entity\MemberEntity;
use App\Service\AdminEntityService;
use App\Service\LocationEntityService;
use App\Service\LoginService;
use App\Service\MemberDepartmentEntityService;
use App\Service\MemberEntityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private LoginService $loginService;

    public function __construct(
        LoginService $loginService
    )
    {
        $this->loginService = $loginService;
    }

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

    #[Route(path: '/check-login', name: 'check_login')]
    public function checkLogin(
        Request $request,
        LoginService $loginService
    ): Response
    {
        //check if userData are correct
        $isAuthorized = $loginService->authenticate($request);

        if(!$isAuthorized){
            $message = "Login nicht möglich.";
            return $this->redirectToRoute('login', [
                'message' => $message,
            ]);
        }else{
            $message = "Herzlich Willkommen";
            return $this->redirectToRoute('index', [
                'message' => $message,
            ]);
        }
    }


    #[Route(path: '/logout', name: 'logout')]
    public function logout(
        Request $request
    ): Response
    {
        $this->loginService->clearSession($request);
        return $this->redirectToRoute('login');
    }

    #[Route(path: '/', name: 'index')]
    public function index(
        Request $request
    ): Response
    {
        if(!$this->loginService->isLoggedIn($request)){
            return $this->redirectToRoute('login');
        };

        return $this->render("index.html.twig");
    }

    #[Route(path: '/members', name: 'members')]
    public function members(
        Request $request
    ): Response
    {
        if(!$this->loginService->isLoggedIn($request)){
            return $this->redirectToRoute('login');
        };

        $message = $request->query->get('message') ?? null;

        return $this->render("members.html.twig", [
            'message' => $message
        ]);
    }

    #[Route(path: '/new-member', name: 'new_member')]
    public function newMember(
        Request $request
    ): Response
    {
        if(!$this->loginService->isLoggedIn($request)){
            return $this->redirectToRoute('login');
        };

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
        if(!$this->loginService->isLoggedIn($request)){
            return $this->redirectToRoute('login');
        };

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
        AdminEntityService $adminEntityService,
        Request $request,
        int $id
    ): Response
    {
        if(!$this->loginService->isLoggedIn($request)){
            return $this->redirectToRoute('login');
        };

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

    #[Route(path: '/save-member/{id}', name: 'save_member')]
    public function saveMember(
        MemberEntityService $memberEntityService,
        LocationEntityService $locationEntityService,
        Request $request,
        MemberDepartmentEntityService $memberDepartmentEntityService,
        int $id
    ): Response
    {
        if(!$this->loginService->isLoggedIn($request)){
            return $this->redirectToRoute('login');
        };

        $memberInfos = $memberEntityService->createRequestMemberAssociativeArray($request);
        /** @var MemberEntity $member */
        $member = $memberEntityService->get($id);

        if($member->getFirstname() != $memberInfos['firstName']){
            $member->setFirstName($memberInfos['firstName']);
        };
        if($member->getLastname() != $memberInfos['lastName']){
            $member->setLastName($memberInfos['lastName']);
        };
        if($member->getEmail() != $memberInfos['email']){
            $member->setEmail($memberInfos['email']);
        };
        if($member->getStreet() != $memberInfos['street']){
            $member->setStreet($memberInfos['street']);
        };
        if($member->getBirthday() != $memberInfos['birthday']){
            $member->setBirthday($memberInfos['birthday']);
        };
        if($member->getPhone() != $memberInfos['phone']){
            $member->setPhone($memberInfos['phone']);
        };

        if($member->getHouseNumber() != $memberInfos['houseNumber']){
            $member->setHouseNumber($memberInfos['houseNumber']);
        };

        $membersZip = $member->getLocation()->getZip();

        if($membersZip != $memberInfos['zip'] ){
            // check if locationEntity already exists and if not create new one
            $locations = $locationEntityService->getLocationsByZip($memberInfos['zip']);
            if(count($locations) == 0)
            {
                $location = new LocationEntity();
                $location
                    ->setZip($memberInfos['zip'])
                    ->setLocus($memberInfos['locus'])
                ;
                $locationEntityService->store($location);
            }else{
                $location = $locations[0];
            }

            $member->setLocation($location);
        }

        $membersDepartments = $memberDepartmentEntityService->getDepartmentsOfMember($id);

        if($memberEntityService->store($member)){
            if(
                $memberInfos['gun'] == true &&
                !$memberEntityService->isDepartmentInDepartmentsOfMember($membersDepartments, 1)
            ){
                $memberDepartmentEntityService->createNewMembership($member, 1);
            }elseif (
                $memberInfos['gun'] != true &&
                $memberEntityService->isDepartmentInDepartmentsOfMember($membersDepartments, 1)
            ){
                $memberDepartmentEntityService->removeMemberDepartmentByIds($id, 1);
            }

            if($memberInfos['bow'] == true &&
                !$memberEntityService->isDepartmentInDepartmentsOfMember($membersDepartments, 2)
            ){
                $memberDepartmentEntityService->createNewMembership($member, 2);
            }elseif (
                $memberInfos['bow'] != true &&
                $memberEntityService->isDepartmentInDepartmentsOfMember($membersDepartments, 2)
            ){
                $memberDepartmentEntityService->removeMemberDepartmentByIds($id, 2);
            }

            if($memberInfos['airPressure'] == true &&
                !$memberEntityService->isDepartmentInDepartmentsOfMember($membersDepartments, 3)
            ){
                $memberDepartmentEntityService->createNewMembership($member, 3);
            }elseif (
                $memberInfos['airPressure'] != true &&
                $memberEntityService->isDepartmentInDepartmentsOfMember($membersDepartments, 3)
            ){
                $memberDepartmentEntityService->removeMemberDepartmentByIds($id, 3);
            }

            $message = "Mitglied angepasst mit der ID " . $member->getId();
            $status = Response::HTTP_OK;
        }else{
            $message = "Mitgliedanpassung nicht möglich.";
            $status = Response::HTTP_BAD_REQUEST;
        }

        return $this->redirectToRoute('member', [
                'id' => $member->getId(),
                'message' => $message,
                'status' => $status
            ]

        );
    }

    #[Route(path: '/delete-member/{id}', name: 'delete_member')]
    public function deleteMember(
        MemberEntityService $memberEntityService,
        Request $request,
        int $id
    ): Response
    {
        if(!$this->loginService->isLoggedIn($request)){
            return $this->redirectToRoute('login');
        };

        $memberEntityService->setMemberDeleted($id);
        $message = "Mitglied gelöscht mit der ID " . $id;
        return $this->redirectToRoute("members", [
            'message' => $message
        ]);
    }


    #[Route(path: '/create-new-member', name: 'create_new_member')]
    public function createNewMember(
        MemberEntityService $memberEntityService,
        LocationEntityService $locationEntityService,
        MemberDepartmentEntityService $memberDepartmentEntityService,
        Request $request,
    ): Response
    {
        if(!$this->loginService->isLoggedIn($request)){
            return $this->redirectToRoute('login');
        };

        $newMember = new MemberEntity();

        $firstName = $request->request->get('firstName');
        $lastName = $request->request->get('lastName');
        $email = $request->request->get('email');
        $street = $request->request->get('street');
        $houseNumber = $request->request->get('houseNumber');
        $zip = $request->request->get('zip');
        $locus = $request->request->get('locus');
        $phone = $request->request->get('phone');
        $birthday = new \DateTime($request->request->get('birthday'));
        $gun = $request->request->get('gun');
        $bow = $request->request->get('bow');
        $airPressure = $request->request->get('airPressure');
        $createdAt = new \DateTimeImmutable();


        // check if locationEntity already exists and if not create new one
        $locations = $locationEntityService->getLocationsByZip($zip);
        if(count($locations) == 0)
        {
            $location = new LocationEntity();
            $location
                ->setZip($zip)
                ->setLocus($locus)
            ;
            $locationEntityService->store($location);
        }else{
            $location = $locations[0];
        }

        $newMember
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setStreet($street)
            ->setHouseNumber($houseNumber)
            ->setPhone($phone)
            ->setBirthday($birthday)
            ->setLocation($location)
            ->setCreatedAt($createdAt)
            ->setDeleted(0)
        ;

        if($memberEntityService->store($newMember)){

            if($gun){
                $memberDepartmentEntityService->createNewMembership($newMember, 1);
            }

            if($bow){
                $memberDepartmentEntityService->createNewMembership($newMember, 2);
            }

            if($airPressure){
                $memberDepartmentEntityService->createNewMembership($newMember, 3);
            }

            $message = "Neues Mitglied angelegt mit der ID " . $newMember->getId();
            $status = Response::HTTP_OK;
        }else{
            $message = "Neuanlegung nicht möglich.";
            $status = Response::HTTP_BAD_REQUEST;
        }

        return $this->redirectToRoute('members', [
            "message" => $message,
            "status" => $status
        ]);

    }


    #[Route(path: '/create-admin/{id}', name: 'create_admin')]
    public function createAdmin(
        MemberEntityService $memberEntityService,
        Request $request,
        int $id
    ): Response
    {
        if(!$this->loginService->isLoggedIn($request)){
            return $this->redirectToRoute('login');
        };

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
        if(!$this->loginService->isLoggedIn($request)){
            return $this->redirectToRoute('login');
        };

        $password = $request->request->get('password');
        $passwordConfirmation = $request->request->get('passwordConfirmation');

        if ($password == $passwordConfirmation){
            $adminEntityService->createAdmin($id, $password);

            $message = "Neuer Administrator angelegt mit der ID " . $id;
            return $this->redirectToRoute('member', [
                'id' => $id,
                'message' => $message,
            ]);
        }
        $message = "Konnte keinen neuen Administrator anlegen - ID " . $id;
        return $this->redirectToRoute('member', [
            'id' => $id,
            'message' => $message,
        ]);
    }


    #[Route(path: '/edit-admin/{id}', name: 'edit_admin')]
    public function editAdmin(
        MemberEntityService $memberEntityService,
        Request $request,
        int $id
    ): Response
    {
        if(!$this->loginService->isLoggedIn($request)){
            return $this->redirectToRoute('login');
        };

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
        if(!$this->loginService->isLoggedIn($request)){
            return $this->redirectToRoute('login');
        };

        $sentPassword = $request->request->get('password');
        $sentPasswordConfirmation = $request->request->get('passwordConfirmation');

        if ($sentPassword == $sentPasswordConfirmation){
            $adminEntityService->changePassword($id, $sentPassword );

            $message = "Passwort verändert für Mitglied mit der ID" . $id;
            return $this->redirectToRoute('member', [
                'id' => $id,
                'message' => $message,
            ]);
        }
        $message = "Konnte Paswort nicht anpassen für Mitglied mit der ID " . $id;
        return $this->redirectToRoute('member', [
            'id' => $id,
            'message' => $message,
        ]);
    }

}