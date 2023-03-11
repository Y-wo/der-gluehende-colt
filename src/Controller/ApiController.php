<?php

namespace App\Controller;

use App\Entity\AdminEntity;
use App\Entity\AttendanceEntity;
use App\Entity\LocationEntity;
use App\Entity\MemberDepartmentEntity;
use App\Entity\MemberEntity;
use App\Service\AdminEntityService;
use App\Service\AttendanceEntityService;
use App\Service\DepartmentEntityService;
use App\Service\LocationEntityService;
use App\Service\MemberDepartmentEntityService;
use App\Service\MemberEntityService;
use App\Service\ResponseService;
use App\Service\SerializerService;

use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api', name: 'api_')]
class ApiController extends AbstractController
{
    #[Route(path: '/test', name: 'test')]
    public function test(
        SerializerService $serializerService,
        MemberDepartmentEntityService $memberDepartmentService,
    ): Response
    {
        $testEntity = $memberDepartmentService->getAll();
        $serializedObject = $serializerService->serializeObject($testEntity);
        return new JsonResponse($serializedObject, 200, [], true);
    }


    #[Route(path: '/member', name: 'get_members')]
    public function returnMembers(
        MemberEntityService $memberEntityService,
        ResponseService $responseService
    ): Response
    {
        $members = $memberEntityService
            ->getAllMembers();

        return $responseService->convertObjectToJsonResponse($members);
    }


    #[Route(path: '/member/{id}', name: 'get_member')]
    public function returnMember(
        MemberEntityService $memberEntityService,
        ResponseService $responseService,
        int $id
    ): Response
    {
        $member = $memberEntityService
            ->getMember($id);

        return $responseService->convertObjectToJsonResponse($member);
    }

    #[Route(path: '/create-member', name: 'create_member')]
    public function createNewMember(
        MemberEntityService $memberEntityService,
        ResponseService $responseService,
        LocationEntityService $locationEntityService,
        MemberDepartmentEntityService $memberDepartmentEntityService,
        DepartmentEntityService $departmentEntityService,
        Request $request,
    ): Response
    {
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

            $message = "Created new member with ID " . $newMember->getId();
            $status = Response::HTTP_OK;
        }else{
            $message = "Could not create new Member.";
            $status = Response::HTTP_BAD_REQUEST;
        }

        return $this->redirectToRoute('members', [
            $message,
            $status
        ]);

    }


    #[Route(path: '/birthdays', name: 'get_birthdays')]
    public function getBirthdays(
        MemberEntityService $memberEntityService,
        ResponseService $responseService
    ): Response
    {
        $members = $memberEntityService
            ->getMembersWhoseBirthdayIsComing();

        return $responseService->convertObjectToJsonResponse($members);
    }


    #[Route(path: '/attendance', name: 'get_attendance')]
    public function returnAttendance(
        AttendanceEntityService $attendanceEntityService,
        ResponseService $responseService
    ): Response
    {
        $attendance = $attendanceEntityService->getAll();
        return $responseService->convertObjectToJsonResponse($attendance);
    }


    #[Route(path: '/handle-attendance/{memberId}/{departmentId}', name: 'attendance')]
    public function handleAttendance(
        AttendanceEntityService $attendanceEntityService,
        ResponseService $responseService,
        int $memberId,
        int $departmentId
    ): Response
    {
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
        ResponseService $responseService
    ): Response
    {
        $department = $departmentEntityService->getAll();
        return $responseService->convertObjectToJsonResponse($department);
    }


    #[Route(path: '/location', name: 'get_location')]
    public function returnLocation(
        LocationEntityService $locationEntityService,
        ResponseService $responseService
    ): Response
    {
        $location = $locationEntityService->getAll();
        return $responseService->convertObjectToJsonResponse($location);
    }


    #[Route(path: '/member-department', name: 'get_member_department')]
    public function returnMemberDepartment(
        MemberDepartmentEntityService $memberDepartmentEntityService,
        ResponseService $responseService
    ): Response
    {
        $memberDepartment = $memberDepartmentEntityService->getAll();
        return $responseService->convertObjectToJsonResponse($memberDepartment);
    }
}