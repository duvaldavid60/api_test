<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use App\Entity\LogRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class LogRequestListener
{
    private $entityManager;
    private $stopwatch;

    public function __construct(EntityManagerInterface $entityManager, Stopwatch $stopwatch)
    {
        $this->entityManager = $entityManager;
        $this->stopwatch = $stopwatch;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $requestTime = null;
        if ($this->stopwatch->isStarted('request')) {
            $requestTime = $this->stopwatch->stop('request')->getDuration();
        }
        $newLog = new LogRequest();

        $newLog->setUrl($event->getRequest()->getUri());
        $newLog->setResponseCode($response->getStatusCode());
        $newLog->setResponseTime($requestTime);

        $this->entityManager->persist($newLog);
        $this->entityManager->flush();
    }
}
