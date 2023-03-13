<?php

declare(strict_types=1);


namespace App\Service;

// use App\Entity\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;


class JwtService
{
    private string $key = "test";

    public function __construct(protected ParameterBagInterface $parameterBag)
    {
//        $this->key = $this->parameterBag->get('jwt_key');
    }

    public function createJwt() : String
    {
        $payload = [
            'role' => 'admin'
        ];
        // Converts and signs a PHP object or array into a JWT string.
        return JWT::encode($payload, $this->key, 'HS256');
    }

    // checks if request has correct jwt
    public function checkJwt(
        Request $request
    ) : bool{
        // check, if bearer token exists in the header and if it is at the right position
        if(!$request->headers->has('Authorization') ||
            !strpos($request->headers->get('Authorization'), 'Bearer ') == 0)
        {
            return false;
        }

        $jwt = substr($request->headers->get('Authorization'), 7);
        $decoded = JWT::decode($jwt, new Key($this->key, 'HS256'));
        $decoded_array = (array) $decoded;

        if($decoded_array['role'] == 'admin'){
            return true;
        }
        return false;
    }
}