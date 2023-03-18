<?php

namespace App\Controller;

use App\Service\AttendanceEntityService;
use App\Service\DepartmentEntityService;
use App\Service\JwtService;
use App\Service\LocationEntityService;
use App\Service\LoginService;
use App\Service\MemberDepartmentEntityService;
use App\Service\MemberEntityService;
use App\Service\ResponseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api', name: 'api_')]
class ApiController extends AbstractController
{
    private LoginService $loginService;
    private JwtService $jwtService;

    public function __construct(
        LoginService $loginService,
        JwtService $jwtService
    )
    {
        $this->loginService = $loginService;
        $this->jwtService = $jwtService;
    }

    #[Route(path: '/get-jwt', name: 'get_jwt')]
    public function getJwt(
        Request $request
    ): Response
    {
        if(!$this->loginService->isLoggedIn($request)){
            return new Response('no access',Response::HTTP_BAD_REQUEST);
        };

        $session = $request->getSession();
        $jwt = $session->get('jwt');

        return new Response($jwt, Response::HTTP_OK);
    }


    #[Route(path: '/member', name: 'get_members')]
    public function returnMembers(
        MemberEntityService $memberEntityService,
        ResponseService $responseService,
        Request $request
    ): Response
    {
        if(!$this->jwtService->checkJwt($request)){
            return new Response("no access", Response::HTTP_BAD_REQUEST);
        }

        $members = $memberEntityService
            ->getAllMembers();

        return $responseService->convertObjectToJsonResponse($members);
    }


    #[Route(path: '/member/{id}', name: 'get_member')]
    public function returnMember(
        MemberEntityService $memberEntityService,
        ResponseService $responseService,
        Request $request,
        int $id
    ): Response
    {
        if(!$this->jwtService->checkJwt($request)){
            return new Response("no access", Response::HTTP_BAD_REQUEST);
        }

        $member = $memberEntityService
            ->getMember($id);

        return $responseService->convertObjectToJsonResponse($member);
    }


    #[Route(path: '/birthdays', name: 'get_birthdays')]
    public function getBirthdays(
        MemberEntityService $memberEntityService,
        ResponseService $responseService,
        Request $request
    ): Response
    {
        if(!$this->jwtService->checkJwt($request)){
            return new Response("no access", Response::HTTP_BAD_REQUEST);
        }

        $members = $memberEntityService
            ->getMembersWhoseBirthdayIsComing();

        return $responseService->convertObjectToJsonResponse($members);
    }


    #[Route(path: '/attendance', name: 'get_attendance')]
    public function returnAttendance(
        AttendanceEntityService $attendanceEntityService,
        ResponseService $responseService,
        Request $request
    ): Response
    {
        if(!$this->jwtService->checkJwt($request)){
            return new Response("no access", Response::HTTP_BAD_REQUEST);
        }

        $attendance = $attendanceEntityService->getAll();
        return $responseService->convertObjectToJsonResponse($attendance);
    }


    #[Route(path: '/handle-attendance/{memberId}/{departmentId}', name: 'attendance')]
    public function handleAttendance(
        AttendanceEntityService $attendanceEntityService,
        Request $request,
        int $memberId,
        int $departmentId
    ): Response
    {
        if(!$this->jwtService->checkJwt($request)){
            return new Response("no access", Response::HTTP_BAD_REQUEST);
        }

        $membersDepartmentAttendancesToday = $attendanceEntityService
            ->getMembersDepartmentAttendancesToday($memberId, $departmentId);

        // check if member already is stored as in attendance today
        if(count($membersDepartmentAttendancesToday) > 0){

            //delete attendance(s) today
            foreach ($membersDepartmentAttendancesToday as $attendance){
                $attendanceEntityService->remove($attendance);
            }

            $message = "Deleted All attendanceEntities today for member " . $memberId .  " in department " . $departmentId;
            $status = Response::HTTP_OK;

            return new Response($message, $status);
        }

        // store new attendance for member in chosen department
        $newAttendance = $attendanceEntityService->createNew($memberId, $departmentId);

        // check if it is possible to create an attendance for chosen member and chosen department
        if(!$newAttendance) {
            $message = "Could not create new attendanceEntity for member " . $memberId .  " and department " . $departmentId;
            $status = Response::HTTP_NOT_FOUND;
            return new Response($message, $status);
        }

        $attendanceEntityService->store($newAttendance);
        $message = "New attendanceEntity stored for member " . $memberId .  " and department " . $departmentId;
        $status = Response::HTTP_CREATED;

        return new Response($message, $status);
    }


    #[Route(path: '/department', name: 'get_department')]
    public function returnDepartment(
        DepartmentEntityService $departmentEntityService,
        ResponseService $responseService,
        Request $request
    ): Response
    {
        if(!$this->jwtService->checkJwt($request)){
            return new Response("no access", Response::HTTP_BAD_REQUEST);
        }

        $department = $departmentEntityService->getAll();
        return $responseService->convertObjectToJsonResponse($department);
    }


    #[Route(path: '/location', name: 'get_location')]
    public function returnLocation(
        LocationEntityService $locationEntityService,
        ResponseService $responseService,
        Request $request
    ): Response
    {
        if(!$this->jwtService->checkJwt($request)){
            return new Response("no access", Response::HTTP_BAD_REQUEST);
        }

        $location = $locationEntityService->getAll();
        return $responseService->convertObjectToJsonResponse($location);
    }


    #[Route(path: '/member-department', name: 'get_member_department')]
    public function returnMemberDepartment(
        MemberDepartmentEntityService $memberDepartmentEntityService,
        ResponseService $responseService,
        Request $request
    ): Response
    {
        if(!$this->jwtService->checkJwt($request)){
            return new Response("no access", Response::HTTP_BAD_REQUEST);
        }

        $memberDepartment = $memberDepartmentEntityService->getAll();
        return $responseService->convertObjectToJsonResponse($memberDepartment);
    }

}