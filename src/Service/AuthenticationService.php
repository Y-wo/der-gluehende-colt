<?php

namespace App\Service;

class AuthenticationService
{

    protected $adminEntityService;

    public function __construct(AdminEntityService $adminEntityService)
    {
        $this->adminEntityService = $adminEntityService;
    }

    public function checkLoginData(
        int $memberId,
        string $password
    ) : bool
    {
        $storedPassword = $this
            ->adminEntityService
            ->getPasswortByMemberId($memberId);

        return $storedPassword;


        return $password == $storedPassword;
    }

}