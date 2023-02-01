<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseService
{
    protected $serializerService;

    public function __construct(SerializerService $serializerService)
    {
        $this->serializerService = $serializerService;
    }

    public function convertObjectToJsonResponse($object) : JsonResponse
    {
        $membersSerialized = $this->serializerService->serializeObject($object);
        return new JsonResponse($membersSerialized, 200, [], true);
    }
}