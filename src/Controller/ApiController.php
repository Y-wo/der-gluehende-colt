<?php

namespace App\Controller;

use App\Entity\AdminEntity;
use App\Entity\MemberEntity;
use App\Service\AdminEntityService;
use App\Service\AttendanceEntityService;
use App\Service\DepartmentEntityService;
use App\Service\LocationEntityService;
use App\Service\MemberDepartmentEntityService;
use App\Service\MemberEntityService;
use App\Service\ResponseService;
use App\Service\SerializerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api', name: 'api')]
class ApiController extends AbstractController
{
    #[Route(path: '/test', name: 'test')]
    public function test(
        SerializerService $serializerService,
        MemberEntityService $memberEntityService,
        MemberDepartmentEntityService $memberDepartmentService,
        AttendanceEntityService $attendanceEntityService,
        LocationEntityService $locationEntityService,
        DepartmentEntityService $departmentEntityService
    ): Response
    {
        $testEntity = $memberDepartmentService->getAll();
        $serializedObject = $serializerService->serializeObject($testEntity);
        return new JsonResponse($serializedObject, 200, [], true);
    }

    #[Route(path: '/member', name: 'member')]
    public function returnMember(
        MemberEntityService $memberEntityService,
        ResponseService $responseService
    ): Response
    {
        $members = $memberEntityService->getAll();
        return $responseService->convertObjectToJsonResponse($members);
    }


    #[Route(path: '/attendance', name: 'attendance')]
    public function returnAttendance(
        AttendanceEntityService $attendanceEntityService,
        ResponseService $responseService
    ): Response
    {
        $attendance = $attendanceEntityService->getAll();
        return $responseService->convertObjectToJsonResponse($attendance);
    }

    #[Route(path: '/department', name: 'department')]
    public function returnDepartment(
        DepartmentEntityService $departmentEntityService,
        ResponseService $responseService
    ): Response
    {
        $department = $departmentEntityService->getAll();
        return $responseService->convertObjectToJsonResponse($department);
    }

    #[Route(path: '/location', name: 'location')]
    public function returnLocation(
        LocationEntityService $locationEntityService,
        ResponseService $responseService
    ): Response
    {
        $location = $locationEntityService->getAll();
        return $responseService->convertObjectToJsonResponse($location);
    }

    #[Route(path: '/member-department', name: 'member_department')]
    public function returnMemberDepartment(
        MemberDepartmentEntityService $memberDepartmentEntityService,
        ResponseService $responseService
    ): Response
    {
        $memberDepartment = $memberDepartmentEntityService->getAll();
        return $responseService->convertObjectToJsonResponse($memberDepartment);
    }

}