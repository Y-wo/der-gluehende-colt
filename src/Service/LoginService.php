<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\MemberEntity;
use Symfony\Component\HttpFoundation\Request;

class LoginService{

    private MemberEntityService $memberEntityService;
    private AdminEntityService $adminEntityService;
    private JwtService $jwtService;

    public function __construct(
        MemberEntityService $memberEntityService,
        AdminEntityService $adminEntityService,
        JwtService $jwtService

    )
    {
        $this->memberEntityService = $memberEntityService;
        $this->adminEntityService = $adminEntityService;
        $this->jwtService = $jwtService;
    }

    public function authenticate(
        Request $request
    ):bool
    {
        $sentMemberId = intval($request->request->get('memberId'));
        $sentPassword = $request->request->get('password');

        $member = $this->memberEntityService->get($sentMemberId);

        if(!$member) {
            return false;
        }

        $isAdmin = $this->adminEntityService->isAdmin($member->getId());

        if(!$isAdmin){
            return false;
        }

        $sentHashedPassword = hash('md5', $sentPassword);
        $storedPassword = $this->adminEntityService->getPasswortByMemberId($sentMemberId);

        if($sentHashedPassword == $storedPassword){
            $this->storeAuthenticationSessionVariables($request, $sentMemberId);
            return true;
        }

        return false;
    }


    public function storeAuthenticationSessionVariables(
        Request $request,
        int $memberId
    ) :void
    {
        /** @var MemberEntity $member */
        $member = $this->memberEntityService->get($memberId);
        $jwt = $this->jwtService->createJwt();
        $firstName = $member->getFirstName();
        $lastName = $member->getLastName();

        $session = $request->getSession();

        $session->set('jwt', $jwt);
        $session->set('memberId', $memberId);
        $session->set('firstName', $firstName);
        $session->set('lastName', $lastName);
        $session->set('loggedIn', true);
    }

    public function clearSession(
        Request $request
    ) :void
    {
        $session = $request->getSession();
        $session->clear();
    }

    public function isLoggedIn(Request $request)
    : bool
    {
        $session = $request->getSession();
        $state =  $session->get('loggedIn');
        if($state) return true;
        return false;
    }

}