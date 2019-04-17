<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;


class ApiController extends AbstractController
{
    protected $serializer;
    protected $em;
 
    public function __construct(SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $this->serializer = $serializer;
        $this->em = $em;
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
