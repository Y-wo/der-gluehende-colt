<?php

namespace App\Service;

use PHPUnit\Util\Json;
use Symfony\Component\Serializer\SerializerInterface;

class SerializerService
{
    protected $serializerInterface;

    public function __construct(SerializerInterface $serializerInterface)
    {
        $this->serializerInterface = $serializerInterface;
    }

    public Function serializeObject($object) : String
    {
        return $this->serializerInterface->serialize(
            $object,
            "json",
            //this removes unusable variables resulting from Doctrines 'Many-To-One-Logic'
            [
                'ignored_attributes' => [
                    '__initializer__',
                    '__cloner__',
                    '__isInitialized__'
                ]
            ]
        );
    }

}