<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    protected $serializer;
 
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    protected function response($responseData, $resultCode, $enableCache = false, $cacheTtl = 60): Response
    {
        $response = new Response(
            $this->serializer->serialize($responseData, 'json'),
            $resultCode,
            ['Content-type' => 'application/json']
        );

        if ($enableCache) {
            $response->setSharedMaxAge($cacheTtl);
        }

        return $response;
    }
}
